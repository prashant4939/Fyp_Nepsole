@extends('layouts.dashboard')

@section('title', 'Orders - Admin')
@section('panel-name', 'Admin Panel')
@section('page-title', 'Confirmed Orders')
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@section('content')

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="alert alert-info">
            <strong>Note:</strong> Only orders where all vendors have confirmed their items are shown here.
        </div>

        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
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
                            <td>Rs. {{ number_format($order->total_price, 2) }}</td>
                            <td>{{ $order->payment_method_label }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @else
            <div class="alert alert-info">
                No confirmed orders found. Orders will appear here once all vendors confirm their items.
            </div>
        @endif
    </div>

    <style>
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #3b82f6;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table-bordered {
            border: 1px solid #e5e7eb;
        }
        
        .table-hover tbody tr:hover {
            background: #f9fafb;
        }
        
        .table thead {
            background: #f3f4f6;
        }
        
        .table th, .table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .bg-success {
            background: #10b981;
            color: white;
        }
        
        .bg-warning {
            background: #f59e0b;
            color: white;
        }
        
        .bg-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
        }
        
        .mt-3 {
            margin-top: 1rem;
        }
    </style>
@endsection
