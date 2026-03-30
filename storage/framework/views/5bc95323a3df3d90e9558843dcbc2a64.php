

<?php $__env->startSection('title', 'Orders - Admin'); ?>
<?php $__env->startSection('panel-name', 'Admin Panel'); ?>
<?php $__env->startSection('page-title', 'Confirmed Orders'); ?>
<?php $__env->startSection('navbar-color', '#6366f1'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="alert alert-info">
            <strong>Note:</strong> Only orders where all vendors have confirmed their items are shown here.
        </div>

        <?php if($orders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($order->id); ?></td>
                            <td><?php echo e($order->user->name); ?></td>
                            <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                            <td><?php echo e($order->orderItems->count()); ?> item(s)</td>
                            <td>Rs. <?php echo e(number_format($order->total_price, 2)); ?></td>
                            <td><?php echo e($order->payment_method_label); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($order->status_color); ?>">
                                    <?php echo e(ucfirst($order->order_status)); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($orders->links()); ?>

            </div>
        <?php else: ?>
            <div class="alert alert-info">
                No confirmed orders found. Orders will appear here once all vendors confirm their items.
            </div>
        <?php endif; ?>
    </div>

    <style>
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #3b82f6;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table-bordered {
            border: 1px solid #e5e7eb;
        }
        
        .table-hover tbody tr:hover {
            background: #f9fafb;
        }
        
        .table thead {
            background: #f3f4f6;
        }
        
        .table th, .table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .bg-success {
            background: #10b981;
            color: white;
        }
        
        .bg-warning {
            background: #f59e0b;
            color: white;
        }
        
        .bg-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
        }
        
        .mt-3 {
            margin-top: 1rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>