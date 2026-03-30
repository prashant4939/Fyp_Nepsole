<div class="nav-section">
    <div class="nav-section-title">Main</div>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
        <span class="nav-icon">📊</span>
        Dashboard
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Management</div>
    <a href="<?php echo e(route('admin.vendors.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.vendors.*') ? 'active' : ''); ?>">
        <span class="nav-icon">👥</span>
        Vendor Management
    </a>
    <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
        <span class="nav-icon">📂</span>
        Categories
    </a>
    <a href="<?php echo e(route('admin.brands.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?>">
        <span class="nav-icon">🏷️</span>
        Brands
    </a>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
        <span class="nav-icon">📦</span>
        Orders
    </a>
    <a href="<?php echo e(route('admin.customers.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.customers.*') ? 'active' : ''); ?>">
        <span class="nav-icon">👤</span>
        Customer Management
    </a>
</div>
<?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>