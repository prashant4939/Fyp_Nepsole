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
    .detail-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
    .detail-table td { padding: 0.6rem 0.75rem; font-size: 14px; border-bottom: 1px solid #f3f4f6; }
    .detail-table td:first-child { font-weight: 600; color: #6b7280; width: 35%; }
    .btn { display: inline-block; margin: 1rem 0; padding: 0.75rem 2rem; background: #6366f1; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 15px; }
    .footer { background: #f9fafb; padding: 1rem 2rem; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📋 New Vendor Application</h1>
    </div>
    <div class="body">
        <h2>A new vendor application has been submitted.</h2>
        <table class="detail-table">
            <tr><td>Name</td><td>{{ $vendorRequest->name }}</td></tr>
            <tr><td>Email</td><td>{{ $vendorRequest->email }}</td></tr>
            <tr><td>Phone</td><td>{{ $vendorRequest->phone }}</td></tr>
            <tr><td>Shop Name</td><td>{{ $vendorRequest->shop_name }}</td></tr>
            <tr><td>Address</td><td>{{ $vendorRequest->address }}</td></tr>
            <tr><td>Submitted</td><td>{{ $vendorRequest->created_at->format('M d, Y H:i') }}</td></tr>
        </table>
        <a href="{{ route('admin.vendor-requests.index') }}" class="btn">Review in Admin Panel</a>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} NepSole Admin Notification
    </div>
</div>
</body>
</html>
