

<?php $__env->startSection('title', 'Brands - Vendor'); ?>
<?php $__env->startSection('panel-name', 'Vendor Panel'); ?>
<?php $__env->startSection('page-title', 'Available Brands'); ?>
<?php $__env->startSection('navbar-color', '#10b981'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('vendor.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Available Brands</h2>
</div>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <?php if($brand->logo): ?>
                            <img src="<?php echo e(asset('storage/' . $brand->logo)); ?>" alt="<?php echo e($brand->name); ?>" class="table-image">
                        <?php else: ?>
                            <div class="no-image">No Logo</div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo e($brand->name); ?></strong></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="2" class="text-center">No brands available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    <?php echo e($brands->links()); ?>

</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #1f2937;
    font-size: 24px;
}

.table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: #f9fafb;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.data-table td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: #6b7280;
}

.table-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.no-image {
    width: 60px;
    height: 60px;
    background: #f3f4f6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: #9ca3af;
}

.text-center {
    text-align: center;
}

.pagination-wrapper {
    margin-top: 1rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/vendor/brands/index.blade.php ENDPATH**/ ?>