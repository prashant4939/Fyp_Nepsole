

<?php $__env->startSection('title', 'Checkout - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/checkout.css')); ?>">
<div class="checkout-page">
    <div class="container">
        <div class="page-header">
            <h1>Checkout</h1>
            <a href="<?php echo e(route('cart.index')); ?>" class="back-link">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Cart
            </a>
        </div>

        <div class="checkout-layout">
            <!-- Left: Shipping & Payment -->
            <div class="checkout-main">
                <!-- Shipping Address Section -->
                <div class="checkout-section">
                    <h2>
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Shipping Address
                    </h2>

                    <?php if($shippingAddresses->count() > 0): ?>
                        <p class="section-hint">Select a shipping address or add a new one</p>
                        
                        <!-- Show only default address initially -->
                        <div id="defaultAddressView">
                            <?php if($defaultAddress): ?>
                                <div class="address-card default selected" data-address-id="<?php echo e($defaultAddress->id); ?>">
                                    <input type="radio" 
                                           name="shipping_address_id" 
                                           value="<?php echo e($defaultAddress->id); ?>" 
                                           id="address-<?php echo e($defaultAddress->id); ?>"
                                           checked>
                                    <label for="address-<?php echo e($defaultAddress->id); ?>">
                                        <div class="address-header">
                                            <div class="address-title">
                                                <div class="radio-indicator"></div>
                                                <strong><?php echo e($defaultAddress->full_name); ?></strong>
                                            </div>
                                            <span class="default-badge">Default</span>
                                        </div>
                                        <p class="address-phone">📞 <?php echo e($defaultAddress->phone); ?></p>
                                        <p class="address-text">📍 <?php echo e($defaultAddress->address); ?></p>
                                        <p class="address-city">🏙️ <?php echo e($defaultAddress->city); ?><?php if($defaultAddress->landmark): ?>, <?php echo e($defaultAddress->landmark); ?><?php endif; ?></p>
                                    </label>
                                </div>
                            <?php else: ?>
                                <div class="address-card selected" data-address-id="<?php echo e($shippingAddresses->first()->id); ?>">
                                    <input type="radio" 
                                           name="shipping_address_id" 
                                           value="<?php echo e($shippingAddresses->first()->id); ?>" 
                                           id="address-<?php echo e($shippingAddresses->first()->id); ?>"
                                           checked>
                                    <label for="address-<?php echo e($shippingAddresses->first()->id); ?>">
                                        <div class="address-header">
                                            <div class="address-title">
                                                <div class="radio-indicator"></div>
                                                <strong><?php echo e($shippingAddresses->first()->full_name); ?></strong>
                                            </div>
                                        </div>
                                        <p class="address-phone">📞 <?php echo e($shippingAddresses->first()->phone); ?></p>
                                        <p class="address-text">📍 <?php echo e($shippingAddresses->first()->address); ?></p>
                                        <p class="address-city">🏙️ <?php echo e($shippingAddresses->first()->city); ?><?php if($shippingAddresses->first()->landmark): ?>, <?php echo e($shippingAddresses->first()->landmark); ?><?php endif; ?></p>
                                    </label>
                                </div>
                            <?php endif; ?>
                            
                            <div class="address-actions">
                                <button type="button" class="change-address-btn" onclick="showAllAddresses()">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    Change Address
                                </button>
                                <button type="button" class="add-address-btn-inline" onclick="toggleAddressForm()">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add New Address
                                </button>
                            </div>
                        </div>

                        <!-- All addresses view (hidden by default) -->
                        <div id="allAddressesView" style="display: none;">
                            <div class="address-list">
                                <?php $__currentLoopData = $shippingAddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="address-card <?php echo e($address->is_default ? 'default' : ''); ?> <?php echo e($address->is_default || (!$defaultAddress && $loop->first) ? 'selected' : ''); ?>" 
                                         data-address-id="<?php echo e($address->id); ?>"
                                         onclick="selectAddress(<?php echo e($address->id); ?>)">
                                        <input type="radio" 
                                               name="shipping_address_id_all" 
                                               value="<?php echo e($address->id); ?>" 
                                               id="address-all-<?php echo e($address->id); ?>"
                                               <?php echo e($address->is_default || (!$defaultAddress && $loop->first) ? 'checked' : ''); ?>>
                                        <label for="address-all-<?php echo e($address->id); ?>">
                                            <div class="address-header">
                                                <div class="address-title">
                                                    <div class="radio-indicator"></div>
                                                    <strong><?php echo e($address->full_name); ?></strong>
                                                </div>
                                                <?php if($address->is_default): ?>
                                                    <span class="default-badge">Default</span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="address-phone">📞 <?php echo e($address->phone); ?></p>
                                            <p class="address-text">📍 <?php echo e($address->address); ?></p>
                                            <p class="address-city">🏙️ <?php echo e($address->city); ?><?php if($address->landmark): ?>, <?php echo e($address->landmark); ?><?php endif; ?></p>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <div class="address-actions">
                                <button type="button" class="confirm-address-btn" onclick="confirmAddressSelection()">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Confirm Selection
                                </button>
                                <button type="button" class="add-address-btn-inline" onclick="toggleAddressForm()">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add New Address
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="no-address-state">
                            <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="no-address">No shipping address found. Please add one to continue.</p>
                            <button type="button" class="add-address-btn-primary" onclick="toggleAddressForm()">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Shipping Address
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Add Address Form (Hidden by default) -->
                    <div class="add-address-form" id="addAddressForm" style="display: none;">
                        <h3>Add New Address</h3>
                        <form id="addressForm">
                            <?php echo csrf_field(); ?>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Full Name *</label>
                                    <input type="text" name="full_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone *</label>
                                    <input type="tel" name="phone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address *</label>
                                <textarea name="address" rows="2" required></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>City *</label>
                                    <input type="text" name="city" required>
                                </div>
                                <div class="form-group">
                                    <label>Landmark</label>
                                    <input type="text" name="landmark">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_default" value="1">
                                    <span>Set as default address</span>
                                </label>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn-secondary" onclick="toggleAddressForm()">Cancel</button>
                                <button type="submit" class="btn-primary">Save Address</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="checkout-section">
                    <h2>
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Payment Method
                    </h2>

                    <div class="payment-methods">
                        <div class="payment-option" onclick="selectPaymentMethod('cod')">
                            <input type="radio" name="payment_method" value="cod" id="payment-cod" checked>
                            <label for="payment-cod">
                                <div class="payment-icon">💵</div>
                                <div class="payment-info">
                                    <strong>Cash on Delivery</strong>
                                    <p>Pay when you receive your order</p>
                                </div>
                                <div class="payment-check">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </label>
                        </div>

                        <div class="payment-option" onclick="selectPaymentMethod('khalti')">
                            <input type="radio" name="payment_method" value="khalti" id="payment-khalti">
                            <label for="payment-khalti">
                                <div class="payment-icon" style="background:#5C2D91;border-radius:8px;padding:4px;">
                                    <img src="https://khalti.com/static/khalti-logo.png"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='block'"
                                         style="height:28px;width:auto;" alt="Khalti">
                                    <span style="display:none;color:white;font-weight:700;font-size:14px;">K</span>
                                </div>
                                <div class="payment-info">
                                    <strong>Khalti</strong>
                                    <p>Pay securely with Khalti digital wallet</p>
                                </div>
                                <div class="payment-check">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="order-summary">
                <h2>Order Summary</h2>
                
                <div class="summary-items">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="summary-item">
                            <div class="item-image">
                                <?php if($item->product->images->count() > 0): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->product->images->first()->image)); ?>" alt="<?php echo e($item->product->name); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="item-details">
                                <p class="item-name"><?php echo e($item->product->name); ?></p>
                                <?php if($item->variant): ?>
                                    <p class="item-size">Size: <?php echo e($item->variant->size); ?></p>
                                <?php endif; ?>
                                <p class="item-qty">Qty: <?php echo e($item->quantity); ?></p>
                            </div>
                            <p class="item-price">Rs. <?php echo e(number_format($item->quantity * $item->product->price, 2)); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="summary-totals">
                    <div class="summary-row">
                        <span>Subtotal (<?php echo e($cartItems->sum('quantity')); ?> items)</span>
                        <span>Rs. <?php echo e(number_format($subtotal, 2)); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping (<?php echo e($cartItems->count()); ?> <?php echo e(Str::plural('product', $cartItems->count())); ?> × Rs. 100)</span>
                        <span>Rs. <?php echo e(number_format($shippingFee, 2)); ?></span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rs. <?php echo e(number_format($total, 2)); ?></span>
                    </div>
                </div>

                <button class="place-order-btn" onclick="placeOrder()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Place Order
                </button>

                <p class="secure-note">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Your payment information is secure
                </p>
            </div>
        </div>
    </div>
