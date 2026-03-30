

<?php $__env->startSection('title', 'Edit Profile'); ?>
<?php $__env->startSection('panel-name', ucfirst(auth()->user()->role) . ' Panel'); ?>
<?php $__env->startSection('page-title', 'Edit Profile'); ?>
<?php $__env->startSection('navbar-color', auth()->user()->role === 'admin' ? '#6366f1' : (auth()->user()->role === 'vendor' ? '#10b981' : '#f97316')); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php if(auth()->user()->role === 'admin'): ?>
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
    <div class="nav-section">
        <div class="nav-section-title">Management</div>
        <a href="<?php echo e(route('admin.vendors.index')); ?>" class="nav-link">
            <span class="nav-icon">👥</span>
            Vendor Management
        </a>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-link">
            <span class="nav-icon">📂</span>
            Categories
        </a>
        <a href="<?php echo e(route('admin.brands.index')); ?>" class="nav-link">
            <span class="nav-icon">🏷️</span>
            Brands
        </a>
    </div>
<?php elseif(auth()->user()->role === 'vendor'): ?>
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="<?php echo e(route('vendor.dashboard')); ?>" class="nav-link">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
    <div class="nav-section">
        <div class="nav-section-title">Products</div>
        <a href="<?php echo e(route('vendor.products.index')); ?>" class="nav-link">
            <span class="nav-icon">🛍️</span>
            My Products
        </a>
        <a href="<?php echo e(route('vendor.products.create')); ?>" class="nav-link">
            <span class="nav-icon">➕</span>
            Add Product
        </a>
    </div>
    <div class="nav-section">
        <div class="nav-section-title">Browse</div>
        <a href="<?php echo e(route('vendor.categories')); ?>" class="nav-link">
            <span class="nav-icon">📂</span>
            Categories
        </a>
        <a href="<?php echo e(route('vendor.brands')); ?>" class="nav-link">
            <span class="nav-icon">🏷️</span>
            Brands
        </a>
    </div>
<?php else: ?>
    <div class="nav-section">
        <div class="nav-section-title">Main</div>
        <a href="<?php echo e(route('customer.dashboard')); ?>" class="nav-link">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Edit Profile</h2>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="<?php echo e(route('profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <div class="form-group">
            <label for="name">Full Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="email">Email Address <span class="required">*</span></label>
            <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label>Role</label>
            <input type="text" value="<?php echo e(ucfirst($user->role)); ?>" disabled>
            <small>Your role cannot be changed</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="<?php echo e(auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'vendor' ? route('vendor.dashboard') : route('customer.dashboard'))); ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #1f2937;
    font-size: 24px;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    color: #374151;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.required {
    color: #ef4444;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-group input:focus {
    outline: none;
    border-color: #10b981;
}

.form-group input:disabled {
    background: #f9fafb;
    cursor: not-allowed;
}

.form-group small {
    display: block;
    color: #6b7280;
    font-size: 12px;
    margin-top: 0.25rem;
}

.error-message {
    color: #ef4444;
    font-size: 12px;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #10b981;
    color: white;
}

.btn-primary:hover {
    background: #059669;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/customer/profile/edit.blade.php ENDPATH**/ ?>