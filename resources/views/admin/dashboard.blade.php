@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - NepSole')
@section('panel-name', 'Admin Panel')
@section('navbar-color', '#6366f1')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        color: #111827;
        font-size: 1.875rem;
        font-weight: 700;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
    }

    .btn-link {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        text-align: left;
        padding: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        color: #111827;
        font-size: 0.875rem;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-processing { background: #dbeafe; color: #1e40af; }
    .badge-completed { background: #d1fae5; color: #065f46; }
    .badge-cancelled { background: #fee2e2; color: #991b1b; }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
</style>
@endpush

@section('content')
<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-label">Total Customers</div>
        <div class="stat-value">{{ $stats['total_customers'] }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🏪</div>
        <div class="stat-label">Total Vendors</div>
        <div class="stat-value">{{ $stats['total_vendors'] }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value">Rs. {{ number_format($stats['total_revenue'], 2) }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-label">Pending Orders</div>
        <div class="stat-value">{{ $stats['pending_orders'] }}</div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="section-header">
        <h2 class="section-title">Quick Actions</h2>
    </div>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('admin.customers') }}" style="padding: 0.75rem 1.5rem; background: #6366f1; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
            Manage Customers
        </a>
        <a href="{{ route('admin.vendors') }}" style="padding: 0.75rem 1.5rem; background: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
            Manage Vendors
        </a>
    </div>
</div>

<!-- Recent Orders -->
<div class="card">
    <div class="section-header">
        <h2 class="section-title">Recent Orders</h2>
    </div>
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Vendor</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->vendor->name }}</td>
                    <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                    <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #9ca3af;">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Top Performers -->
<div class="grid-2">
    <div class="card">
        <h3 class="section-title">Top Customers</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCustomers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->orders_as_customer_count }}</td>
                    <td>Rs. {{ number_format($customer->orders_as_customer_sum_total_amount ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #9ca3af;">No data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="section-title">Top Vendors</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Orders</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topVendors as $vendor)
                <tr>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ $vendor->orders_as_vendor_count }}</td>
                    <td>Rs. {{ number_format($vendor->orders_as_vendor_sum_total_amount ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #9ca3af;">No data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
