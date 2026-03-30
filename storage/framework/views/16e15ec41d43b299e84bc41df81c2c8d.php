<?php $__env->startSection('title', 'Registration - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-title">Create Your Account</div>
<div class="auth-subtitle">Join NepSole as a customer and start shopping!</div>

<form method="POST" action="<?php echo e(route('register')); ?>">
    <?php echo csrf_field(); ?>
    
    <div class="form-group">
        <label class="form-label">Full Name</label>
        <input 
            type="text" 
            name="name" 
            class="form-input" 
            placeholder="Enter your full name"
            value="<?php echo e(old('name')); ?>"
            required
        >
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

    <div class="form-group">
        <label class="form-label">Confirm Password</label>
        <input 
            type="password" 
            name="password_confirmation" 
            class="form-input" 
            placeholder="Confirm your password"
            required
        >
    </div>

    <button type="submit" class="btn-primary">Create Account</button>
</form>

<div class="auth-footer">
    Already have an account? <a href="<?php echo e(route('login')); ?>">Login here</a>
</div>

<div class="vendor-notice">
    <p>Want to sell on NepSole? <a href="<?php echo e(route('vendor.portal')); ?>">Become a Vendor</a></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/customer/auth/register.blade.php ENDPATH**/ ?>