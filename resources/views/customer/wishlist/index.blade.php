@extends('layouts.app')

@section('title', 'My Wishlist - NepSole')

@section('content')
<div class="wishlist-page">
    <div class="container">
        <div class="page-header">
            <h1>My Wishlist</h1>
            <a href="{{ route('products.index') }}" class="continue-shopping">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Continue Shopping
            </a>
        </div>

        @if($wishlistItems->count() > 0)
            <div class="wishlist-grid">
                @foreach($wishlistItems as $item)
                    <div class="wishlist-card" data-wishlist-id="{{ $item->id }}">
                        <button class="remove-btn" onclick="removeItem({{ $item->id }})" title="Remove from wishlist">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        
                        <a href="{{ route('products.show', $item->product) }}" class="product-link">
                            <div class="product-image">
                                @if($item->product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image) }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="no-image">
                                        <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="product-info">
                                @if($item->product->brand)
                                    <span class="product-brand">{{ $item->product->brand->name }}</span>
                                @endif
                                <h3>{{ $item->product->name }}</h3>
                                <p class="product-category">{{ $item->product->category->name }}</p>
                                <p class="product-price">Rs. {{ number_format($item->product->price, 2) }}</p>
                            </div>
                        </a>
                        
                        <button class="add-to-cart-btn" onclick="moveToCart(event, {{ $item->product->id }}, {{ $item->id }})">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Move to Cart
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-wishlist">
                <svg width="120" height="120" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h2>Your wishlist is empty</h2>
                <p>Save your favorite products here!</p>
                <a href="{{ route('products.index') }}" class="shop-now-btn">Shop Now</a>
            </div>
        @endif
    </div>
</div>

<script>
function removeItem(wishlistId) {
    if (!confirm('Remove this item from wishlist?')) return;
    
    fetch(`/wishlist/${wishlistId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from DOM
            const wishlistCard = document.querySelector(`[data-wishlist-id="${wishlistId}"]`);
            wishlistCard.remove();
            
            // Update wishlist count in navbar (if exists)
            updateWishlistCount();
            
            // Check if wishlist is empty
            if (document.querySelectorAll('.wishlist-card').length === 0) {
                location.reload();
            }
            
            showNotification(data.message, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to remove item', 'error');
    });
}

function moveToCart(event, productId, wishlistId) {
    event.preventDefault();
    event.stopPropagation();
    
    const btn = event.currentTarget;
    btn.disabled = true;
    
    // Add to cart
    fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove from wishlist
            return fetch(`/wishlist/${wishlistId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        } else {
            throw new Error(data.message || 'Failed to add to cart');
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from DOM
            const wishlistCard = document.querySelector(`[data-wishlist-id="${wishlistId}"]`);
            wishlistCard.remove();
            
            // Update counts
            updateWishlistCount();
            updateCartCount();
            
            // Check if wishlist is empty
            if (document.querySelectorAll('.wishlist-card').length === 0) {
                location.reload();
            }
            
            showNotification('Product moved to cart', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Failed to move to cart', 'error');
        btn.disabled = false;
    });
}

function updateWishlistCount() {
    fetch('{{ route('wishlist.count') }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('wishlistBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error updating wishlist count:', error));
}

function updateCartCount() {
    fetch('{{ route('cart.count') }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
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
.wishlist-page {
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

.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.wishlist-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    position: relative;
    display: flex;
    flex-direction: column;
}

.wishlist-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.remove-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    transition: all 0.2s;
    color: #6b7280;
    z-index: 10;
}

.remove-btn:hover {
    background: #fee2e2;
    color: #ef4444;
    transform: scale(1.1);
}

.product-link {
    text-decoration: none;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-image {
    height: 250px;
    overflow: hidden;
    background: #f9fafb;
    position: relative;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.wishlist-card:hover .product-image img {
    transform: scale(1.05);
}

.no-image {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #d1d5db;
}

.product-info {
    padding: 1.25rem;
    flex: 1;
}

.product-brand {
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
    display: block;
}

.product-info h3 {
    margin: 0 0 0.5rem 0;
    color: #111827;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
}

.product-category {
    font-size: 13px;
    color: #6b7280;
    margin: 0 0 0.75rem 0;
}

.product-price {
    font-size: 20px;
    font-weight: 700;
    color: #10b981;
    margin: 0;
}

.add-to-cart-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: #10b981;
    color: white;
    padding: 12px 20px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    border-radius: 0;
}

.add-to-cart-btn:hover:not(:disabled) {
    background: #059669;
}

.add-to-cart-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.empty-wishlist {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.empty-wishlist svg {
    color: #d1d5db;
    margin-bottom: 2rem;
}

.empty-wishlist h2 {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.5rem 0;
}

.empty-wishlist p {
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

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .page-header h1 {
        font-size: 24px;
    }
    
    .wishlist-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .product-image {
        height: 180px;
    }
    
    .product-info {
        padding: 1rem;
    }
    
    .product-info h3 {
        font-size: 14px;
    }
    
    .product-price {
        font-size: 18px;
    }
}
</style>
@endsection
