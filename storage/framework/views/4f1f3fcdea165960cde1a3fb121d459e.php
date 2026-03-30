<nav class="navbar">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="top-container">
            <div class="logo-section">
                <a href="/" class="logo">
                    <span class="logo-text">NEPSOLE</span>
                </a>
            </div>
            
            <div class="search-section">
                <form action="<?php echo e(route('products.index')); ?>" method="GET" class="search-container">
                    <input type="text" name="search" placeholder="Search products..." class="search-input" value="<?php echo e(request('search')); ?>">
                    <?php if(request('category')): ?>
                        <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                    <?php endif; ?>
                    <?php if(request('brand')): ?>
                        <input type="hidden" name="brand" value="<?php echo e(request('brand')); ?>">
                    <?php endif; ?>
                    <button type="submit" class="search-btn">🔍</button>
                </form>
            </div>
            
            <div class="top-right">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('vendor.portal')); ?>" class="become-vendor-btn">Become Vendor</a>
                <?php endif; ?>
                <div class="user-actions">
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="user-dropdown">
                            <a href="#" class="user-icon" onclick="toggleUserDropdown(event)">👤</a>
                            <div class="user-dropdown-menu" id="userDropdownMenu">
                                <a href="<?php echo e(route('login')); ?>" class="user-dropdown-item">
                                    <span class="dropdown-icon">🔑</span>
                                    Login
                                </a>
                                <a href="<?php echo e(route('register')); ?>" class="user-dropdown-item">
                                    <span class="dropdown-icon">📝</span>
                                    Sign Up
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="user-dropdown">
                            <a href="#" class="user-name-link" onclick="toggleUserDropdown(event)">
                                <?php echo e(auth()->user()->name); ?> ▼
                            </a>
                            <div class="user-dropdown-menu" id="userDropdownMenu">
                                <div class="user-info">
                                    <span class="user-name"><?php echo e(auth()->user()->name); ?></span>
                                    <span class="user-role"><?php echo e(ucfirst(auth()->user()->role)); ?></span>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo e(route('logout')); ?>" 
                                   class="user-dropdown-item logout-item"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="dropdown-icon">🚪</span>
                                    Logout
                                </a>
                                <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('wishlist.index')); ?>" class="wishlist-icon" title="Wishlist">
                        ❤️
                        <span class="wishlist-badge" id="wishlistBadge" style="display: none;">0</span>
                    </a>
                    <a href="<?php echo e(route('cart.index')); ?>" class="cart-icon" title="Shopping Cart">
                        🛒
                        <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Navigation -->
    <div class="main-nav">
        <div class="nav-container">
            <div class="nav-links">
                <a href="/" class="nav-link">Home</a>
                <a href="<?php echo e(route('products.index')); ?>" class="nav-link">Products</a>
                <div class="dropdown">
                    <?php
                        $currentCategoryId = request('category') ?? request()->route('category')?->id;
                        $currentBrandId = request('brand') ?? request()->route('brand')?->id;
                        $currentCategory = $currentCategoryId ? \App\Models\Category::find($currentCategoryId) : null;
                        $currentBrand = $currentBrandId ? \App\Models\Brand::find($currentBrandId) : null;
                        $categories = \App\Models\Category::active()->orderBy('name')->get();
                    ?>
                    <a href="#" class="nav-link dropdown-toggle">
                        <?php echo e($currentCategory ? $currentCategory->name : 'Categories'); ?> ▼
                    </a>
                    <div class="dropdown-menu">
                        <a href="<?php echo e(route('products.index')); ?>" class="dropdown-item <?php echo e(!$currentCategory ? 'active' : ''); ?>">
                            All Categories
                        </a>
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                // Build URL with current brand filter if exists
                                if ($currentBrand) {
                                    $url = route('products.index', ['category' => $category->id, 'brand' => $currentBrand->id]);
                                } else {
                                    $url = route('products.index', ['category' => $category->id]);
                                }
                            ?>
                            <a href="<?php echo e($url); ?>" 
                               class="dropdown-item <?php echo e($currentCategory && $currentCategory->id == $category->id ? 'active' : ''); ?>">
                                <?php echo e($category->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <span class="dropdown-item" style="color: #9ca3af;">No categories available</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="dropdown">
                    <?php
                        $brands = \App\Models\Brand::active()->orderBy('name')->get();
                    ?>
                    <a href="#" class="nav-link dropdown-toggle">
                        <?php echo e($currentBrand ? $currentBrand->name : 'Shop by Brand'); ?> ▼
                    </a>
                    <div class="dropdown-menu">
                        <a href="<?php echo e(route('products.index')); ?>" class="dropdown-item <?php echo e(!$currentBrand ? 'active' : ''); ?>">
                            All Brands
                        </a>
                        <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                // Build URL with current category filter if exists
                                if ($currentCategory) {
                                    $url = route('products.index', ['category' => $currentCategory->id, 'brand' => $brand->id]);
                                } else {
                                    $url = route('products.index', ['brand' => $brand->id]);
                                }
                            ?>
                            <a href="<?php echo e($url); ?>" 
                               class="dropdown-item <?php echo e($currentBrand && $currentBrand->id == $brand->id ? 'active' : ''); ?>">
                                <?php echo e($brand->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <span class="dropdown-item" style="color: #9ca3af;">No brands available</span>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?php echo e(route('products.index')); ?>?sort=latest" class="nav-link">New Arrivals</a>
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

    .logo-text {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        letter-spacing: 1px;
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
    });

    // Close dropdown when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const dropdown = document.getElementById('userDropdownMenu');
            if (dropdown) {
                dropdown.classList.remove('show');
            }
        }
    });

    // Update cart count on page load
    function updateCartCount() {
        <?php if(auth()->guard()->check()): ?>
        fetch('<?php echo e(route('cart.count')); ?>')
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
        <?php endif; ?>
    }

    // Update wishlist count on page load
    function updateWishlistCount() {
        <?php if(auth()->guard()->check()): ?>
        fetch('<?php echo e(route('wishlist.count')); ?>')
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
        <?php endif; ?>
    }

    // Call on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
        updateWishlistCount();
    });
</script>
<?php /**PATH C:\Users\Krishna\Desktop\Fyp_Nepsole\resources\views/components/navbar.blade.php ENDPATH**/ ?>