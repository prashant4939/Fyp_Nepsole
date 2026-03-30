<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'NepSole'); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #000;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: #6366f1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .logo-text {
            font-size: 28px;
            font-weight: 600;
            color: #6366f1;
        }

        .auth-title {
            text-align: center;
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .auth-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            background: #f9fafb;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #6366f1;
            background: #fff;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 8px;
        }

        .btn-primary:hover {
            background: #4f46e5;
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            color: #6b7280;
            font-size: 14px;
        }

        .auth-footer a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .vendor-notice {
            text-align: center;
            margin-top: 20px;
            padding: 16px;
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
        }

        .vendor-notice p {
            color: #0c4a6e;
            font-size: 14px;
            margin: 0;
        }

        .vendor-notice a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
        }

        .vendor-notice a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">
            <div class="logo-icon">🛍️</div>
            <div class="logo-text">NepSole</div>
        </div>
        
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/layouts/auth.blade.php ENDPATH**/ ?>