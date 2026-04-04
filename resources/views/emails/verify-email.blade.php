<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #6366f1;
        }
        h1 {
            color: #111827;
            font-size: 24px;
            margin-bottom: 16px;
        }
        p {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: #6366f1;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
        }
        .info-box {
            background: #dbeafe;
            color: #1e40af;
            padding: 12px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <div style="display:inline-flex; align-items:center; gap:10px; text-decoration:none;">
                <div style="width:40px;height:40px;background:#6366f1;border-radius:9px;display:flex;align-items:center;justify-content:center;">
                    <svg width="24" height="24" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="13" height="13" rx="2.5" stroke="white" stroke-width="2.2" fill="none"/>
                        <rect x="20" y="3" width="13" height="7" rx="2.5" stroke="white" stroke-width="2.2" fill="none"/>
                        <rect x="20" y="14" width="13" height="16" rx="2.5" stroke="white" stroke-width="2.2" fill="none"/>
                        <rect x="3" y="20" width="13" height="13" rx="2.5" stroke="white" stroke-width="2.2" fill="none"/>
                    </svg>
                </div>
                <span class="logo-text">NepSole</span>
            </div>
        </div>
        
        <h1>Verify Your Email Address</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Thank you for registering with NepSole! To complete your registration and access your account, please verify your email address by clicking the button below:</p>
        
        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="btn">Verify Email Address</a>
        </div>
        
        <div class="info-box">
            ℹ️ <strong>Note:</strong> This verification link will expire in 60 minutes for security reasons.
        </div>
        
        <p>If you did not create an account with NepSole, no further action is required.</p>
        
        <p>If the button doesn't work, copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #6366f1;">{{ $verificationUrl }}</p>
        
        <div class="footer">
            <p>© 2025 NepSole. All rights reserved.</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>
