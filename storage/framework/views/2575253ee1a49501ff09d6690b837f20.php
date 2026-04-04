

<?php $__env->startSection('title', 'My Profile - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<div class="settings-page">
    <div class="settings-container">

        <?php echo $__env->make('settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main class="settings-main">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Profile Card -->
            <div class="settings-card">
                <div class="settings-card-title">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </div>

                <!-- Avatar -->
                <div style="display:flex; align-items:center; gap:1.5rem; margin-bottom:2rem; padding-bottom:2rem; border-bottom:1px solid #f3f4f6;">
                    <?php if($user->profile_image): ?>
                        <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" alt="Profile" class="avatar-preview" style="width:90px;height:90px;">
                    <?php else: ?>
                        <div class="avatar-placeholder"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></div>
                    <?php endif; ?>
                    <div>
                        <div style="font-size:1.25rem;font-weight:700;color:#111827;"><?php echo e($user->name); ?></div>
                        <div style="font-size:13px;color:#6b7280;margin-top:2px;"><?php echo e($user->email); ?></div>
                        <span style="display:inline-block;margin-top:8px;padding:3px 12px;background:#eef2ff;color:#6366f1;border-radius:20px;font-size:12px;font-weight:600;">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="profile-info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><?php echo e($user->name); ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?php echo e($user->email); ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Role</div>
                        <div class="info-value"><?php echo e(ucfirst($user->role)); ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Member Since</div>
                        <div class="info-value"><?php echo e($user->created_at->format('M d, Y')); ?></div>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="<?php echo e(route('settings.edit-profile')); ?>" class="btn-primary" style="text-decoration:none;">Edit Profile</a>
                    <a href="<?php echo e(route('settings.change-password')); ?>" class="btn-secondary">Change Password</a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php echo $__env->make('settings.partials.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/settings/profile.blade.php ENDPATH**/ ?>