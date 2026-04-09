<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\NewOrderForVendor;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    /**
     * Handle order placement for both COD and Khalti.
     * Called when user clicks "Place Order" on checkout page.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'payment_method'      => 'required|in:cod,khalti',
        ]);

        $shippingAddress = ShippingAddress::where('id', $request->shipping_address_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItems = Cart::with('product.vendor', 'variant')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 400);
        }

        // Stock check
        foreach ($cartItems as $item) {
            if (!$item->variant || $item->variant->stock < $item->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for {$item->product->name} (Size: {$item->variant?->size})."
                ], 400);
            }
        }

        if ($request->payment_method === 'khalti') {
            return $this->handleKhalti($request, $shippingAddress, $cartItems);
        }

        return $this->handleCOD($request, $shippingAddress, $cartItems);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // COD
    // ─────────────────────────────────────────────────────────────────────────

    private function handleCOD($request, $shippingAddress, $cartItems)
    {
        try {
            DB::beginTransaction();

            $order = $this->createOrder($shippingAddress, $cartItems, 'cod');
            $this->createOrderItems($order, $cartItems);

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return response()->json([
                'success'  => true,
                'message'  => 'Order placed successfully!',
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('COD order error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to place order. Please try again.'], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // KHALTI — Step 1: Initiate
    // ─────────────────────────────────────────────────────────────────────────

    private function handleKhalti($request, $shippingAddress, $cartItems)
    {
        try {
            DB::beginTransaction();

            $order      = $this->createOrder($shippingAddress, $cartItems, 'khalti');
            $this->createOrderItems($order, $cartItems);
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            $totalPaisa = (int) ($order->total_price * 100);

            // Call Khalti Payment Initiation API v2
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . config('services.khalti.secret_key'),
                'Content-Type'  => 'application/json',
            ])->post(config('services.khalti.initiate_url'), [
                'return_url'          => route('payment.khalti.callback'),
                'website_url'         => config('app.url'),
                'amount'              => $totalPaisa,
                'purchase_order_id'   => 'ORDER-' . $order->id,
                'purchase_order_name' => 'NepSole Order #' . $order->id,
                'customer_info'       => [
                    'name'  => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '9800000000',
                ],
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['payment_url'])) {
                // Store pidx so we can verify on callback
                $order->update(['transaction_id' => $data['pidx']]);

                return response()->json([
                    'success'     => true,
                    'redirect'    => true,
                    'payment_url' => $data['payment_url'],
                ]);
            }

            // Khalti API failed — rollback
            $order->orderItems()->delete();
            $order->delete();

            Log::error('Khalti API failed', ['response' => $data]);

            return response()->json([
                'success' => false,
                'message' => $data['detail'] ?? 'Failed to connect to Khalti. Please try again.',
            ], 500);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Khalti initiate error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment initiation failed. Please try again.'], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // KHALTI — Step 2: Callback (Khalti redirects here after payment)
    // ─────────────────────────────────────────────────────────────────────────

    public function khaltiCallback(Request $request)
    {
        $pidx = $request->query('pidx');

        if (!$pidx) {
            return redirect()->route('checkout.index')->with('error', 'Invalid payment callback.');
        }

        $order = Order::where('transaction_id', $pidx)
            ->where('user_id', Auth::id())
            ->where('payment_method', 'khalti')
            ->first();

        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Order not found.');
        }

        // Already verified
        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.success', $order->id);
        }

        // Verify with Khalti Lookup API — source of truth
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . config('services.khalti.secret_key'),
                'Content-Type'  => 'application/json',
            ])->post(config('services.khalti.lookup_url'), ['pidx' => $pidx]);

            $data = $response->json();

            if ($response->successful() && ($data['status'] ?? '') === 'Completed') {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_amount'    => ($data['total_amount'] ?? $order->total_price * 100) / 100,
                    'order_status'   => 'processing',
                ]);

                return redirect()->route('orders.success', $order->id)
                    ->with('success', 'Payment successful! Your order has been placed.');
            }

            $order->update(['payment_status' => 'failed']);

            Log::warning('Khalti payment not completed', [
                'order_id' => $order->id,
                'status'   => $data['status'] ?? 'unknown',
            ]);

            return redirect()->route('checkout.index')
                ->with('error', 'Payment was not completed. Status: ' . ($data['status'] ?? 'Unknown'));

        } catch (\Exception $e) {
            Log::error('Khalti callback error: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', 'Payment verification failed. Contact support with Order #' . $order->id);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function createOrder($shippingAddress, $cartItems, string $paymentMethod): Order
    {
        $subtotal   = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);
        $shipping   = $cartItems->count() * 100;
        $totalPrice = $subtotal + $shipping;

        return Order::create([
            'user_id'             => Auth::id(),
            'order_status'        => 'pending',
            'total_price'         => $totalPrice,
            'payment_method'      => $paymentMethod,
            'payment_status'      => 'pending',
            'shipping_address_id' => $shippingAddress->id,
        ]);
    }

    private function createOrderItems(Order $order, $cartItems): void
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'           => $order->id,
                'product_id'         => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'size'               => $item->variant->size,
                'quantity'           => $item->quantity,
                'unit_price'         => $item->product->price,
                'vendor_id'          => $item->product->vendor_id,
            ]);

            $item->variant->decrement('stock', $item->quantity);
            $item->product->increment('sold', $item->quantity);
        }

        // Notify each vendor about their items in this order
        $this->notifyVendors($order);
    }

    private function notifyVendors(Order $order): void
    {
        $order->load('orderItems.product', 'shippingAddress', 'user');

        $vendorIds = $order->orderItems->pluck('vendor_id')->unique();

        foreach ($vendorIds as $vendorId) {
            $vendor = Vendor::with('user')->find($vendorId);
            if ($vendor && $vendor->user && $vendor->user->email) {
                try {
                    Mail::to($vendor->user->email)->send(new NewOrderForVendor($order, $vendor));
                } catch (\Exception $e) {
                    Log::error("Vendor order notification failed (vendor #{$vendorId}): " . $e->getMessage());
                }
            }
        }
    }
}
