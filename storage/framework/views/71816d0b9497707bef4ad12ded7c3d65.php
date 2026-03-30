<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Pending - NepSole</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f9fafb;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .status-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 3rem 2rem;
            text-align: center;
        }

        .status-icon {
            width: 80px;
            height: 80px;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 40px;
        }

        .status-title {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .status-message {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .info-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-title {
            color: #92400e;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-text {
            color: #92400e;
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #6366f1;
            color: white;
        }

        .btn-primary:hover {
            background: #4f46e5;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .timeline {
            margin-top: 2rem;
            text-align: left;
        }

        .timeline-title {
            color: #374151;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
        }

        .timeline-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .timeline-dot.completed {
            background: #10b981;
        }

        .timeline-dot.current {
            background: #fbbf24;
        }

        .timeline-dot.pending {
            background: #d1d5db;
        }

        .timeline-text {
            color: #6b7280;
            font-size: 14px;
        }

        .timeline-text.current {
            color: #374151;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="status-card">
            <div class="status-icon">⏳</div>
            
            <h1 class="status-title">Application Under Review</h1>
            
            <p class="status-message">
                Thank you for submitting your vendor application! Your account is currently being reviewed by our admin team.
            </p>

            <div class="info-box">
                <div class="info-title">What happens next?</div>
                <div class="info-text">
                    Our team will review your documents and business information. You'll receive an email notification once your account is approved. This process typically takes 1-3 business days.
                </div>
            </div>

            <div class="timeline">
                <div class="timeline-title">Application Status</div>
                
                <div class="timeline-item">
                    <div class="timeline-dot completed"></div>
                    <div class="timeline-text">Application Submitted</div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot current"></div>
                    <div class="timeline-text current">Under Admin Review</div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot pending"></div>
                    <div class="timeline-text">Account Activation</div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot pending"></div>
                    <div class="timeline-text">Email Confirmation</div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="/" class="btn btn-primary">Continue Shopping</a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary">Login as Customer</a>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/vendor/pending.blade.php ENDPATH**/ ?>