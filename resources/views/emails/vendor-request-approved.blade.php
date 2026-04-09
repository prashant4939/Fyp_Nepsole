<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
    .container { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .header { background: #6366f1; padding: 2rem; text-align: center; }
    .header h1 { color: #fff; margin: 0; font-size: 1.4rem; }
    .body { padding: 2rem; color: #374151; line-height: 1.6; }
    .body h2 { color: #111827; font-size: 1.1rem; margin-top: 0; }
    .credentials-box { background: #f5f3ff; border: 1px solid #c4b5fd; border-radius: 10px; padding: 1.25rem 1.5rem; margin: 1.25rem 0; }
    .credentials-box .label { font-size: 12px; color: #7c3aed; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem; }
    .credentials-box .value { font-size: 1rem; color: #111827; font-weight: 600; margin-bottom: 0.75rem; }
    .pin-display { font-size: 2rem; font-weight: 800; letter-spacing: 0.4em; color: #6366f1; font-family: monospace; }
    .btn { display: inline-block; margin: 1rem 0; padding: 0.75rem 2rem; background: #6366f1; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 15px; }
    .note { font-size: 12px; background: #fef3c7; border-radius: 6px; padding: 0.75rem 1rem; color: #92400e; margin-top: 1rem; }
    .footer { background: #f9fafb; padding: 1rem 2rem; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎉 Welcome to NepSole Vendors!</h1>
    </div>
    <div class="body">
        <h2>Hi {{ $vendorName }},</h2>
        <p>Your vendor application for <strong>{{ $shopName }}</strong> has been <strong>approved</strong>.</p>

        @if($pin)
            <p>Your account has been created. Here are your login credentials:</p>
            <div class="credentials-box">
                <div class="label">Email</div>
                <div class="value">{{ $vendorName }}</div>
                <div class="label">Temporary Password (PIN)</div>
                <div class="pin-display">{{ $pin }}</div>
            </div>
            <p class="note">⚠️ Please change this PIN to a strong password immediately after logging in.</p>
        @else
            <p>Your existing account has been upgraded to a vendor account. You can log in with your current password.</p>
        @endif

        <a href="{{ route('vendor.login') }}" class="btn">Login to Vendor Dashboard</a>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} NepSole. If you didn't apply to become a vendor, please contact us.
    </div>
</div>
</body>
</html>
