<nav class="navbar">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-container">
            <div class="logo-section">
                <a href="/" class="logo">
                    <div class="logo-mark">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="36" height="36" rx="8" fill="#6366f1"/>
                            <rect x="7" y="7" width="9" height="9" rx="2" stroke="white" stroke-width="1.8" fill="none"/>
                            <rect x="20" y="7" width="9" height="5" rx="2" stroke="white" stroke-width="1.8" fill="none"/>
                            <rect x="20" y="16" width="9" height="11" rx="2" stroke="white" stroke-width="1.8" fill="none"/>
                            <rect x="7" y="20" width="9" height="9" rx="2" stroke="white" stroke-width="1.8" fill="none"/>
                        </svg>
                    </div>
                    <span class="logo-text">NepSole</span>
                </a>
            </div>
            
            <div class="search-section">
                <form action="{{ route('products.index') }}" method="GET" class="search-container">
                    <input type="text" name="search" placeholder="Search products..." class="search-input" value="{{ request('search') }}">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('brand'))
                        <input type="hidden" name="brand" value="{{ request('brand') }}">
                    @endif
                    <button type="submit" class="search-btn">🔍</button>
                </form>
            </div>
            
            <div class="top-right">
                @guest
                    <a href="{{ route('vendor.portal') }}" class="become-vendor-btn">Become Vendor</a>
                @endguest
                <div class="user-actions">
                    @guest
                        <div class="user-dropdown">
                            <a href="#" class="user-icon" onclick="toggleUserDropdown(event)">👤</a>
                            <div class="user-dropdown-menu" id="userDropdownMenu">
                                <a href="{{ route('login') }}" class="user-dropdown-item">
                                    <span class="dropdown-icon">🔑</span>
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="user-dropdown-item">
                                    <span class="dropdown-icon">📝</span>
                                    Sign Up
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="user-dropdown">
                            <a href="#" class="user-name-link" onclick="toggleUserDropdown(event)">
                                {{ auth()->user()->name }} ▼
                            </a>
                            <div class="user-dropdown-menu" id="userDropdownMenu">
                                <div class="user-info">
                                    <span class="user-name">{{ auth()->user()->name }}</span>
                                    <span class="user-role">{{ ucfirst(auth()->user()->role) }}</span>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" 
                                   class="user-dropdown-item logout-item"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="dropdown-icon">🚪</span>
                                    Logout
                                </a>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                    <a href="{{ route('wishlist.index') }}" class="wishlist-icon" title="Wishlist">
                        ❤️
                        <span class="wishlist-badge" id="wishlistBadge" style="display: none;">0</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="cart-icon" title="Shopping Cart">
                        🛒
                        <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                    </a>
                    @auth
                    <div class="settings-dropdown-wrap">
                        <button class="settings-icon-btn" onclick="toggleSettingsDropdown(event)" title="Settings" aria-label="Settings">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                        <div class="settings-dropdown-menu" id="settingsDropdownMenu">
                            <div class="settings-dropdown-header">
                                <div class="sd-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                <div>
                                    <div class="sd-name">{{ auth()->user()->name }}</div>
                                    <div class="sd-role">{{ ucfirst(auth()->user()->role) }}</div>
                                </div>
                            </div>
                            <div class="sd-divider"></div>
                            <a href="{{ route('settings.profile') }}" class="sd-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                View Profile
                            </a>
                            <a href="{{ route('settings.change-password') }}" class="sd-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Change Password
                            </a>
                            <div class="sd-divider"></div>
                            <a href="#" class="sd-item sd-logout"
                               onclick="event.preventDefault(); document.getElementById('settings-logout-form').submit();">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </a>
                            <form id="settings-logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Navigation -->
    <div class="main-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="/" class="nav-link">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link">Products</a>
                <div class="dropdown">
                    @php
                        $currentCategoryId = request('category') ?? request()->route('category')?->id;
                        $currentBrandId = request('brand') ?? request()->route('brand')?->id;
                        $currentCategory = $currentCategoryId ? \App\Models\Category::find($currentCategoryId) : null;
                        $currentBrand = $currentBrandId ? \App\Models\Brand::find($currentBrandId) : null;
                        $categories = \App\Models\Category::active()->orderBy('name')->get();
                    @endphp
                    <a href="#" class="nav-link dropdown-toggle">
                        {{ $currentCategory ? $currentCategory->name : 'Categories' }} ▼
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('products.index') }}" class="dropdown-item {{ !$currentCategory ? 'active' : '' }}">
                            All Categories
                        </a>
                        @forelse($categories as $category)
                            @php
                                // Build URL with current brand filter if exists
                                if ($currentBrand) {
                                    $url = route('products.index', ['category' => $category->id, 'brand' => $currentBrand->id]);
                                } else {
                                    $url = route('products.index', ['category' => $category->id]);
                                }
                            @endphp
                            <a href="{{ $url }}" 
                               class="dropdown-item {{ $currentCategory && $currentCategory->id == $category->id ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        @empty
                            <span class="dropdown-item" style="color: #9ca3af;">No categories available</span>
                        @endforelse
                    </div>
                </div>
                <div class="dropdown">
                    @php
                        $brands = \App\Models\Brand::active()->orderBy('name')->get();
                    @endphp
                    <a href="#" class="nav-link dropdown-toggle">
                        {{ $currentBrand ? $currentBrand->name : 'Shop by Brand' }} ▼
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('products.index') }}" class="dropdown-item {{ !$currentBrand ? 'active' : '' }}">
                            All Brands
                        </a>
                        @forelse($brands as $brand)
                            @php
                                // Build URL with current category filter if exists
                                if ($currentCategory) {
                                    $url = route('products.index', ['category' => $currentCategory->id, 'brand' => $brand->id]);
                                } else {
                                    $url = route('products.index', ['brand' => $brand->id]);
                                }
                            @endphp
                            <a href="{{ $url }}" 
                               class="dropdown-item {{ $currentBrand && $currentBrand->id == $brand->id ? 'active' : '' }}">
                                {{ $brand->name }}
                            </a>
                        @empty
                            <span class="dropdown-item" style="color: #9ca3af;">No brands available</span>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('products.index') }}?sort=latest" class="nav-link">New Arrivals</a>
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar {
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    /* Top Bar Styles */
    .top-bar {
        border-bottom: 1px solid #e5e7eb;
        padding: 1rem 0;
    }

    .top-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .logo-section .logo {
        text-decoration: none;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .logo-mark {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .logo-text {
        font-size: 22px;
        font-weight: 700;
        color: #6366f1;
        letter-spacing: -0.3px;
    }

    /* Search Section */
    .search-section {
        flex: 1;
        max-width: 500px;
    }

    .search-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input {
        width: 100%;
        padding: 12px 50px 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }

    .search-input:focus {
        border-color: #6366f1;
    }

    .search-btn {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        padding: 4px;
    }

    /* Top Right Section */
    .top-right {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .become-vendor-btn {
        background: #10b981;
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 6px;
        transition: background-color 0.2s;
    }

    .become-vendor-btn:hover {
        background: #059669;
        color: white;
    }

    .user-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-icon, .wishlist-icon, .cart-icon {
        font-size: 20px;
        text-decoration: none;
        padding: 8px;
        border-radius: 6px;
        transition: background-color 0.2s;
        cursor: pointer;
        position: relative;
    }

    .user-icon:hover, .wishlist-icon:hover, .cart-icon:hover {
        background-color: #f3f4f6;
    }

    .cart-badge, .wishlist-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        background: #ef4444;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
    }

    .wishlist-badge {
        background: #ec4899;
    }

    .user-name-link {
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background-color 0.2s;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .user-name-link:hover {
        background-color: #f3f4f6;
    }

    /* User Dropdown Styles */
    .user-dropdown {
        position: relative;
    }

    .user-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s;
        z-index: 1000;
        margin-top: 8px;
    }

    .user-dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .user-info {
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .user-name {
        display: block;
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    .user-role {
        display: block;
        font-size: 12px;
        color: #6b7280;
        text-transform: capitalize;
    }

    .dropdown-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 0;
    }

    .user-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.2s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-family: inherit;
    }

    .user-dropdown-item:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }

    .logout-item:hover {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .dropdown-icon {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    /* Main Navigation */
    .main-nav {
        padding: 0.75rem 0;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 2.5rem;
    }

    .nav-link {
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        font-size: 15px;
        transition: color 0.2s;
        padding: 0.5rem 0;
    }

    .nav-link:hover {
        color: #6366f1;
    }

    /* Dropdown Styles */
    .dropdown {
        position: relative;
    }

    .dropdown-toggle {
        cursor: pointer;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        min-width: 180px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s;
        z-index: 1000;
    }

    .dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: block;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f3f4f6;
        color: #6366f1;
    }

    .dropdown-item.active {
        background-color: #e0e7ff;
        color: #6366f1;
        font-weight: 600;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .top-container {
            flex-direction: column;
            gap: 1rem;
        }

        .search-section {
            order: 3;
            max-width: 100%;
        }

        .nav-links {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dropdown-menu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            border: none;
            background: #f9fafb;
            margin-top: 0.5rem;
        }
    }
    /* Settings Dropdown */
    .settings-dropdown-wrap {
        position: relative;
    }

    .settings-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        border: 1.5px solid #e5e7eb;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #6b7280;
        transition: all 0.2s;
        padding: 0;
    }

    .settings-icon-btn:hover {
        border-color: #6366f1;
        color: #6366f1;
        background: #eef2ff;
    }

    .settings-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        min-width: 220px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s;
        z-index: 1100;
    }

    .settings-dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .settings-dropdown-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 11px 11px 0 0;
    }

    .sd-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255,255,255,0.25);
        border: 2px solid rgba(255,255,255,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .sd-name {
        font-size: 14px;
        font-weight: 600;
        color: white;
    }

    .sd-role {
        font-size: 11px;
        color: rgba(255,255,255,0.75);
        text-transform: capitalize;
    }

    .sd-divider {
        height: 1px;
        background: #f3f4f6;
        margin: 0;
    }

    .sd-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.25rem;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: background 0.15s;
    }

    .sd-item:hover {
        background: #f3f4f6;
        color: #6366f1;
    }

    .sd-item svg {
        flex-shrink: 0;
        color: #9ca3af;
    }

    .sd-item:hover svg {
        color: #6366f1;
    }

    .sd-logout:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .sd-logout:hover svg {
        color: #dc2626;
    }

