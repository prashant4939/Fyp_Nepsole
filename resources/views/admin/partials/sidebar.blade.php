<div class="nav-section">
    <div class="nav-section-title">Main</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="nav-icon">📊</span>
        Dashboard
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Management</div>
    <a href="{{ route('admin.vendors.index') }}" class="nav-link {{ request()->routeIs('admin.vendors.*') || request()->routeIs('admin.vendor-requests.*') ? 'active' : '' }}">
        <span class="nav-icon">👥</span>
        Vendor Management
    </a>
    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <span class="nav-icon">📂</span>
        Categories
    </a>
    <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
        <span class="nav-icon">🏷️</span>
        Brands
    </a>
    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <span class="nav-icon">📦</span>
        Orders
    </a>
    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
        <span class="nav-icon">👤</span>
        Customer Management
    </a>
</div>
