<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderItemStatusUpdated;

class OrderController extends Controller
{
    /**
     * Display orders where all items are confirmed
     */
    public function index()
    {
        $orders = Order::where('order_status', 'confirmed')
            ->with(['user', 'shippingAddress', 'orderItems.product.images', 'orderItems.product.brand', 'orderItems.vendor', 'orderItems.variant'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display full order details
     */
    public function show(Order $order)
    {
        $order->load(['user', 'shippingAddress', 'orderItems.product.images', 'orderItems.product.brand', 'orderItems.vendor', 'orderItems.variant']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Dispatch order and send email notification
     */
    public function dispatch(Order $order)
    {
        // Check if order is confirmed
        if (!$order->isConfirmed()) {
            return back()->with('error', 'Only confirmed orders can be dispatched.');
        }

        try {
            DB::beginTransaction();

            $order->order_status = 'dispatched';
            $order->save();

            // Send email notification to customer
            Mail::to($order->user->email)->send(new OrderItemStatusUpdated($order));

            DB::commit();

            return back()->with('success', 'Order dispatched successfully. Customer has been notified via email.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to dispatch order: ' . $e->getMessage());
        }
    }
}
