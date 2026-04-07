

<?php $__env->startSection('title', 'Order Placed Successfully - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<div class="success-page">
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <h1>Order Placed Successfully!</h1>
            <p class="success-message">Thank you for your order. We'll send you a confirmation email shortly.</p>
            
            <div class="order-info">
                <div class="info-row">
                    <span class="label">Order ID:</span>
                    <span class="value">#<?php echo e($order->id); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Total Amount:</span>
                    <span class="value">Rs. <?php echo e(number_format($order->total_price, 2)); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Payment Method:</span>
                    <span class="value"><?php echo e($order->payment_method_label); ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Status:</span>
                    <span class="badge badge-<?php echo e($order->status_color); ?>"><?php echo e(ucfirst($order->order_status)); ?></span>
                </div>
            </div>

            <div class="shipping-info">
                <h3>Shipping Address</h3>
                <p><strong><?php echo e($order->shippingAddress->full_name); ?></strong></p>
                <p><?php echo e($order->shippingAddress->phone); ?></p>
                <p><?php echo e($order->shippingAddress->address); ?></p>
                <p><?php echo e($order->shippingAddress->city); ?><?php if($order->shippingAddress->landmark): ?>, <?php echo e($order->shippingAddress->landmark); ?><?php endif; ?></p>
            </div>

            <div class="action-buttons">
                <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn-primary">View Order Details</a>
                <a href="<?php echo e(route('products.index')); ?>" class="btn-secondary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<style>
.success-page {
    background: #f9fafb;
    min-height: 100vh;
    padding: 4rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 2rem;
}

.success-card {
    background: white;
    border-radius: 16px;
    padding: 3rem 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.success-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 120px;
    height: 120px;
    background: #d1fae5;
    border-radius: 50%;
    margin-bottom: 2rem;
}

.success-icon svg {
    color: #10b981;
}

.success-card h1 {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 1rem 0;
}

.success-message {
    font-size: 16px;
    color: #6b7280;
    margin: 0 0 2rem 0;
}

.order-info {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    text-align: left;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-size: 14px;
    color: #6b7280;
}

.info-row .value {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
}

.badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.shipping-info {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    text-align: left;
}

.shipping-info h3 {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 1rem 0;
}

.shipping-info p {
    font-size: 14px;
    color: #6b7280;
    margin: 0.25rem 0;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-primary, .btn-secondary {
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary {
    background: #10b981;
    color: white;
}

.btn-primary:hover {
    background: #059669;
    transform: translateY(-2px);
}

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background: #f9fafb;
}

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    .success-card {
        padding: 2rem 1.5rem;
    }
    
    .success-card h1 {
        font-size: 24px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        text-align: center;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/customer/orders/success.blade.php ENDPATH**/ ?>