@extends('layouts.dashboard')

@section('title', 'Order #' . $order->id . ' - Admin')
@section('panel-name', 'Admin Panel')
@section('page-title', 'Order #' . $order->id)
@section('navbar-color', '#6366f1')

@section('sidebar-nav')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="mb-3">
    @if($order->isConfirmed())
        <form action="{{ route('admin.orders.dispatch', $order) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success" 
                    onclick="return confirm('Dispatch this order? Customer will be notified via email.')">
                <i class="bi bi-truck"></i> Dispatch Order
            </button>
        </form>
    @endif
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Back to Orders</a>
</div>

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

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Order Items</h5>
                    </div>
                    <div class="card-body">
                        @foreach($order->orderItems as $item)
                        <div class="order-item-card mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    @if($item->product->images->first())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="img-fluid rounded" 
                                             style="width: 100%; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 100%; height: 100px;">
                                            <span class="text-muted">No Image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                    @if($item->size)
                                        <p class="mb-1 small" style="color: #10b981; font-weight: 600;">Size: {{ $item->size }}</p>
                                    @endif
                                    <p class="text-muted mb-0 small">{{ $item->product->brand->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block">Vendor</small>
                                    <strong class="small">{{ $item->vendor->business_name }}</strong>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block">Quantity</small>
                                    <strong>{{ $item->quantity }}</strong>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block">Price</small>
                                    <strong>Rs. {{ number_format($item->unit_price, 2) }}</strong>
                                    <div class="text-muted small">Total: Rs. {{ number_format($item->total_price, 2) }}</div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <span class="badge bg-{{ $item->status_color }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="border-top pt-3 mt-3">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>Total:</strong>
                                        <strong>Rs. {{ number_format($order->total_price, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Order Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Order Date:</strong><br>{{ $order->created_at->format('F d, Y h:i A') }}</p>
                        <p><strong>Order Status:</strong><br>
                            <span class="badge bg-{{ $order->status_color }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </p>
                        <p><strong>Payment Method:</strong><br>{{ $order->payment_method_label }}</p>
                        <p><strong>Total Amount:</strong><br>Rs. {{ number_format($order->total_price, 2) }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong><br>{{ $order->user->name }}</p>
                        <p><strong>Email:</strong><br>{{ $order->user->email }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>{{ $order->shippingAddress->full_name }}</strong><br>
                            {{ $order->shippingAddress->address }}<br>
                            {{ $order->shippingAddress->city }}<br>
                            Landmark: {{ $order->shippingAddress->landmark }}<br>
                            Phone: {{ $order->shippingAddress->phone }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .order-item-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            background: #f9fafb;
            transition: box-shadow 0.2s;
        }
        
        .order-item-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .order-item-card h6 {
            color: #1f2937;
            font-weight: 600;
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
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
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
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
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
        
        .mb-3 {
            margin-bottom: 1rem;
        }
        
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -0.75rem;
        }
        
        .col-md-2, .col-md-3, .col-md-4, .col-md-8 {
            padding: 0 0.75rem;
        }
        
        .col-md-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
        
        .col-md-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
        
        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
        
        .col-md-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }
        
        .img-fluid {
            max-width: 100%;
            height: auto;
        }
        
        .rounded {
            border-radius: 8px;
        }
        
        .text-muted {
            color: #6b7280;
        }
        
        .small {
            font-size: 0.875rem;
        }
        
        .d-flex {
            display: flex;
        }
        
        .align-items-center {
            align-items: center;
        }
        
        .justify-content-center {
            justify-content: center;
        }
        
        .justify-content-between {
            justify-content: space-between;
        }
        
        .bg-light {
            background: #f3f4f6;
        }
        
        .border-top {
            border-top: 1px solid #e5e7eb;
        }
        
        .pt-3 {
            padding-top: 1rem;
        }
        
        .mt-3 {
            margin-top: 1rem;
        }
        
        .d-inline {
            display: inline;
        }
    </style>
@endsection
