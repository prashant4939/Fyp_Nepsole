<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NepSole</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.6;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 3rem;
            width: 100%;
            max-width: 400px;
            margin: 2rem;
        }

        .admin-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .admin-icon {
            width: 80px;
            height: 80px;
            background: #6366f1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }

        .admin-title {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .admin-subtitle {
            color: #6b7280;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f9fafb;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #6366f1;
            background: white;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 0.5rem;
            width: 16px;
            height: 16px;
        }

        .remember-me label {
            margin-bottom: 0;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            background: #6366f1;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        .login-btn:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 14px;
        }

        .back-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .back-link a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .security-notice {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            color: #92400e;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 13px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .admin-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="admin-header">
            <div class="admin-icon">🔐</div>
            <h1 class="admin-title">Admin Panel</h1>
            <p class="admin-subtitle">Secure Administrator Access</p>
        </div>

        <div class="security-notice">
            🛡️ This is a restricted area for administrators only
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">Admin Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="login-btn">
                🚀 Access Admin Panel
            </button>
        </form>

        <div class="back-link">
            <a href="/">← Back to Main Site</a>
        </div>
    </div>
</body>
</html>