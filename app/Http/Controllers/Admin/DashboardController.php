<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'total_vendors' => User::where('role', 'vendor')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        // Get recent orders
        $recentOrders = Order::with(['customer', 'vendor'])
            ->latest()
            ->take(10)
            ->get();

        // Get monthly revenue
        $monthlyRevenue = Order::where('status', 'completed')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get top customers
        $topCustomers = User::where('role', 'customer')
            ->withCount('ordersAsCustomer')
            ->withSum('ordersAsCustomer', 'total_amount')
            ->orderByDesc('orders_as_customer_sum_total_amount')
            ->take(5)
            ->get();

        // Get top vendors
        $topVendors = User::where('role', 'vendor')
            ->withCount('ordersAsVendor')
            ->withSum('ordersAsVendor', 'total_amount')
            ->orderByDesc('orders_as_vendor_sum_total_amount')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'monthlyRevenue',
            'topCustomers',
            'topVendors'
        ));
    }

    public function customers()
    {
        $customers = User::where('role', 'customer')
            ->withCount('ordersAsCustomer')
            ->withSum('ordersAsCustomer', 'total_amount')
            ->latest()
            ->paginate(20);

        return view('admin.customers', compact('customers'));
    }

    public function vendors()
    {
        $vendors = User::where('role', 'vendor')
            ->withCount('ordersAsVendor')
            ->withSum('ordersAsVendor', 'total_amount')
            ->latest()
            ->paginate(20);

        return view('admin.vendors', compact('vendors'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users!');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot modify admin users!');
        }

        // Toggle email verification (as a way to enable/disable users)
        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $message = 'User disabled successfully!';
        } else {
            $user->email_verified_at = now();
            $message = 'User enabled successfully!';
        }
        
        $user->save();
        return back()->with('success', $message);
    }
}
