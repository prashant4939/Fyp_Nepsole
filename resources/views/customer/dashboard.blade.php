@extends('layouts.dashboard')

@section('title', 'Customer Dashboard - NepSole')
@section('panel-name', 'Customer Panel')
@section('page-title', 'Dashboard')
@section('navbar-color', '#f59e0b')

@section('sidebar-nav')
<div class="nav-section">
    <div class="nav-section-title">Main</div>
    <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
        <span class="nav-icon">📊</span>
        Dashboard
    </a>
    <a href="{{ route('products.index') }}" class="nav-link">
        <span class="nav-icon">🏠</span>
        Browse Products
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Orders</div>
    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <span class="nav-icon">📋</span>
        My Orders
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Shopping</div>
    <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
        <span class="nav-icon">🛒</span>
        Shopping Cart
    </a>
    <a href="{{ route('wishlist.index') }}" class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
        <span class="nav-icon">❤️</span>
        Wishlist
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Account</div>
    <a href="{{ route('settings.profile') }}" class="nav-link {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
        <span class="nav-icon">👤</span>
        Profile
    </a>
    <a href="{{ route('settings.change-password') }}" class="nav-link {{ request()->routeIs('settings.change-password') ? 'active' : '' }}">
        <span class="nav-icon">🔒</span>
        Change Password
    </a>
</div>
@endsection

@section('content')
<div class="welcome-card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>You are logged in as a Customer.</p>
    <span class="role-badge">Customer</span>
</div>

{{-- Stats Row --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-num">{{ $totalOrders }}</div>
        <div class="stat-label">Total Orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-num">{{ $pendingOrders }}</div>
        <div class="stat-label">Pending Orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">❤️</div>
        <div class="stat-num">{{ auth()->user()->wishlists()->count() }}</div>
        <div class="stat-label">Wishlist Items</div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="section-header">
    <h3>Recent Orders</h3>
    <a href="{{ route('orders.index') }}" class="view-all">View All →</a>
</div>

@if($recentOrders->isEmpty())
    <div class="empty-orders">
        <span style="font-size:2.5rem;">📦</span>
        <p>No orders yet. <a href="{{ route('products.index') }}">Start shopping!</a></p>
    </div>
@else
    <div class="orders-list">
        @foreach($recentOrders as $order)
        <div class="order-row">
            <div class="order-info">
                <span class="order-id">#{{ $order->id }}</span>
                <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <div class="order-items-thumb">
                @foreach($order->orderItems->take(3) as $item)
                    @if($item->product && $item->product->images->count() > 0)
                        <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                             alt="{{ $item->product->name }}">
                    @else
                        <div class="thumb-placeholder">👟</div>
                    @endif
                @endforeach
                @if($order->orderItems->count() > 3)
                    <span class="more-badge">+{{ $order->orderItems->count() - 3 }}</span>
                @endif
            </div>
            <div class="order-total">Rs. {{ number_format($order->total_price, 2) }}</div>
            <div>
                <span class="status-badge status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
            </div>
            <a href="{{ route('orders.show', $order) }}" class="btn-detail">View →</a>
        </div>
        @endforeach
    </div>
@endif

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-icon">🛒</div>
        <h3>Continue Shopping</h3>
        <p>Discover new products and great deals</p>
        <a href="{{ route('products.index') }}" class="card-button">Browse Products</a>
    </div>
    <div class="dashboard-card">
        <div class="card-icon">❤️</div>
        <h3>Wishlist</h3>
        <p>Save your favorite products for later</p>
        <a href="{{ route('wishlist.index') }}" class="card-button">View Wishlist</a>
    </div>
    <div class="dashboard-card">
        <div class="card-icon">👤</div>
        <h3>Profile</h3>
        <p>Manage your account information</p>
        <a href="{{ route('settings.profile') }}" class="card-button">Edit Profile</a>
    </div>
</div>

<style>
/* Stats */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}
.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}
.stat-icon { font-size: 1.75rem; margin-bottom: 0.5rem; }
.stat-num  { font-size: 2rem; font-weight: 800; color: #f59e0b; }
.stat-label { font-size: 13px; color: #6b7280; margin-top: 2px; }

/* Section header */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}
.section-header h3 { font-size: 1.1rem; font-weight: 700; color: #111827; }
.view-all { font-size: 13px; color: #f59e0b; font-weight: 600; text-decoration: none; }
.view-all:hover { text-decoration: underline; }

/* Orders list */
.orders-list {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 2rem;
}
.order-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    flex-wrap: wrap;
}
.order-row:last-child { border-bottom: none; }
.order-id   { font-weight: 700; color: #111827; font-size: 14px; display: block; }
.order-date { font-size: 12px; color: #9ca3af; }
.order-info { min-width: 90px; }
.order-items-thumb { display: flex; gap: 4px; align-items: center; }
.order-items-thumb img,
.thumb-placeholder {
    width: 40px; height: 40px; border-radius: 6px;
    object-fit: cover; border: 1px solid #e5e7eb;
    background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 16px;
}
.more-badge { font-size: 11px; color: #9ca3af; font-weight: 600; }
.order-total { font-weight: 700; color: #111827; font-size: 14px; flex: 1; }

.status-badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
.status-pending    { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-confirmed  { background: #d1fae5; color: #065f46; }
.status-dispatched { background: #e0e7ff; color: #3730a3; }
.status-cancelled  { background: #fee2e2; color: #991b1b; }

.btn-detail {
    padding: 5px 14px; background: #f3f4f6; color: #374151;
    border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600;
    transition: all 0.2s; white-space: nowrap;
}
.btn-detail:hover { background: #f59e0b; color: white; }

.empty-orders {
    background: white; border-radius: 12px; padding: 2.5rem;
    text-align: center; margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}
.empty-orders p { color: #6b7280; margin-top: 0.75rem; font-size: 14px; }
.empty-orders a { color: #f59e0b; font-weight: 600; text-decoration: none; }

/* Dashboard cards */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}
.dashboard-card {
    background: white;
    border-radius: 12px;
    padding: 1.75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}
.dashboard-card:hover { transform: translateY(-2px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
.card-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.dashboard-card h3 { color: #1f2937; margin-bottom: 0.5rem; font-size: 1.1rem; }
.dashboard-card p  { color: #6b7280; margin-bottom: 1.25rem; font-size: 13px; }
.card-button {
    background: #f59e0b; color: white;
    padding: 0.65rem 1.5rem; border-radius: 8px;
    text-decoration: none; font-weight: 600; font-size: 13px;
    transition: background 0.2s; display: inline-block;
}
.card-button:hover { background: #d97706; color: white; }

@media (max-width: 640px) {
    .stats-row { grid-template-columns: 1fr 1fr; }
    .order-row { gap: 0.5rem; }
}
</style>
@endsection
