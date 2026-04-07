

<?php $__env->startSection('title', 'Order #<?php echo e($order->id); ?> - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<div class="order-page">
    <div class="container">

        <div class="page-header">
            <div>
                <h1>Order #<?php echo e($order->id); ?></h1>
                <p class="order-date">Placed on <?php echo e($order->created_at->format('M d, Y \a\t h:i A')); ?></p>
            </div>
            <a href="<?php echo e(route('orders.index')); ?>" class="btn-back">← My Orders</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="order-layout">

            <!-- Left: Items + Shipping -->
            <div class="order-main">

                <!-- Order Items -->
                <div class="order-card">
                    <h2 class="card-title">Order Items</h2>
                    <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="order-item">
                            <div class="item-img">
                                <?php if($item->product && $item->product->images->count() > 0): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->product->images->first()->image)); ?>"
                                         alt="<?php echo e($item->product->name); ?>">
                                <?php else: ?>
                                    <div class="img-placeholder">👟</div>
                                <?php endif; ?>
                            </div>
                            <div class="item-info">
                                <p class="item-name"><?php echo e($item->product->name ?? 'Product'); ?></p>
                                <?php if($item->size): ?>
                                    <p class="item-meta">Size: <?php echo e($item->size); ?></p>
                                <?php endif; ?>
                                <p class="item-meta">Qty: <?php echo e($item->quantity); ?></p>
                                <?php if($item->vendor): ?>
                                    <p class="item-meta">Sold by: <?php echo e($item->vendor->business_name); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="item-price">
                                Rs. <?php echo e(number_format($item->unit_price * $item->quantity, 2)); ?>

                                <span class="unit-price">Rs. <?php echo e(number_format($item->unit_price, 2)); ?> each</span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Shipping Address -->
                <div class="order-card">
                    <h2 class="card-title">Shipping Address</h2>
                    <?php if($order->shippingAddress): ?>
                        <div class="address-block">
                            <p><strong><?php echo e($order->shippingAddress->full_name); ?></strong></p>
                            <p>📞 <?php echo e($order->shippingAddress->phone); ?></p>
                            <p>📍 <?php echo e($order->shippingAddress->address); ?></p>
                            <p>🏙️ <?php echo e($order->shippingAddress->city); ?>

                                <?php if($order->shippingAddress->landmark): ?>, <?php echo e($order->shippingAddress->landmark); ?><?php endif; ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No shipping address found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Summary -->
            <div class="order-sidebar">
                <div class="order-card">
                    <h2 class="card-title">Order Summary</h2>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rs. <?php echo e(number_format($order->orderItems->sum(fn($i) => $i->unit_price * $i->quantity), 2)); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Rs. <?php echo e(number_format($order->total_price - $order->orderItems->sum(fn($i) => $i->unit_price * $i->quantity), 2)); ?></span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rs. <?php echo e(number_format($order->total_price, 2)); ?></span>
                    </div>

                    <div class="status-section">
                        <div class="status-row">
                            <span class="status-label">Order Status</span>
                            <span class="badge badge-<?php echo e($order->status_color); ?>">
                                <?php echo e(ucfirst($order->order_status)); ?>

                            </span>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Payment</span>
                            <span class="badge <?php echo e(($order->payment_status ?? 'pending') === 'paid' ? 'badge-success' : 'badge-warning'); ?>">
                                <?php echo e(ucfirst($order->payment_status ?? 'pending')); ?>

                            </span>
                        </div>
                        <div class="status-row">
                            <span class="status-label">Method</span>
                            <span class="method-text"><?php echo e($order->payment_method_label); ?></span>
                        </div>
                        <?php if($order->transaction_id): ?>
                            <div class="status-row">
                                <span class="status-label">Transaction ID</span>
                                <span class="txn-id"><?php echo e($order->transaction_id); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <a href="<?php echo e(route('products.index')); ?>" class="btn-shop">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<style>
.order-page {
    background: #f3f4f6;
    min-height: calc(100vh - 130px);
    padding: 2rem 0;
}

.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.page-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.25rem;
}

.order-date { font-size: 13px; color: #9ca3af; margin: 0; }

.btn-back {
    padding: 0.5rem 1rem;
    background: white;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    text-decoration: none;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-back:hover { border-color: #6366f1; color: #6366f1; }

.alert { padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 14px; font-weight: 500; }
.alert-success { background: #d1fae5; color: #065f46; }

.order-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 1.5rem;
    align-items: start;
}

.order-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 1.25rem;
    padding-bottom: 0.875rem;
    border-bottom: 1px solid #f3f4f6;
}

/* Items */
.order-item {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.order-item:last-child { border-bottom: none; }

.item-img { width: 72px; height: 72px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
.item-img img { width: 100%; height: 100%; object-fit: cover; }
.img-placeholder { width: 100%; height: 100%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 28px; }

.item-info { flex: 1; }
.item-name { font-size: 14px; font-weight: 600; color: #111827; margin: 0 0 0.25rem; }
.item-meta { font-size: 12px; color: #9ca3af; margin: 0.1rem 0; }

.item-price { text-align: right; font-size: 15px; font-weight: 700; color: #111827; white-space: nowrap; }
.unit-price { display: block; font-size: 11px; color: #9ca3af; font-weight: 400; margin-top: 2px; }

/* Address */
.address-block p { font-size: 14px; color: #374151; margin: 0.3rem 0; }

/* Summary */
.summary-row { display: flex; justify-content: space-between; font-size: 14px; color: #374151; margin-bottom: 0.75rem; }
.summary-row.total { font-size: 16px; font-weight: 700; color: #111827; }
.summary-divider { height: 1px; background: #e5e7eb; margin: 0.75rem 0; }

.status-section { margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #f3f4f6; }
.status-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; }
.status-label { font-size: 13px; color: #6b7280; }
.method-text { font-size: 13px; font-weight: 600; color: #111827; }
.txn-id { font-size: 11px; color: #6b7280; font-family: monospace; max-width: 140px; overflow: hidden; text-overflow: ellipsis; }

.badge { padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-warning { background: #fef3c7; color: #92400e; }
.badge-success { background: #d1fae5; color: #065f46; }
.badge-info    { background: #dbeafe; color: #1e40af; }
.badge-primary { background: #e0e7ff; color: #3730a3; }
.badge-danger  { background: #fee2e2; color: #991b1b; }

.btn-shop {
    display: block;
    text-align: center;
    padding: 0.875rem;
    background: #6366f1;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: background 0.2s;
}

.btn-shop:hover { background: #4f46e5; }

.text-muted { color: #9ca3af; font-size: 14px; }

@media (max-width: 768px) {
    .order-layout { grid-template-columns: 1fr; }
    .page-header { flex-direction: column; gap: 1rem; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/customer/orders/show.blade.php ENDPATH**/ ?>