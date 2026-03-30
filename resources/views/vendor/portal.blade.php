<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Portal - NepSole</title>
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
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .back-link {
            display: inline-block;
            color: white;
            text-decoration: none;
            margin-bottom: 2rem;
            font-weight: 500;
            opacity: 0.9;
            transition: opacity 0.2s;
        }

        .back-link:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .portal-header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }

        .portal-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .portal-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .options-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .option-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .option-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .option-title {
            color: #1f2937;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .option-description {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .option-features {
            list-style: none;
            margin-bottom: 2rem;
            text-align: left;
        }

        .option-features li {
            color: #374151;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .option-features li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }

        .option-button {
            width: 100%;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #10b981;
            color: white;
        }

        .btn-primary:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6366f1;
            color: white;
        }

        .btn-secondary:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        .info-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2rem;
            margin-top: 3rem;
            color: white;
            text-align: center;
        }

        .info-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-text {
            opacity: 0.9;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .portal-title {
                font-size: 2rem;
            }

            .options-container {
                grid-template-columns: 1fr;
            }

            .option-card {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="back-link">← Back to Home</a>
        
        <div class="portal-header">
            <h1 class="portal-title">Vendor Portal</h1>
            <p class="portal-subtitle">
                Join thousands of successful vendors on NepSole and grow your business with our powerful e-commerce platform
            </p>
        </div>

        <div class="options-container">
            <!-- New Vendor Registration -->
            <div class="option-card">
                <div class="option-icon">🚀</div>
                <h2 class="option-title">New Vendor</h2>
                <p class="option-description">
                    Start your journey as a vendor on NepSole. Create your account and submit your business documents for approval.
                </p>
                <ul class="option-features">
                    <li>Complete business registration</li>
                    <li>Document verification process</li>
                    <li>Admin approval required</li>
                    <li>Full vendor dashboard access</li>
                    <li>Product management tools</li>
                </ul>
                <a href="{{ route('vendor.register.form') }}" class="option-button btn-primary">
                    Start Registration
                </a>
            </div>

            <!-- Existing Vendor Login -->
            <div class="option-card">
                <div class="option-icon">🔑</div>
                <h2 class="option-title">Existing Vendor</h2>
                <p class="option-description">
                    Already have a vendor account? Login to access your dashboard and manage your products and orders.
                </p>
                <ul class="option-features">
                    <li>Access vendor dashboard</li>
                    <li>Manage your products</li>
                    <li>View orders and analytics</li>
                    <li>Update business information</li>
                    <li>Customer support access</li>
                </ul>
                <a href="{{ route('login') }}" class="option-button btn-secondary">
                    Vendor Login
                </a>
            </div>
        </div>

        <div class="info-section">
            <h3 class="info-title">Why Choose NepSole?</h3>
            <p class="info-text">
                NepSole provides a comprehensive platform for vendors to showcase their products, manage inventory, 
                process orders, and grow their business. With our user-friendly interface and powerful tools, 
                you can focus on what matters most - your products and customers.
            </p>
        </div>
    </div>
</body>
</html>