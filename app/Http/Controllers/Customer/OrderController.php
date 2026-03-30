<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.product.images', 'shippingAddress'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Verify ownership
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['orderItems.product.images', 'orderItems.vendor', 'shippingAddress']);

        return view('customer.orders.show', compact('order'));
    }

    public function success($orderId)
    {
        $order = Order::with(['orderItems.product', 'shippingAddress'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('customer.orders.success', compact('order'));
    }
}
