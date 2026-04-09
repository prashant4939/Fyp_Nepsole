<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
    .container { max-width: 580px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .header { background: #6366f1; padding: 1.75rem 2rem; }
    .header h1 { color: #fff; margin: 0; font-size: 1.3rem; }
    .header p  { color: rgba(255,255,255,0.8); margin: 4px 0 0; font-size: 13px; }
    .body { padding: 2rem; color: #374151; line-height: 1.6; }
    .body h2 { color: #111827; font-size: 1rem; margin-top: 0; }
    .order-meta { background: #f5f3ff; border: 1px solid #c4b5fd; border-radius: 8px; padding: 1rem 1.25rem; margin: 1rem 0; display: flex; gap: 2rem; flex-wrap: wrap; }
    .meta-item .label { font-size: 11px; color: #7c3aed; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
    .meta-item .value { font-size: 14px; color: #111827; font-weight: 600; margin-top: 2px; }
    table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
    th { background: #f9fafb; padding: 0.6rem 0.75rem; text-align: left; font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; }
    td { padding: 0.75rem; font-size: 14px; color: #374151; border-bottom: 1px solid #f3f4f6; }
    tr:last-child td { border-bottom: none; }
    .total-row td { font-weight: 700; color: #111827; background: #f9fafb; }
    .btn { display: inline-block; margin: 1.25rem 0 0; padding: 0.75rem 2rem; background: #6366f1; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; }
    .shipping-box { background: #f9fafb; border-radius: 8px; padding: 1rem 1.25rem; margin-top: 1rem; font-size: 14px; }
    .shipping-box strong { display: block; margin-bottom: 4px; color: #111827; }
    .footer { background: #f9fafb; padding: 1rem 2rem; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🛒 New Order Received!</h1>
        <p>A customer just placed an order containing your products.</p>
    </div>
    <div class="body">
        <h2>Hi {{ $vendor->user->name }},</h2>
        <p>You have a new order. Please review the items below and confirm as soon as possible.</p>

        <div class="order-meta">
            <div class="meta-item">
                <div class="label">Order ID</div>
                <div class="value">#{{ $order->id }}</div>
            </div>
            <div class="meta-item">
                <div class="label">Payment</div>
                <div class="value">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Khalti' }}</div>
            </div>
            <div class="meta-item">
                <div class="label">Order Date</div>
                <div class="value">{{ $order->created_at->format('M d, Y h:i A') }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->size ?? '—' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                    <td>Rs. {{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4">Your Items Total</td>
                    <td>Rs. {{ number_format($items->sum(fn($i) => $i->quantity * $i->unit_price), 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="shipping-box">
            <strong>📦 Ship To:</strong>
            {{ $order->shippingAddress->full_name ?? $order->user->name }},
            {{ $order->shippingAddress->address }},
            {{ $order->shippingAddress->city }}
            @if($order->shippingAddress->phone)
                — {{ $order->shippingAddress->phone }}
            @endif
        </div>

        <a href="{{ route('vendor.orders.show', $order) }}" class="btn">View & Confirm Order →</a>
    </div>
    <div class="footer">&copy; {{ date('Y') }} NepSole. Please log in to confirm or manage this order.</div>
</div>
</body>
</html>
