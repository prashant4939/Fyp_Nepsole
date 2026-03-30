

<?php $__env->startSection('title', 'Customer Management - Admin'); ?>
<?php $__env->startSection('panel-name', 'Admin Panel'); ?>
<?php $__env->startSection('page-title', 'Customer Management'); ?>
<?php $__env->startSection('navbar-color', '#6366f1'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="customers-container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                    <th>Joined Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($customer->id); ?></td>
                    <td><?php echo e($customer->name); ?></td>
                    <td><?php echo e($customer->email); ?></td>
                    <td><?php echo e($customer->orders_count); ?></td>
                    <td><?php echo e($customer->created_at->format('M d, Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No customers found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <?php echo e($customers->links()); ?>

    </div>
</div>

<style>
    .customers-container {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-bordered {
        border: 1px solid #e5e7eb;
    }
    
    .table-hover tbody tr:hover {
        background: #f9fafb;
    }
    
    .table-light {
        background: #f3f4f6;
    }
    
    .table th, .table td {
        padding: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }
    
    .text-center {
        text-align: center;
    }
    
    .mt-3 {
        margin-top: 1rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>