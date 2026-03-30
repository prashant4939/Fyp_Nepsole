<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        
        // Get total products owned by this vendor
        $totalProducts = Product::where('vendor_id', $vendor->id)->count();
        
        // Get total orders (order items) for this vendor
        $totalOrders = OrderItem::where('vendor_id', $vendor->id)->count();
        
        // Get revenue data
        $revenueData = $this->getRevenueData($vendor->id);
        
        return view('vendor.dashboard', compact('totalProducts', 'totalOrders', 'revenueData'));
    }
    
    private function getRevenueData($vendorId)
    {
        // Get weekly revenue (last 7 days)
        $weeklyRevenue = OrderItem::where('vendor_id', $vendorId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('status', 'confirmed')
            ->sum('total_price');
        
        // Get monthly revenue (last 30 days)
        $monthlyRevenue = OrderItem::where('vendor_id', $vendorId)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->where('status', 'confirmed')
            ->sum('total_price');
        
        // Get yearly revenue (last 365 days)
        $yearlyRevenue = OrderItem::where('vendor_id', $vendorId)
            ->where('created_at', '>=', Carbon::now()->subDays(365))
            ->where('status', 'confirmed')
            ->sum('total_price');
        
        return [
            'weekly' => $weeklyRevenue,
            'monthly' => $monthlyRevenue,
            'yearly' => $yearlyRevenue
        ];
    }
}

