<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Mail\OrderItemConfirmed;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display orders containing vendor's products
     */
    public function index()
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            return redirect()->route('vendor.dashboard')->with('error', 'Vendor profile not found.');
        }

        // Get orders that have items from this vendor
        $orders = Order::whereHas('orderItems', function($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })
        ->with(['user', 'shippingAddress', 'orderItems' => function($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id)->with(['product.images', 'product.brand', 'variant']);
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('vendor.orders.index', compact('orders'));
    }

    /**
     * Display order details with only vendor's items
     */
    public function show(Order $order)
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            return redirect()->route('vendor.dashboard')->with('error', 'Vendor profile not found.');
        }

        // Check if this order has items from this vendor
        $hasVendorItems = $order->orderItems()->where('vendor_id', $vendor->id)->exists();
        
        if (!$hasVendorItems) {
            return redirect()->route('vendor.orders.index')->with('error', 'Order not found.');
        }

        // Load only vendor's items
        $order->load(['user', 'shippingAddress', 'orderItems' => function($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id)->with(['product.images', 'product.brand', 'variant']);
        }]);

        return view('vendor.orders.show', compact('order'));
    }

    /**
     * Update order item status (confirm or cancel)
     */
    public function updateItemStatus(Request $request, OrderItem $orderItem)
    {
        $vendor = auth()->user()->vendor;
        
        if (!$vendor) {
            return back()->with('error', 'Vendor profile not found.');
        }

        // Check if this item belongs to this vendor
        if ($orderItem->vendor_id !== $vendor->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Validate status
        $request->validate([
            'status' => 'required|in:confirmed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            $orderItem->status = $request->status;
            $orderItem->save();

            // Check if all items in the order are confirmed
            $order = $orderItem->order;
            if ($order->allItemsConfirmed()) {
                $order->order_status = 'confirmed';
                $order->save();
            }

            DB::commit();

            // Send confirmation email to customer when vendor confirms
            if ($request->status === 'confirmed') {
                try {
                    $order->load('user', 'shippingAddress');
                    $orderItem->load('product');
                    Mail::to($order->user->email)->send(new OrderItemConfirmed($order, $orderItem));
                } catch (\Exception $e) {
                    \Log::error('Order confirmation email failed: ' . $e->getMessage());
                }
            }

            $message = $request->status === 'confirmed' 
                ? 'Order item confirmed successfully.' 
                : 'Order item cancelled successfully.';

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update order item status: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to update order item status: ' . $e->getMessage());
        }
    }
}
