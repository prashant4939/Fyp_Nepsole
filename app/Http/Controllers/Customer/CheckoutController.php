<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get cart items
        $cartItems = Cart::with(['product.images', 'product.vendor', 'variant'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        // Shipping fee: Rs. 100 per product (not per quantity)
        $shippingFee = $cartItems->count() * 100;
        $total = $subtotal + $shippingFee;

        // Get user's shipping addresses
        $shippingAddresses = Auth::user()->shippingAddresses()->latest()->get();
        $defaultAddress = $shippingAddresses->where('is_default', true)->first();

        return view('customer.checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'shippingAddresses', 'defaultAddress'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'payment_method' => 'required|in:cod,khalti'
        ]);

        // Verify shipping address belongs to user
        $shippingAddress = ShippingAddress::where('id', $request->shipping_address_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Get cart items
        $cartItems = Cart::with('product.vendor', 'variant')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Check stock availability for each cart item
        foreach ($cartItems as $cartItem) {
            if (!$cartItem->variant) {
                return response()->json([
                    'success' => false,
                    'message' => "Variant not found for {$cartItem->product->name}"
                ], 400);
            }
            
            if ($cartItem->variant->stock < $cartItem->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for {$cartItem->product->name} (Size: {$cartItem->variant->size}). Available: {$cartItem->variant->stock}, Requested: {$cartItem->quantity}"
                ], 400);
            }
        }

        // Calculate total
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        // Shipping fee: Rs. 100 per product
        $shippingFee = $cartItems->count() * 100;
        $totalPrice = $subtotal + $shippingFee;

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_status' => 'pending',
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
                'shipping_address_id' => $shippingAddress->id
            ]);

            // Create order items and reduce stock
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_variant_id' => $cartItem->product_variant_id,
                    'size' => $cartItem->variant->size,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->price,
                    'vendor_id' => $cartItem->product->vendor_id
                ]);
                
                // Reduce stock from the specific variant
                $cartItem->variant->decrement('stock', $cartItem->quantity);
                
                // Update product sold count
                $cartItem->product->increment('sold', $cartItem->quantity);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.'
            ], 500);
        }
    }
}
