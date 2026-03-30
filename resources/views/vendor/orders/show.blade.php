@extends('layouts.dashboard')

@section('title', 'Order #' . $order->id . ' - Vendor')
@section('panel-name', 'Vendor Panel')
@section('page-title', 'Order #' . $order->id)
@section('navbar-color', '#10b981')

@section('sidebar-nav')
@include('vendor.partials.sidebar')
@endsection

@section('content')
<div class="back-button-wrapper">
    <a href="{{ route('vendor.orders.index') }}" class="btn-back">← Back to Orders</a>
</div>

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

<div class="order-layout">
    <div class="order-items-section">
        <div class="card">
            <div class="card-header">
                <h3>Order Items</h3>
            </div>
            <div class="card-body">
                @foreach($order->orderItems as $item)
                <div class="order-item-card">
                    <div class="item-image">
                        @php
                            $hasImages = $item->product->images->count() > 0;
                            $firstImage = $hasImages ? $item->product->images->first() : null;
                        @endphp
                        
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage->image) }}" 
                                 alt="{{ $item->product->name }}">
                        @else
                            <div class="no-image">No Image</div>
                        @endif
                    </div>
                    <div class="item-details">
                        <h4>{{ $item->product->name }}</h4>
                        @if($item->size)
                            <p class="size-info">Size: <strong>{{ $item->size }}</strong></p>
                        @endif
                        <p class="brand">{{ $item->product->brand->name ?? 'N/A' }}</p>
                    </div>
                    <div class="item-quantity">
                        <span class="label">Quantity</span>
                        <strong>{{ $item->quantity }}</strong>
                    </div>
                    <div class="item-price">
                        <span class="label">Price</span>
                        <strong>Rs. {{ number_format($item->unit_price, 2) }}</strong>
                        <div class="total">Total: Rs. {{ number_format($item->total_price, 2) }}</div>
                    </div>
                    <div class="item-actions">
                        <span class="badge badge-{{ $item->status_color }}">
                            {{ ucfirst($item->status) }}
                        </span>
                        @if($item->isPending())
                            <form action="{{ route('vendor.orders.update-item-status', $item) }}" method="POST" class="action-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn-confirm" 
                                        onclick="return confirm('Confirm this order item?')">
                                    ✓ Confirm
                                </button>
                            </form>
                            <form action="{{ route('vendor.orders.update-item-status', $item) }}" method="POST" class="action-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn-cancel" 
                                        onclick="return confirm('Cancel this order item?')">
                                    ✕ Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
                
                <div class="order-total">
                    <span>Subtotal:</span>
                    <strong>Rs. {{ number_format($order->orderItems->sum('total_price'), 2) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="order-info-section">
        <div class="card">
            <div class="card-header">
                <h3>Order Information</h3>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <strong>Order Date:</strong>
                    <span>{{ $order->created_at->format('F d, Y h:i A') }}</span>
                </div>
                <div class="info-item">
                    <strong>Order Status:</strong>
                    <span class="badge badge-{{ $order->status_color }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                <div class="info-item">
                    <strong>Payment Method:</strong>
                    <span>{{ $order->payment_method_label }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Customer Information</h3>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <strong>Name:</strong>
                    <span>{{ $order->user->name }}</span>
                </div>
                <div class="info-item">
                    <strong>Email:</strong>
                    <span>{{ $order->user->email }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Shipping Address</h3>
            </div>
            <div class="card-body">
                <div class="address-info">
                    <strong>{{ $order->shippingAddress->full_name }}</strong><br>
                    {{ $order->shippingAddress->address }}<br>
                    {{ $order->shippingAddress->city }}<br>
                    Landmark: {{ $order->shippingAddress->landmark }}<br>
                    Phone: {{ $order->shippingAddress->phone }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.back-button-wrapper {
    margin-bottom: 1.5rem;
}

.btn-back {
    background: white;
    color: #6b7280;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    border: 1px solid #e5e7eb;
    display: inline-block;
    transition: all 0.2s;
}

.btn-back:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}

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

.order-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.card-header {
    padding: 1.25rem;
    border-bottom: 1px solid #f3f4f6;
}

.card-header h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
}

.card-body {
    padding: 1.25rem;
}

.order-item-card {
    display: grid;
    grid-template-columns: 100px 2fr 1fr 1fr 1fr;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 1rem;
    border: 1px solid #e5e7eb;
}

.item-image img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}

.no-image {
    width: 100px;
    height: 100px;
    background: #e5e7eb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 0.75rem;
}

.item-details h4 {
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
}

.item-details .size-info {
    margin: 0 0 0.25rem 0;
    font-size: 0.875rem;
    color: #10b981;
    font-weight: 500;
}

.item-details .size-info strong {
    color: #059669;
    font-weight: 700;
}

.item-details .brand {
    margin: 0;
    font-size: 0.875rem;
    color: #6b7280;
}

.item-quantity, .item-price {
    text-align: center;
}

.label {
    display: block;
    font-size: 0.75rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.item-price .total {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.item-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: stretch;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    text-align: center;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.action-form {
    margin: 0;
}

.btn-confirm, .btn-cancel {
    width: 100%;
    padding: 0.5rem;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-confirm {
    background: #10b981;
    color: white;
}

.btn-confirm:hover {
    background: #059669;
}

.btn-cancel {
    background: white;
    color: #ef4444;
    border: 1px solid #fecaca;
}

.btn-cancel:hover {
    background: #fef2f2;
}

.order-total {
    display: flex;
    justify-content: space-between;
    padding-top: 1rem;
    margin-top: 1rem;
    border-top: 2px solid #e5e7eb;
    font-size: 1.125rem;
}

.info-item {
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item strong {
    display: block;
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.info-item span {
    color: #111827;
    font-size: 0.9375rem;
}

.address-info {
    color: #374151;
    line-height: 1.6;
}

@media (max-width: 1024px) {
    .order-layout {
        grid-template-columns: 1fr;
    }
    
    .order-item-card {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .item-image {
        justify-self: center;
    }
}
</style>
@endsection
