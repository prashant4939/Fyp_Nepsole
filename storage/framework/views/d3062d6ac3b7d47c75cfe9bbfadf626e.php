<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Login - NepSole</title>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="login-header">
                <h1>Vendor Login</h1>
                <p>Access your vendor dashboard</p>
            </div>

            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('vendor.login.post')); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">Login to Dashboard</button>
            </form>

            <div class="register-section">
                <p>New vendor? <a href="<?php echo e(route('vendor.register.form')); ?>">Register your business</a></p>
            </div>

            <div class="back-section">
                <a href="/" class="back-link">← Back to Home</a>
            </div>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .container {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            padding: 3rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 14px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .alert ul {
            list-style: none;
            margin: 0;
        }

        .alert li {
            margin-bottom: 0.25rem;
        }

        .alert li:last-child {
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #374151;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #10b981;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 14px;
            color: #374151;
        }

        .checkbox-label input[type="checkbox"] {
            width: auto;
            cursor: pointer;
        }

        .forgot-link {
            color: #10b981;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #059669;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-login:hover {
            background: #059669;
        }

        .register-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .register-section p {
            color: #6b7280;
            font-size: 14px;
        }

        .register-section a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .register-section a:hover {
            color: #059669;
            text-decoration: underline;
        }

        .back-section {
            text-align: center;
            margin-top: 1rem;
        }

        .back-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #374151;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 2rem;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }
    </style>
</body>
</html>
<?php /**PATH C:\Users\Krishna\Desktop\Fyp_Nepsole\resources\views/vendor/login.blade.php ENDPATH**/ ?>