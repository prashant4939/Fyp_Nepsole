@extends('layouts.app')

@section('title', 'Products - NepSole')

@section('content')
<div class="products-page">
    <div class="container">
        <!-- Active Filters & Page Header -->
        <div class="page-header">
            <div class="header-left">
                <h1>
                    @if(isset($currentCategory) && isset($currentBrand))
                        {{ $currentCategory->name }} - {{ $currentBrand->name }}
                    @elseif(isset($currentCategory))
                        {{ $currentCategory->name }}
                    @elseif(isset($currentBrand))
                        {{ $currentBrand->name }}
                    @else
                        All Products
                    @endif
                </h1>
                <p class="results-count">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found</p>
            </div>
            
            <div class="filters">
                <form method="GET" class="filter-form">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('brand'))
                        <input type="hidden" name="brand" value="{{ request('brand') }}">
                    @endif
                    
                    <select name="sort" onchange="this.form.submit()" class="sort-select">
                        <option value="">Sort by</option>
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Active Filter Tags -->
        @if(isset($currentCategory) || isset($currentBrand) || request('search'))
            <div class="active-filters">
                <span class="filter-label">Active Filters:</span>
                <div class="filter-tags">
                    @if(isset($currentCategory))
                        <a href="{{ route('products.index', array_filter(['brand' => request('brand'), 'search' => request('search')])) }}" class="filter-tag">
                            <span>{{ $currentCategory->name }}</span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                    
                    @if(isset($currentBrand))
                        <a href="{{ route('products.index', array_filter(['category' => request('category'), 'search' => request('search')])) }}" class="filter-tag">
                            <span>{{ $currentBrand->name }}</span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                    
                    @if(request('search'))
                        <a href="{{ route('products.index', array_filter(['category' => request('category'), 'brand' => request('brand')])) }}" class="filter-tag">
                            <span>Search: "{{ request('search') }}"</span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                    
                    <a href="{{ route('products.index') }}" class="clear-all">Clear All</a>
                </div>
            </div>
        @endif

        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="no-image">
                                <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Favorite Button - Always Visible -->
                        <button class="favorite-btn" onclick="toggleFavorite(event, {{ $product->id }})" title="Add to Wishlist">
                            <svg class="heart-outline" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <svg class="heart-filled" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <a href="{{ route('products.show', $product) }}" class="product-link">
                        <div class="product-info">
                            @if($product->brand)
                                <span class="product-brand">{{ $product->brand->name }}</span>
                            @endif
                            <h3>{{ $product->name }}</h3>
                            <div class="price-row">
                                <p class="price">Rs. {{ number_format($product->price, 2) }}</p>
                                <button class="cart-btn-inline" onclick="addToCart(event, {{ $product->id }})" title="Add to Cart">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="product-meta">
                                <span class="category-badge">{{ $product->category->name }}</span>
                                @if($product->sold > 0)
                                    <span class="sold-badge">{{ $product->sold }} sold</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="empty-state">
                    <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3>No Products Found</h3>
                    <p>Try adjusting your search or filters.</p>
                    <a href="{{ route('products.index') }}" class="btn-primary">View All Products</a>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleFavorite(event, productId) {
    event.preventDefault();
    event.stopPropagation();
    
    @guest
        alert('Please login to add items to wishlist');
        window.location.href = '{{ route('login') }}';
        return;
    @endguest
    
    const btn = event.currentTarget;
    
    fetch('{{ route('wishlist.toggle') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.inWishlist) {
                btn.classList.add('favorited');
            } else {
                btn.classList.remove('favorited');
            }
            showNotification(data.message, 'success');
            updateWishlistCount();
        } else {
            showNotification(data.message || 'Failed to update wishlist', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to update wishlist', 'error');
    });
}

function addToCart(event, productId) {
    event.preventDefault();
    event.stopPropagation();
    
    @guest
        alert('Please login to add items to cart');
        window.location.href = '{{ route('login') }}';
        return;
    @endguest
    
    const btn = event.currentTarget;
    btn.disabled = true;
    
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
            btn.classList.add('added');
            showNotification(data.message, 'success');
            
            // Update cart count in navbar
            updateCartCount();
            
            setTimeout(() => {
                btn.classList.remove('added');
                btn.disabled = false;
            }, 2000);
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to add to cart', 'error');
        btn.disabled = false;
    });
}