</div>

<script>
let selectedAddressId = <?php echo e($defaultAddress ? $defaultAddress->id : ($shippingAddresses->count() > 0 ? $shippingAddresses->first()->id : 'null')); ?>;

function showAllAddresses() {
    document.getElementById('defaultAddressView').style.display = 'none';
    document.getElementById('allAddressesView').style.display = 'block';
}

function confirmAddressSelection() {
    const selectedRadio = document.querySelector('input[name="shipping_address_id_all"]:checked');
    if (selectedRadio) {
        selectedAddressId = selectedRadio.value;
        
        // Update the main radio button
        const mainRadio = document.querySelector('input[name="shipping_address_id"]');
        if (mainRadio) {
            mainRadio.value = selectedAddressId;
        }
        
        // Hide all addresses view and show default view
        document.getElementById('allAddressesView').style.display = 'none';
        document.getElementById('defaultAddressView').style.display = 'block';
        
        // Update the displayed address in default view
        const selectedCard = document.querySelector(`#allAddressesView [data-address-id="${selectedAddressId}"]`);
        if (selectedCard) {
            const addressData = {
                id: selectedAddressId,
                name: selectedCard.querySelector('strong').textContent,
                phone: selectedCard.querySelector('.address-phone').textContent,
                address: selectedCard.querySelector('.address-text').textContent,
                city: selectedCard.querySelector('.address-city').textContent,
                isDefault: selectedCard.classList.contains('default')
            };
            
            updateDefaultAddressView(addressData);
        }
        
        showNotification('Address updated', 'success');
    }
}

