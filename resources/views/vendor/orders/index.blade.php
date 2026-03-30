@extends('layouts.dashboard')

@section('title', 'My Orders - Vendor')
@section('panel-name', 'Vendor Panel')
@section('page-title', 'My Orders')
@section('navbar-color', '#10b981')

@section('sidebar-nav')
@include('vendor.partials.sidebar')
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

@if($orders->count() > 0)
    <div class="orders-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->orderItems->count() }} item(s)</td>
                    <td>Rs. {{ number_format($order->orderItems->sum('total_price'), 2) }}</td>
                    <td>
                        <span class="badge badge-{{ $order->status_color }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('vendor.orders.show', $order) }}" class="btn-view">
                            View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $orders->links() }}
    </div>
@else
    <div class="empty-state">
        No orders found.
    </div>
@endif

<style>
.alert {
    padding: 1rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.orders-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table thead {
    background: #f9fafb;
}

.orders-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    border-bottom: 2px solid #e5e7eb;
}

.orders-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    color: #6b7280;
    font-size: 0.875rem;
}

.orders-table tbody tr:hover {
    background: #f9fafb;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-info {
    background: #dbeafe;
    color: #1e40af;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-primary {
    background: #dbeafe;
    color: #1e40af;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.btn-view {
    background: #10b981;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: background 0.2s;
    display: inline-block;
}

.btn-view:hover {
    background: #059669;
}

.empty-state {
    background: white;
    padding: 3rem;
    border-radius: 12px;
    text-align: center;
    color: #6b7280;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.pagination-wrapper {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .orders-container {
        overflow-x: auto;
    }
    
    .orders-table {
        min-width: 800px;
    }
}
</style>
@endsection