function showNotification(message, type = 'success') {
    // Remove existing notifications
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

</script>

<style>
.products-page {
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
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-left h1 {
    color: #111827;
    margin: 0 0 0.5rem 0;
    font-size: 32px;
    font-weight: 700;
}

.results-count {
    color: #6b7280;
    font-size: 14px;
    margin: 0;
}

.sort-select {
    padding: 10px 16px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    background: white;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: border-color 0.2s;
}

.sort-select:focus {
    outline: none;
    border-color: #10b981;
}

/* Active Filters */
.active-filters {
    background: white;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.filter-label {
    font-size: 14px;
    font-weight: 600;
    color: #6b7280;
}

.filter-tags {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #f0fdf4;
    color: #065f46;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.filter-tag:hover {
    background: #dcfce7;
}

.filter-tag svg {
    flex-shrink: 0;
}

.clear-all {
    color: #ef4444;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 20px;
    transition: background 0.2s;
}

.clear-all:hover {
    background: #fee2e2;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
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

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.no-image {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #d1d5db;
}

/* Favorite Button - Always Visible */
.favorite-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 40px;
    height: 40px;
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

.favorite-btn:hover {
    transform: scale(1.1);
    background: #fee2e2;
    color: #ef4444;
}

.favorite-btn:active {
    transform: scale(0.95);
}

.favorite-btn .heart-filled {
    display: none;
}

.favorite-btn.favorited {
    background: #fee2e2;
    color: #ef4444;
}

.favorite-btn.favorited .heart-outline {
    display: none;
}

.favorite-btn.favorited .heart-filled {
    display: block;
    animation: heartBeat 0.3s ease;
}

@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* Product Link */
.product-link {
    text-decoration: none;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-info {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-brand {
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.product-info h3 {
    margin: 0 0 0.75rem 0;
    color: #111827;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
}

.price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.price {
    font-size: 20px;
    font-weight: 700;
    color: #10b981;
    margin: 0;
}

/* Inline Cart Button */
.cart-btn-inline {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #10b981;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: white;
    flex-shrink: 0;
}

.cart-btn-inline:hover {
    background: #059669;
    transform: scale(1.1);
}

.cart-btn-inline:active {
    transform: scale(0.95);
}

.cart-btn-inline.added {
    animation: cartBounce 0.5s ease;
}

@keyframes cartBounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

.product-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: auto;
}

.category-badge {
    font-size: 11px;
    font-weight: 600;
    color: #6366f1;
    background: #e0e7ff;
    padding: 4px 8px;
    border-radius: 12px;
}

.sold-badge {
    font-size: 11px;
    font-weight: 600;
    color: #059669;
    background: #d1fae5;
    padding: 4px 8px;
    border-radius: 12px;
}

/* Notification */
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

.notification-info {
    border-left: 4px solid #3b82f6;
}

.notification-info svg {
    color: #3b82f6;
}

.notification span {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.empty-state svg {
    color: #d1d5db;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    font-size: 16px;
    color: #6b7280;
    margin: 0 0 2rem 0;
}

.btn-primary {
    display: inline-block;
    background: #10b981;
    color: white;
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #059669;
    transform: translateY(-2px);
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    .header-left h1 {
        font-size: 24px;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .product-image {
        height: 180px;
    }
    
    .favorite-btn {
        width: 36px;
        height: 36px;
    }
    
    .favorite-btn svg {
        width: 18px;
        height: 18px;
    }
    
    .product-info {
        padding: 1rem;
    }
    
    .product-info h3 {
        font-size: 14px;
    }
    
    .price {
        font-size: 18px;
    }
    
    .cart-btn-inline {
        width: 36px;
        height: 36px;
    }
    
    .cart-btn-inline svg {
        width: 18px;
        height: 18px;
    }
    
    .notification {
        right: 10px;
        left: 10px;
        top: 10px;
    }
}
</style>
@endsection