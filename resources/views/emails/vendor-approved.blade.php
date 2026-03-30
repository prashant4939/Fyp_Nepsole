<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vendor Account Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .button { background: #6366f1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 20px 0; }
        .footer { text-align: center; color: #666; font-size: 14px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Congratulations!</h1>
            <h2>Your Vendor Account is Approved</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $vendor_name }},</p>
            
            <p>Great news! Your vendor application for <strong>{{ $business_name }}</strong> has been approved by our admin team.</p>
            
            <p>You can now:</p>
            <ul>
                <li>Login to your vendor dashboard</li>
                <li>Add and manage your products</li>
                <li>Process orders from customers</li>
                <li>Access vendor tools and analytics</li>
            </ul>
            
            <p style="text-align: center;">
                <a href="{{ $login_url }}" class="button">Login to Your Account</a>
            </p>
            
            <p>Welcome to the NepSole marketplace! We're excited to have you as a vendor partner.</p>
            
            <p>Best regards,<br>The NepSole Team</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} NepSole. All rights reserved.</p>
        </div>
    </div>
</body>
</html>