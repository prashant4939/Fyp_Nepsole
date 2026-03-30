<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .order-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Dispatched!</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $order->user->name }},</p>
            
            <p>Great news! Your order has been dispatched and is on its way to you.</p>
            
            <div class="order-details">
                <h3>Order Details</h3>
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method_label }}</p>
                
                <h4>Shipping Address:</h4>
                <p>
                    {{ $order->shippingAddress->full_name }}<br>
                    {{ $order->shippingAddress->address }}<br>
                    {{ $order->shippingAddress->city }}<br>
                    Landmark: {{ $order->shippingAddress->landmark }}<br>
                    Phone: {{ $order->shippingAddress->phone }}
                </p>
                
                <h4>Order Items:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs. {{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total:</strong></td>
                            <td><strong>Rs. {{ number_format($order->total_price, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <p>Your order will be delivered soon. Thank you for shopping with us!</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>
