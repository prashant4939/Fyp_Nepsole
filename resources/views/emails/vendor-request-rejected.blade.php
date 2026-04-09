<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
    .container { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .header { background: #374151; padding: 2rem; text-align: center; }
    .header h1 { color: #fff; margin: 0; font-size: 1.4rem; }
    .body { padding: 2rem; color: #374151; line-height: 1.6; }
    .body h2 { color: #111827; font-size: 1.1rem; margin-top: 0; }
    .reason-box { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem 1.25rem; border-radius: 6px; margin: 1rem 0; font-size: 14px; color: #92400e; }
    .footer { background: #f9fafb; padding: 1rem 2rem; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Vendor Application Update</h1>
    </div>
    <div class="body">
        <h2>Hi {{ $vendorName }},</h2>
        <p>Thank you for your interest in selling on NepSole. After reviewing your application for <strong>{{ $shopName }}</strong>, we are unable to approve it at this time.</p>
        <p><strong>Reason from our team:</strong></p>
        <div class="reason-box">{{ $adminMessage }}</div>
        <p>If you believe this was a mistake or would like to reapply after addressing the above, feel free to submit a new application.</p>
        <p>We appreciate your understanding.</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} NepSole. Questions? Contact our support team.
    </div>
</div>
</body>
</html>
