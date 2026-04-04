

<?php $__env->startSection('title', 'Shopping Cart - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<div class="cart-page">
    <div class="container">
        <div class="page-header">
            <h1>Shopping Cart</h1>
            <a href="<?php echo e(route('products.index')); ?>" class="continue-shopping">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Continue Shopping
            </a>
        </div>

        <?php if($cartItems->count() > 0): ?>
            <div class="cart-layout">
                <!-- Cart Items -->
                <div class="cart-items">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cart-item" data-cart-id="<?php echo e($item->id); ?>">
                            <div class="item-image">
                                <?php if($item->product->images->count() > 0): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->product->images->first()->image)); ?>" alt="<?php echo e($item->product->name); ?>">
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="item-details">
                                <h3><?php echo e($item->product->name); ?></h3>
                                <?php if($item->variant): ?>
                                    <p class="item-size">Size: <strong><?php echo e($item->variant->size); ?></strong></p>
                                <?php endif; ?>
                                <p class="item-category"><?php echo e($item->product->category->name); ?></p>
                                <?php if($item->product->brand): ?>
                                    <p class="item-brand"><?php echo e($item->product->brand->name); ?></p>
                                <?php endif; ?>
                                <p class="item-price">Rs. <?php echo e(number_format($item->product->price, 2)); ?></p>
                            </div>
                            
                            <div class="item-quantity">
                                <label>Quantity</label>
                                <div class="quantity-controls">
                                    <button class="qty-btn" onclick="updateQuantity(<?php echo e($item->id); ?>, <?php echo e($item->quantity - 1); ?>)" <?php echo e($item->quantity <= 1 ? 'disabled' : ''); ?>>-</button>
                                    <input type="number" value="<?php echo e($item->quantity); ?>" min="1" readonly>
                                    <button class="qty-btn" onclick="updateQuantity(<?php echo e($item->id); ?>, <?php echo e($item->quantity + 1); ?>)">+</button>
                                </div>
                            </div>
                            
                            <div class="item-subtotal">
                                <label>Subtotal</label>
                                <p class="subtotal-amount" id="subtotal-<?php echo e($item->id); ?>">Rs. <?php echo e(number_format($item->quantity * $item->product->price, 2)); ?></p>
                            </div>
                            
                            <button class="remove-btn" onclick="removeItem(<?php echo e($item->id); ?>)">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    
                    <div class="summary-row">
                        <span>Subtotal (<?php echo e($cartItems->sum('quantity')); ?> items)</span>
                        <span id="cartSubtotal">Rs. <?php echo e(number_format($subtotal, 2)); ?></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Calculated at checkout</span>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span id="cartTotal">Rs. <?php echo e(number_format($subtotal, 2)); ?></span>
                    </div>
                    
                    <button class="checkout-btn" onclick="window.location.href='<?php echo e(route('checkout.index')); ?>'">
                        Proceed to Checkout
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <svg width="120" height="120" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h2>Your cart is empty</h2>
                <p>Add some products to get started!</p>
                <a href="<?php echo e(route('products.index')); ?>" class="shop-now-btn">Shop Now</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateQuantity(cartId, newQuantity) {
    if (newQuantity < 1) {
        showNotification('Quantity cannot be less than 1', 'error');
        return;
    }
    
    fetch(`/cart/${cartId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update item subtotal
            document.getElementById(`subtotal-${cartId}`).textContent = `Rs. ${data.itemSubtotal.toFixed(2)}`;
            
            // Update cart totals
            document.getElementById('cartSubtotal').textContent = `Rs. ${data.subtotal.toFixed(2)}`;
            document.getElementById('cartTotal').textContent = `Rs. ${data.subtotal.toFixed(2)}`;
            
            // Update quantity input
            const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
            cartItem.querySelector('input[type="number"]').value = newQuantity;
            
            // Update buttons state
            const minusBtn = cartItem.querySelector('.quantity-controls button:first-child');
            if (newQuantity <= 1) {
                minusBtn.disabled = true;
                minusBtn.style.opacity = '0.5';
                minusBtn.style.cursor = 'not-allowed';
            } else {
                minusBtn.disabled = false;
                minusBtn.style.opacity = '1';
                minusBtn.style.cursor = 'pointer';
            }
            
            // Update cart count in navbar
            fetch('<?php echo e(route('cart.count')); ?>')
                .then(response => response.json())
                .then(countData => {
                    const badge = document.getElementById('cartBadge');
                    if (badge) {
                        if (countData.count > 0) {
                            badge.textContent = countData.count;
                            badge.style.display = 'block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
            
            showNotification('Cart updated', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const message = error.message || 'Failed to update cart';
        showNotification(message, 'error');
    });
}

function removeItem(cartId) {
    if (!confirm('Remove this item from cart?')) return;
    
    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from DOM
            const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
            cartItem.remove();
            
            // Update cart count in navbar
            const badge = document.getElementById('cartBadge');
            if (badge) {
                if (data.cartCount > 0) {
                    badge.textContent = data.cartCount;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            }
            
            // Check if cart is empty
            if (document.querySelectorAll('.cart-item').length === 0) {
                location.reload();
            }
            
            showNotification('Item removed from cart', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to remove item', 'error');
    });
}

function showNotification(message, type = 'success') {
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
            ${type === 'success' 
                ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>'
                : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
            }
        </svg>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

<style>
.cart-page {
    background: #f9fafb;
    min-height: 100vh;
    padding: 2rem 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.continue-shopping {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    transition: all 0.2s;
}

.continue-shopping:hover {
    background: white;
    border-color: #10b981;
    color: #10b981;
}

.cart-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

.cart-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.cart-item {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    display: grid;
    grid-template-columns: 100px 1fr auto auto auto;
    gap: 1.5rem;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.item-image img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
}

.no-image {
    width: 100px;
    height: 100px;
    background: #f3f4f6;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 12px;
}

.item-details h3 {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.5rem 0;
}

.item-size {
    font-size: 13px;
    color: #10b981;
    margin: 0.25rem 0;
    font-weight: 500;
}

.item-size strong {
    color: #059669;
    font-weight: 700;
}

.item-category, .item-brand {
    font-size: 13px;
    color: #6b7280;
    margin: 0 0 0.25rem 0;
}

.item-price {
    font-size: 20px;
    font-weight: 700;
    color: #10b981;
    margin: 0.5rem 0 0 0;
}

.item-quantity label,
.item-subtotal label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-controls button {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 16px;
}

.quantity-controls button:hover:not(:disabled) {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.quantity-controls button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f3f4f6;
}

.quantity-controls input {
    width: 50px;
    height: 32px;
    text-align: center;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-weight: 600;
}

.subtotal-amount {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.remove-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: #fee2e2;
    color: #ef4444;
    cursor: pointer;
    transition: all 0.2s;
}

.remove-btn:hover {
    background: #fca5a5;
    transform: scale(1.1);
}

.cart-summary {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.cart-summary h2 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 1.5rem 0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 14px;
    color: #6b7280;
}

.summary-row.total {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 0;
}

.summary-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 1.5rem 0;
}

.checkout-btn {
    width: 100%;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 14px 24px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    transition: all 0.2s;
}

.checkout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
}

.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.empty-cart svg {
    color: #d1d5db;
    margin-bottom: 2rem;
}

.empty-cart h2 {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.5rem 0;
}

.empty-cart p {
    font-size: 16px;
    color: #6b7280;
    margin: 0 0 2rem 0;
}

.shop-now-btn {
    display: inline-block;
    background: #10b981;
    color: white;
    padding: 14px 32px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.2s;
}

.shop-now-btn:hover {
    background: #059669;
    transform: translateY(-2px);
}

.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 9999;
    opacity: 0;
    transform: translateX(100px);
    transition: all 0.3s;
}

.notification.show {
    opacity: 1;
    transform: translateX(0);
}

.notification-success {
    border-left: 4px solid #10b981;
}

.notification-success svg {
    color: #10b981;
}

.notification-error {
    border-left: 4px solid #ef4444;
}

.notification-error svg {
    color: #ef4444;
}

.notification span {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
}

@media (max-width: 1024px) {
    .cart-layout {
        grid-template-columns: 1fr;
    }
    
    .cart-summary {
        position: static;
    }
    
    .cart-item {
        grid-template-columns: 80px 1fr;
        gap: 1rem;
    }
    
    .item-quantity,
    .item-subtotal {
        grid-column: 1 / -1;
    }
    
    .remove-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/customer/cart/index.blade.php ENDPATH**/ ?>