function updateDefaultAddressView(addressData) {
    const defaultView = document.getElementById('defaultAddressView');
    const addressCard = defaultView.querySelector('.address-card');
    
    addressCard.setAttribute('data-address-id', addressData.id);
    addressCard.querySelector('input[type="radio"]').value = addressData.id;
    addressCard.querySelector('input[type="radio"]').id = `address-${addressData.id}`;
    addressCard.querySelector('label').setAttribute('for', `address-${addressData.id}`);
    addressCard.querySelector('strong').textContent = addressData.name;
    addressCard.querySelector('.address-phone').textContent = addressData.phone;
    addressCard.querySelector('.address-text').textContent = addressData.address;
    addressCard.querySelector('.address-city').textContent = addressData.city;
    
    // Update default badge
    const defaultBadge = addressCard.querySelector('.default-badge');
    if (addressData.isDefault && !defaultBadge) {
        const badge = document.createElement('span');
        badge.className = 'default-badge';
        badge.textContent = 'Default';
        addressCard.querySelector('.address-header').appendChild(badge);
    } else if (!addressData.isDefault && defaultBadge) {
        defaultBadge.remove();
    }
}

function selectAddress(addressId) {
    // Remove selected class from all cards in all addresses view
    document.querySelectorAll('#allAddressesView .address-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    const selectedCard = document.querySelector(`#allAddressesView [data-address-id="${addressId}"]`);
    if (selectedCard) {
        selectedCard.classList.add('selected');
    }
    
    // Check the radio button
    const radio = document.getElementById(`address-all-${addressId}`);
    if (radio) {
        radio.checked = true;
    }
}

function toggleAddressForm() {
    const form = document.getElementById('addAddressForm');
    const isVisible = form.style.display !== 'none';
    form.style.display = isVisible ? 'none' : 'block';
    
    if (!isVisible) {
        // Scroll to form
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function selectPaymentMethod(method) {
    // Remove selected class from all payment options
    document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    const selectedOption = document.querySelector(`#payment-${method}`).closest('.payment-option');
    if (selectedOption && !selectedOption.classList.contains('disabled')) {
        selectedOption.classList.add('selected');
        document.getElementById(`payment-${method}`).checked = true;
    }
}

// Set initial selection on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (checkedPayment) {
        checkedPayment.closest('.payment-option').classList.add('selected');
    }
});

// Handle address form submission
document.getElementById('addressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.textContent = 'Saving...';
    
    fetch('<?php echo e(route('shipping-address.store')); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message || 'Failed to save address', 'error');
            btn.disabled = false;
            btn.textContent = 'Save Address';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to save address', 'error');
        btn.disabled = false;
        btn.textContent = 'Save Address';
    });
});

function placeOrder() {
    const shippingAddressId = document.querySelector('input[name="shipping_address_id"]:checked')?.value;
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
    
    if (!shippingAddressId) {
        showNotification('Please select a shipping address', 'error');
        return;
    }
    
    if (!paymentMethod) {
        showNotification('Please select a payment method', 'error');
        return;
    }

    // Single endpoint handles both COD and Khalti
    const btn = document.querySelector('.place-order-btn');
    btn.disabled = true;
    btn.innerHTML = paymentMethod === 'khalti'
        ? '<span>Redirecting to Khalti...</span>'
        : '<span>Processing...</span>';

    fetch('<?php echo e(route('checkout.place-order')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            shipping_address_id: shippingAddressId,
            payment_method: paymentMethod
        })
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            showNotification(data.message || 'Failed to place order', 'error');
            btn.disabled = false;
            btn.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Place Order';
            return;
        }

        if (data.redirect && data.payment_url) {
            // Khalti — redirect to Khalti's hosted payment page
            window.location.href = data.payment_url;
        } else {
            // COD — go to success page
            showNotification(data.message, 'success');
            setTimeout(() => {
                window.location.href = `/orders/${data.order_id}/success`;
            }, 1000);
        }
    })
    .catch(err => {
        console.error(err);
        showNotification('Failed to place order. Please try again.', 'error');
        btn.disabled = false;
        btn.innerHTML = '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Place Order';
    });
}

// ─── Khalti handled via server-side redirect (no JS widget needed) ───────────

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
        }
    })
    .catch(err => {
        console.error(err);
        showNotification('Verification error. Contact support with your transaction details.', 'error');
    });
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/customer/checkout/index.blade.php ENDPATH**/ ?>