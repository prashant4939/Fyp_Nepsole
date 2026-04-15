<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentOrders = Order::with(['orderItems.product.images'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $totalOrders   = Order::where('user_id', auth()->id())->count();
        $pendingOrders = Order::where('user_id', auth()->id())->where('order_status', 'pending')->count();

        return view('customer.dashboard', compact('recentOrders', 'totalOrders', 'pendingOrders'));
    }
}
