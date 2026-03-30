<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total users (customers)
        $totalUsers = User::where('role', 'customer')->count();
        
        // Get total vendors
        $totalVendors = Vendor::count();
        
        // Get total products
        $totalProducts = \App\Models\Product::count();
        
        // Get orders dispatched count
        $ordersDispatched = \App\Models\Order::where('order_status', 'dispatched')->count();
        
        // Get vendor revenue data
        $vendorRevenueData = $this->getVendorRevenueData();
        
        return view('admin.dashboard', compact('totalUsers', 'totalVendors', 'totalProducts', 'ordersDispatched', 'vendorRevenueData'));
    }
    
    private function getVendorRevenueData()
    {
        // Get weekly revenue (last 7 days)
        $weeklyRevenue = OrderItem::select('order_items.vendor_id', 'vendors.business_name as vendor_name', DB::raw('SUM(order_items.total_price) as revenue'))
            ->join('vendors', 'order_items.vendor_id', '=', 'vendors.id')
            ->where('order_items.created_at', '>=', Carbon::now()->subDays(7))
            ->where('order_items.status', 'confirmed')
            ->groupBy('order_items.vendor_id', 'vendors.business_name')
            ->get();
        
        // Get monthly revenue (last 30 days)
        $monthlyRevenue = OrderItem::select('order_items.vendor_id', 'vendors.business_name as vendor_name', DB::raw('SUM(order_items.total_price) as revenue'))
            ->join('vendors', 'order_items.vendor_id', '=', 'vendors.id')
            ->where('order_items.created_at', '>=', Carbon::now()->subDays(30))
            ->where('order_items.status', 'confirmed')
            ->groupBy('order_items.vendor_id', 'vendors.business_name')
            ->get();
        
        // Get yearly revenue (last 365 days)
        $yearlyRevenue = OrderItem::select('order_items.vendor_id', 'vendors.business_name as vendor_name', DB::raw('SUM(order_items.total_price) as revenue'))
            ->join('vendors', 'order_items.vendor_id', '=', 'vendors.id')
            ->where('order_items.created_at', '>=', Carbon::now()->subDays(365))
            ->where('order_items.status', 'confirmed')
            ->groupBy('order_items.vendor_id', 'vendors.business_name')
            ->get();
        
        return [
            'weekly' => $weeklyRevenue,
            'monthly' => $monthlyRevenue,
            'yearly' => $yearlyRevenue
        ];
    }
}

