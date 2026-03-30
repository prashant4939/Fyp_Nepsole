<div class="nav-section">
    <div class="nav-section-title">Main</div>
    <a href="{{ route('vendor.dashboard') }}" class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
        <span class="nav-icon">📊</span>
        Dashboard
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Products</div>
    <a href="{{ route('vendor.products.index') }}" class="nav-link {{ request()->routeIs('vendor.products.index') ? 'active' : '' }}">
        <span class="nav-icon">🛍️</span>
        My Products
    </a>
    <a href="{{ route('vendor.products.create') }}" class="nav-link {{ request()->routeIs('vendor.products.create') ? 'active' : '' }}">
        <span class="nav-icon">➕</span>
        Add Product
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Orders</div>
    <a href="{{ route('vendor.orders.index') }}" class="nav-link {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}">
        <span class="nav-icon">📦</span>
        My Orders
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Browse</div>
    <a href="{{ route('vendor.categories') }}" class="nav-link {{ request()->routeIs('vendor.categories') ? 'active' : '' }}">
        <span class="nav-icon">📂</span>
        Categories
    </a>
    <a href="{{ route('vendor.brands') }}" class="nav-link {{ request()->routeIs('vendor.brands') ? 'active' : '' }}">
        <span class="nav-icon">🏷️</span>
        Brands
    </a>
</div>