</style>

<script>
    function toggleUserDropdown(event) {
        event.preventDefault();
        event.stopPropagation();
        
        const dropdown = document.getElementById('userDropdownMenu');
        dropdown.classList.toggle('show');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdownMenu');
        const userIcon = event.target.closest('.user-dropdown');
        if (!userIcon && dropdown) {
            dropdown.classList.remove('show');
        }

        // Close settings dropdown too
        const settingsMenu = document.getElementById('settingsDropdownMenu');
        const settingsWrap = event.target.closest('.settings-dropdown-wrap');
        if (!settingsWrap && settingsMenu) {
            settingsMenu.classList.remove('show');
        }
    });

    // Close dropdowns on Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const d1 = document.getElementById('userDropdownMenu');
            const d2 = document.getElementById('settingsDropdownMenu');
            if (d1) d1.classList.remove('show');
            if (d2) d2.classList.remove('show');
        }
    });

    function toggleSettingsDropdown(event) {
        event.preventDefault();
        event.stopPropagation();
        // Close user dropdown if open
        const userMenu = document.getElementById('userDropdownMenu');
        if (userMenu) userMenu.classList.remove('show');
        // Toggle settings dropdown
        document.getElementById('settingsDropdownMenu').classList.toggle('show');
    }

    // Update cart count on page load
    function updateCartCount() {
        @auth
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cartBadge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            });
        @endauth
    }

    // Update wishlist count on page load
    function updateWishlistCount() {
        @auth
        fetch('{{ route('wishlist.count') }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('wishlistBadge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            });
        @endauth
    }

    // Call on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
        updateWishlistCount();
    });
</script>
