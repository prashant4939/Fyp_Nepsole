@extends('layouts.app')

@section('title', 'My Orders - NepSole')

@section('content')
<div class="orders-page">
    <div class="container">

        <div class="page-header">
            <h1>My Orders</h1>
            <a href="{{ route('products.index') }}" class="btn-shop">Continue Shopping</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-meta">
                        <span class="order-id">Order #{{ $order->id }}</span>
                        <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="order-badges">
                        <span class="badge badge-{{ $order->status_color }}">{{ ucfirst($order->order_status) }}</span>
                        <span class="badge {{ ($order->payment_status ?? 'pending') === 'paid' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($order->payment_status ?? 'pending') }}
                        </span>
                    </div>
                </div>

                <div class="order-items-preview">
                    @foreach($order->orderItems->take(3) as $item)
                        <div class="preview-item">
                            @if($item->product && $item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                     alt="{{ $item->product->name }}">
                            @else
                                <div class="img-placeholder">👟</div>
                            @endif
                        </div>
                    @endforeach
                    @if($order->orderItems->count() > 3)
                        <div class="more-items">+{{ $order->orderItems->count() - 3 }} more</div>
                    @endif
                </div>

                <div class="order-footer">
                    <div class="order-total">
                        <span class="total-label">Total</span>
                        <span class="total-value">Rs. {{ number_format($order->total_price, 2) }}</span>
                    </div>
                    <div class="order-payment">
                        <span class="payment-method">{{ $order->payment_method_label }}</span>
                    </div>
                    <a href="{{ route('orders.show', $order) }}" class="btn-view">View Details →</a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h2>No orders yet</h2>
                <p>You haven't placed any orders. Start shopping!</p>
                <a href="{{ route('products.index') }}" class="btn-primary">Browse Products</a>
            </div>
        @endforelse

        @if($orders->hasPages())
            <div class="pagination-wrap">
                {{ $orders->links() }}
            </div>
        @endif

    </div>
</div>

<style>
.orders-page {
    background: #f3f4f6;
    min-height: calc(100vh - 130px);
    padding: 2rem 0;
}

.container {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.page-header h1 { font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0; }

.btn-shop {
    padding: 0.5rem 1.25rem;
    background: #6366f1;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: background 0.2s;
}

.btn-shop:hover { background: #4f46e5; }

.alert { padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 14px; font-weight: 500; }
.alert-success { background: #d1fae5; color: #065f46; }

.order-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    margin-bottom: 1rem;
    transition: box-shadow 0.2s;
}

.order-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.order-id { font-weight: 700; color: #111827; font-size: 15px; }
.order-date { font-size: 12px; color: #9ca3af; margin-left: 0.75rem; }

.order-badges { display: flex; gap: 0.5rem; }

.badge { padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-warning { background: #fef3c7; color: #92400e; }
.badge-success { background: #d1fae5; color: #065f46; }
.badge-info    { background: #dbeafe; color: #1e40af; }
.badge-primary { background: #e0e7ff; color: #3730a3; }
.badge-danger  { background: #fee2e2; color: #991b1b; }

.order-items-preview {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    margin-bottom: 1rem;
}

.preview-item { width: 56px; height: 56px; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb; }
.preview-item img { width: 100%; height: 100%; object-fit: cover; }
.img-placeholder { width: 100%; height: 100%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 22px; }
.more-items { font-size: 12px; color: #9ca3af; font-weight: 600; }

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
}

.total-label { font-size: 12px; color: #9ca3af; display: block; }
.total-value { font-size: 16px; font-weight: 700; color: #111827; }
.payment-method { font-size: 13px; color: #6b7280; }

.btn-view {
    padding: 0.5rem 1.25rem;
    background: #f3f4f6;
    color: #374151;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-view:hover { background: #6366f1; color: white; }

/* Empty state */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.empty-state svg { color: #d1d5db; margin-bottom: 1rem; }
.empty-state h2 { font-size: 1.25rem; font-weight: 700; color: #374151; margin-bottom: 0.5rem; }
.empty-state p { color: #9ca3af; font-size: 14px; margin-bottom: 1.5rem; }

.btn-primary {
    display: inline-block;
    padding: 0.75rem 2rem;
    background: #6366f1;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.2s;
}

.btn-primary:hover { background: #4f46e5; }

.pagination-wrap { margin-top: 1.5rem; }

@media (max-width: 640px) {
    .order-footer { flex-wrap: wrap; gap: 0.75rem; }
    .btn-view { width: 100%; text-align: center; }
}
</style>
@endsection
