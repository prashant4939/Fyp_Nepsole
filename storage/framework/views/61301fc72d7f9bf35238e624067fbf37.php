<?php $__env->startSection('title', 'Login - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-title">Login</div>

<?php if(session('status')): ?>
    <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
        <?php echo e(session('status')); ?>

    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('login')); ?>">
    <?php echo csrf_field(); ?>
    
    <div class="form-group">
        <label class="form-label">Email</label>
        <input 
            type="email" 
            name="email" 
            class="form-input" 
            placeholder="Enter your email"
            value="<?php echo e(old('email')); ?>"
            required
        >
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
        <label class="form-label">Password</label>
        <input 
            type="password" 
            name="password" 
            class="form-input" 
            placeholder="Enter your password"
            required
        >
        <?php $__errorArgs = ['password'];
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

    <div style="text-align: right; margin-bottom: 16px;">
        <a href="<?php echo e(route('password.request')); ?>" style="color: #6366f1; text-decoration: none; font-size: 14px; font-weight: 500;">
            Forgot Password?
        </a>
    </div>

    <button type="submit" class="btn-primary">Login</button>
</form>

<div class="auth-footer">
    Don't have an account? <a href="<?php echo e(route('register')); ?>">Register here</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/customer/auth/login.blade.php ENDPATH**/ ?>