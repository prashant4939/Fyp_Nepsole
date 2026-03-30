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
    <a href="/" class="nav-link">
        <span class="nav-icon">🏠</span>
        Browse Products
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Orders</div>
    <a href="#" class="nav-link">
        <span class="nav-icon">📋</span>
        My Orders
    </a>
    <a href="#" class="nav-link">
        <span class="nav-icon">⏳</span>
        Order History
    </a>
    <a href="#" class="nav-link">
        <span class="nav-icon">🔄</span>
        Returns & Refunds
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Shopping</div>
    <a href="#" class="nav-link">
        <span class="nav-icon">🛒</span>
        Shopping Cart
    </a>
    <a href="#" class="nav-link">
        <span class="nav-icon">❤️</span>
        Wishlist
    </a>
    <a href="#" class="nav-link">
        <span class="nav-icon">⭐</span>
        Reviews
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Account</div>
    <a href="#" class="nav-link">
        <span class="nav-icon">👤</span>
        Profile
    </a>
    <a href="#" class="nav-link">
        <span class="nav-icon">📍</span>
        Addresses
    </a>
    <a href="#" class="nav-link">
        <span class="nav-icon">💳</span>
        Payment Methods
    </a>
    <a href="#" class="nav-link">
        <span class="nav-icon">⚙️</span>
        Settings
    </a>
</div>
@endsection

@section('content')
<div class="welcome-card">
    <h2>Welcome, {{ auth()->user()->name }}!</h2>
    <p>You are logged in as a Customer.</p>
    <span class="role-badge">Customer</span>
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-icon">📋</div>
        <h3>My Orders</h3>
        <p>Track your orders and view order history</p>
        <a href="#" class="card-button">View Orders</a>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon">❤️</div>
        <h3>Wishlist</h3>
        <p>Save your favorite products for later</p>
        <a href="#" class="card-button">View Wishlist</a>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon">👤</div>
        <h3>Profile</h3>
        <p>Manage your account information and preferences</p>
        <a href="#" class="card-button">Edit Profile</a>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon">🛒</div>
        <h3>Continue Shopping</h3>
        <p>Discover new products and great deals</p>
        <a href="/" class="card-button">Browse Products</a>
    </div>
</div>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.card-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.dashboard-card h3 {
    color: #1f2937;
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
}

.dashboard-card p {
    color: #6b7280;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.card-button {
    background: #f59e0b;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.2s;
    display: inline-block;
}

.card-button:hover {
    background: #d97706;
    color: white;
}
</style>
@endsection
