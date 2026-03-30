

<?php $__env->startSection('title', 'Vendor Management - Admin'); ?>
<?php $__env->startSection('panel-name', 'Admin Panel'); ?>
<?php $__env->startSection('page-title', 'Vendor Management'); ?>
<?php $__env->startSection('navbar-color', '#6366f1'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="tabs">
    <button class="tab active" onclick="showTab('pending')">
        Pending Approval (<?php echo e($pendingVendors->count()); ?>)
    </button>
    <button class="tab" onclick="showTab('approved')">
        Vendor List (<?php echo e($approvedVendors->count()); ?>)
    </button>
</div>

<!-- Pending Vendors Tab -->
<div id="pending" class="tab-content active">
    <div class="table-container">
        <?php if($pendingVendors->count() > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Vendor Name</th>
                        <th>Business Name</th>
                        <th>Email</th>
                        <th>Business Type</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pendingVendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($vendor->user->name); ?></td>
                            <td><?php echo e($vendor->business_name); ?></td>
                            <td><?php echo e($vendor->user->email); ?></td>
                            <td><?php echo e($vendor->getBusinessTypeLabel()); ?></td>
                            <td><?php echo e($vendor->created_at->format('M d, Y')); ?></td>
                            <td>
                                <span class="status-badge status-pending">Pending</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="btn btn-view">View</a>
                                    <form method="POST" action="<?php echo e(route('admin.vendors.approve', $vendor)); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this vendor?')">Approve</button>
                                    </form>
                                    <form method="POST" action="<?php echo e(route('admin.vendors.reject', $vendor)); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-reject" onclick="return confirm('Reject and delete this vendor application?')">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <h3>No Pending Applications</h3>
                <p>All vendor applications have been processed.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Approved Vendors Tab -->
<div id="approved" class="tab-content">
    <div class="table-container">
        <?php if($approvedVendors->count() > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Vendor Name</th>
                        <th>Business Name</th>
                        <th>Email</th>
                        <th>Business Type</th>
                        <th>Approved Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $approvedVendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($vendor->user->name); ?></td>
                            <td><?php echo e($vendor->business_name); ?></td>
                            <td><?php echo e($vendor->user->email); ?></td>
                            <td><?php echo e($vendor->getBusinessTypeLabel()); ?></td>
                            <td><?php echo e($vendor->updated_at->format('M d, Y')); ?></td>
                            <td>
                                <?php if($vendor->is_active): ?>
                                    <span class="status-badge status-approved">Active</span>
                                <?php else: ?>
                                    <span class="status-badge status-inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="btn btn-view">View</a>
                                    <?php if($vendor->is_active): ?>
                                        <button class="btn btn-deactivate" onclick="showDeactivateModal(<?php echo e($vendor->id); ?>)">Deactivate</button>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('admin.vendors.reactivate', $vendor)); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-reactivate">Reactivate</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <h3>No Approved Vendors</h3>
                <p>No vendors have been approved yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.tabs {
    display: flex;
    margin-bottom: 2rem;
    border-bottom: 2px solid #e5e7eb;
}

.tab {
    padding: 1rem 2rem;
    background: none;
    border: none;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    color: #6b7280;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
}

.tab.active {
    color: #6366f1;
    border-bottom-color: #6366f1;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #f9fafb;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: #6b7280;
}

.table tr:hover {
    background: #f9fafb;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-approved {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-view {
    background: #e0e7ff;
    color: #3730a3;
}

.btn-view:hover {
    background: #c7d2fe;
}

.btn-approve {
    background: #d1fae5;
    color: #065f46;
}

.btn-approve:hover {
    background: #a7f3d0;
}

.btn-reject {
    background: #fee2e2;
    color: #991b1b;
}

.btn-reject:hover {
    background: #fecaca;
}

.btn-deactivate {
    background: #fed7aa;
    color: #9a3412;
}

.btn-deactivate:hover {
    background: #fdba74;
}

.btn-reactivate {
    background: #bfdbfe;
    color: #1e40af;
}

.btn-reactivate:hover {
    background: #93c5fd;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.empty-state h3 {
    margin-bottom: 0.5rem;
    color: #374151;
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
</style>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
}

function showDeactivateModal(vendorId) {
    const reason = prompt('Please provide a reason for deactivation:');
    if (reason && reason.trim()) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/vendors/${vendorId}/deactivate`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'deactivation_note';
        reasonInput.value = reason.trim();
        
        form.appendChild(csrfToken);
        form.appendChild(reasonInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Krishna\Desktop\Fyp_Nepsole\resources\views/admin/vendors/index.blade.php ENDPATH**/ ?>