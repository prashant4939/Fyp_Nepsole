

<?php $__env->startSection('title', 'Category Management - Admin'); ?>
<?php $__env->startSection('panel-name', 'Admin Panel'); ?>
<?php $__env->startSection('page-title', 'Category Management'); ?>
<?php $__env->startSection('navbar-color', '#6366f1'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Category Management</h2>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">+ Add New Category</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-error"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Products</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <?php if($category->image): ?>
                            <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="table-image">
                        <?php else: ?>
                            <div class="no-image">No Image</div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo e($category->name); ?></strong></td>
                    <td><span class="badge"><?php echo e($category->products_count); ?> products</span></td>
                    <td>
                        <?php if($category->is_active): ?>
                            <span class="status-badge status-active">Active</span>
                        <?php else: ?>
                            <span class="status-badge status-inactive">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($category->created_at->format('M d, Y')); ?></td>
                    <td>
                        <div class="action-buttons">
                            <form method="POST" action="<?php echo e(route('admin.categories.toggle-status', $category)); ?>" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-sm btn-toggle">
                                    <?php echo e($category->is_active ? 'Deactivate' : 'Activate'); ?>

                                </button>
                            </form>
                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn-sm btn-edit">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.categories.destroy', $category)); ?>" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Are you sure? This will fail if products are linked.')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No categories found. <a href="<?php echo e(route('admin.categories.create')); ?>">Create one</a></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    <?php echo e($categories->links()); ?>

</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-header h2 {
    color: #1f2937;
    font-size: 24px;
}

.btn {
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background: #6366f1;
    color: white;
}

.btn-primary:hover {
    background: #4f46e5;
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

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
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
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
}

.no-image {
    width: 50px;
    height: 50px;
    background: #f3f4f6;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: #9ca3af;
}

.badge {
    background: #e0e7ff;
    color: #3730a3;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-edit {
    background: #dbeafe;
    color: #1e40af;
}

.btn-edit:hover {
    background: #bfdbfe;
}

.btn-delete {
    background: #fee2e2;
    color: #991b1b;
}

.btn-delete:hover {
    background: #fecaca;
}

.btn-toggle {
    background: #fef3c7;
    color: #92400e;
}

.btn-toggle:hover {
    background: #fde68a;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.text-center {
    text-align: center;
}

.pagination-wrapper {
    margin-top: 1rem;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>