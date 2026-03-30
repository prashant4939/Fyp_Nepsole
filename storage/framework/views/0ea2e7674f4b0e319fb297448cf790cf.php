<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Details - <?php echo e($vendor->business_name); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f9fafb;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: #1f2937;
            font-size: 28px;
        }

        .back-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .vendor-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            background: #f9fafb;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-title {
            color: #1f2937;
            font-size: 20px;
            font-weight: 600;
        }

        .card-content {
            padding: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-label {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #1f2937;
            font-size: 16px;
            font-weight: 500;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
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

        .documents-section {
            margin-top: 1rem;
        }

        .document-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .document-name {
            color: #374151;
            font-weight: 500;
        }

        .document-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            background: #e0e7ff;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .document-link:hover {
            background: #c7d2fe;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-approve {
            background: #10b981;
            color: white;
        }

        .btn-approve:hover {
            background: #059669;
        }

        .btn-reject {
            background: #ef4444;
            color: white;
        }

        .btn-reject:hover {
            background: #dc2626;
        }

        .btn-deactivate {
            background: #f59e0b;
            color: white;
        }

        .btn-deactivate:hover {
            background: #d97706;
        }

        .btn-reactivate {
            background: #3b82f6;
            color: white;
        }

        .btn-reactivate:hover {
            background: #2563eb;
        }

        .deactivation-note {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .deactivation-note h4 {
            color: #92400e;
            margin-bottom: 0.5rem;
        }

        .deactivation-note p {
            color: #92400e;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .document-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Vendor Details</h1>
            <a href="<?php echo e(route('admin.vendors.index')); ?>" class="back-link">← Back to Vendor List</a>
        </div>

        <!-- Basic Information -->
        <div class="vendor-card">
            <div class="card-header">
                <h2 class="card-title">Basic Information</h2>
            </div>
            <div class="card-content">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Vendor Name</div>
                        <div class="info-value"><?php echo e($vendor->user->name); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?php echo e($vendor->user->email); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Business Name</div>
                        <div class="info-value"><?php echo e($vendor->business_name); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">PAN Number</div>
                        <div class="info-value"><?php echo e($vendor->pan_number); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Business Type</div>
                        <div class="info-value"><?php echo e($vendor->getBusinessTypeLabel()); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Application Date</div>
                        <div class="info-value"><?php echo e($vendor->created_at->format('M d, Y h:i A')); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <?php if(!$vendor->is_verified): ?>
                                <span class="status-badge status-pending">Pending Approval</span>
                            <?php elseif($vendor->is_active): ?>
                                <span class="status-badge status-approved">Active</span>
                            <?php else: ?>
                                <span class="status-badge status-inactive">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if(!$vendor->is_active && $vendor->deactivation_note): ?>
                    <div class="deactivation-note">
                        <h4>Deactivation Reason</h4>
                        <p><?php echo e($vendor->deactivation_note); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Documents -->
        <div class="vendor-card">
            <div class="card-header">
                <h2 class="card-title">Uploaded Documents</h2>
            </div>
            <div class="card-content">
                <div class="documents-section">
                    <div class="document-item">
                        <span class="document-name">Citizenship Certificate</span>
                        <a href="<?php echo e(Storage::url($vendor->citizenship_certificate)); ?>" target="_blank" class="document-link">View Document</a>
                    </div>
                    <div class="document-item">
                        <span class="document-name">Company Registration Certificate</span>
                        <a href="<?php echo e(Storage::url($vendor->company_registration_certificate)); ?>" target="_blank" class="document-link">View Document</a>
                    </div>
                    <?php if($vendor->tax_certificate): ?>
                        <div class="document-item">
                            <span class="document-name">Tax Certificate</span>
                            <a href="<?php echo e(Storage::url($vendor->tax_certificate)); ?>" target="_blank" class="document-link">View Document</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <?php if(!$vendor->is_verified): ?>
                <form method="POST" action="<?php echo e(route('admin.vendors.approve', $vendor)); ?>" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-approve" onclick="return confirm('Approve this vendor? They will receive an email notification and be able to login.')">
                        ✓ Approve Vendor
                    </button>
                </form>
                <form method="POST" action="<?php echo e(route('admin.vendors.reject', $vendor)); ?>" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-reject" onclick="return confirm('Reject and permanently delete this vendor application? This action cannot be undone.')">
                        ✗ Reject & Delete
                    </button>
                </form>
            <?php else: ?>
                <?php if($vendor->is_active): ?>
                    <button class="btn btn-deactivate" onclick="showDeactivateModal()">
                        ⏸ Deactivate Vendor
                    </button>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('admin.vendors.reactivate', $vendor)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-reactivate">
                            ▶ Reactivate Vendor
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showDeactivateModal() {
            const reason = prompt('Please provide a reason for deactivation:');
            if (reason && reason.trim()) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo e(route("admin.vendors.deactivate", $vendor)); ?>';
                
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
</body>
</html><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/admin/vendors/show.blade.php ENDPATH**/ ?>