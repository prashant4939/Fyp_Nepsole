<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
    .container { max-width: 580px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .header { background: #10b981; padding: 1.75rem 2rem; }
    .header h1 { color: #fff; margin: 0; font-size: 1.3rem; }
    .header p  { color: rgba(255,255,255,0.85); margin: 4px 0 0; font-size: 13px; }
    .body { padding: 2rem; color: #374151; line-height: 1.6; }
    .body h2 { color: #111827; font-size: 1rem; margin-top: 0; }
    .item-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 1.25rem; margin: 1rem 0; }
    .item-box .product-name { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem; }
    .item-detail { display: flex; gap: 1.5rem; flex-wrap: wrap; margin-top: 0.5rem; }
    .item-detail span { font-size: 13px; color: #6b7280; }
    .item-detail span strong { color: #111827; }
    .order-meta { background: #f9fafb; border-radius: 8px; padding: 1rem 1.25rem; margin: 1rem 0; display: flex; gap: 2rem; flex-wrap: wrap; }
    .meta-item .label { font-size: 11px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
    .meta-item .value { font-size: 14px; color: #111827; font-weight: 600; margin-top: 2px; }
    .btn { display: inline-block; margin: 1.25rem 0 0; padding: 0.75rem 2rem; background: #10b981; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; }
    .note { font-size: 13px; color: #6b7280; margin-top: 1rem; }
    .footer { background: #f9fafb; padding: 1rem 2rem; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>✅ Your Order Item is Confirmed!</h1>
        <p>Great news — the vendor has confirmed your item.</p>
    </div>
    <div class="body">
        <h2>Hi {{ $order->user->name }},</h2>
        <p>The vendor has confirmed one of the items in your order <strong>#{{ $order->id }}</strong>. Here are the details:</p>

        <div class="item-box">
            <div class="product-name">{{ $orderItem->product->name }}</div>
            <div class="item-detail">
                <span><strong>Size:</strong> {{ $orderItem->size ?? '—' }}</span>
                <span><strong>Qty:</strong> {{ $orderItem->quantity }}</span>
                <span><strong>Price:</strong> Rs. {{ number_format($orderItem->unit_price, 2) }}</span>
                <span><strong>Subtotal:</strong> Rs. {{ number_format($orderItem->quantity * $orderItem->unit_price, 2) }}</span>
            </div>
        </div>

        <div class="order-meta">
            <div class="meta-item">
                <div class="label">Order ID</div>
                <div class="value">#{{ $order->id }}</div>
            </div>
            <div class="meta-item">
                <div class="label">Payment</div>
                <div class="value">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Khalti (Paid)' }}</div>
            </div>
            <div class="meta-item">
                <div class="label">Order Status</div>
                <div class="value">{{ ucfirst($order->order_status) }}</div>
            </div>
        </div>

        <p class="note">Your item is being prepared for dispatch. You can track your full order status using the button below.</p>

        <a href="{{ $trackUrl }}" class="btn">Track My Order →</a>
    </div>
    <div class="footer">&copy; {{ date('Y') }} NepSole. Thank you for shopping with us!</div>
</div>
</body>
</html>
