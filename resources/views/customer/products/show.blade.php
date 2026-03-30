@extends('layouts.app')

@section('title', $product->name . ' - NepSole')

@section('content')
<div class="product-page">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <a href="{{ route('products.index') }}">Products</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </nav>

        <div class="product-layout">
            <!-- Left: Images Gallery -->
            <div class="product-gallery">
                @if($product->images->count() > 0)
                    <div class="main-image">
                        <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}" id="mainImage">
                    </div>
                    
                    @if($product->images->count() > 1)
                        <div class="thumbnail-gallery">
                            @foreach($product->images as $index => $image)
                                <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                     onclick="changeImage('{{ asset('storage/' . $image->image) }}', {{ $index }}, this)"
                                     data-image-index="{{ $index }}">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="Thumbnail {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="no-image-placeholder">
                        <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p>No Image Available</p>
                    </div>
                @endif
            </div>
            
            <!-- Right: Product Info -->
            <div class="product-info">
                <div class="product-header">
                    @if($product->brand)
                        <span class="brand-badge">{{ $product->brand->name }}</span>
                    @endif
                    <h1>{{ $product->name }}</h1>
                    <div class="price-section">
                        <span class="price">Rs. {{ number_format($product->price, 2) }}</span>
                        <span class="category-tag">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $product->category->name }}
                        </span>
                    </div>
                </div>

                @if($product->description)
                    <div class="info-section">
                        <p class="description-text">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Available Sizes for Selected Image -->
                @if($product->images->count() > 0)
                    <div class="sizes-section">
                        <h3>Select Size</h3>
                        <p class="size-hint">Click on an image above to see available sizes for that model</p>
                        
                        @foreach($product->images as $imageIndex => $image)
                            <div class="sizes-container" id="sizes-{{ $imageIndex }}" style="{{ $imageIndex === 0 ? '' : 'display: none;' }}">
                                @if($image->variants->count() > 0)
                                    <div class="sizes-grid">
                                        @foreach($image->variants as $variant)
                                            <button type="button" 
                                                    class="size-option {{ $variant->stock > 0 ? '' : 'out-of-stock' }}" 
                                                    onclick="selectSize({{ $variant->id }}, '{{ $variant->size }}', {{ $variant->stock }})"
                                                    {{ $variant->stock > 0 ? '' : 'disabled' }}>
                                                <span class="size-label">{{ $variant->size }}</span>
                                                <span class="stock-label">
                                                    @if($variant->stock > 0)
                                                        {{ $variant->stock }} in stock
                                                    @else
                                                        Out of stock
                                                    @endif
                                                </span>
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="no-sizes">No sizes available for this model</p>
                                @endif
                            </div>
                        @endforeach
                        
                        <!-- Selected Size Display -->
                        <div id="selectedSizeInfo" class="selected-size-info" style="display: none;">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Selected: Size <strong id="selectedSizeText"></strong> (<span id="selectedStockText"></span> available)</span>
                        </div>
                    </div>
                @endif

                <!-- Quantity and Add to Cart -->
                <div class="purchase-section">
                    <div class="quantity-selector">
                        <label>Quantity</label>
                        <div class="quantity-controls">
                            <button type="button" onclick="decreaseQuantity()" id="decreaseBtn">-</button>
                            <input type="number" id="quantityInput" value="1" min="1" max="10" readonly>
                            <button type="button" onclick="increaseQuantity()" id="increaseBtn">+</button>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="add-to-cart-btn" onclick="addToCart()">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Add to Cart
                        </button>
                        
                        <button class="wishlist-btn" onclick="addToWishlist()">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Wishlist
                        </button>
                    </div>
                </div>

                <!-- Product Details Tabs -->
                @if($product->product_details || $product->size_and_fit || $product->handle_and_care)
                    <div class="details-tabs">
                        @if($product->product_details)
                            <div class="detail-item">
                                <div class="detail-header">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h4>Product Details</h4>
                                </div>
                                <p>{{ $product->product_details }}</p>
                            </div>
                        @endif
                        
                        @if($product->size_and_fit)
                            <div class="detail-item">
                                <div class="detail-header">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                    </svg>
                                    <h4>Size & Fit</h4>
                                </div>
                                <p>{{ $product->size_and_fit }}</p>
                            </div>
                        @endif
                        
                        @if($product->handle_and_care)
                            <div class="detail-item">
                                <div class="detail-header">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <h4>Care Instructions</h4>
                                </div>
                                <p>{{ $product->handle_and_care }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="related-section">
                <h2>You May Also Like</h2>
                <div class="related-grid">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related) }}" class="related-card">
                            <div class="related-image">
                                @if($related->images->count() > 0)
                                    <img src="{{ asset('storage/' . $related->images->first()->image) }}" alt="{{ $related->name }}">
                                @else
                                    <div class="no-image">
                                        <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="related-info">
                                <h3>{{ $related->name }}</h3>
                                <p class="related-price">Rs. {{ number_format($related->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
let selectedVariantId = null;
let currentImageIndex = 0;
let maxStock = 10;

function changeImage(src, imageIndex, element) {
    // Update main image
    document.getElementById('mainImage').src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    element.classList.add('active');
    
    // Show sizes for this image
    showSizesForImage(imageIndex);
    
    currentImageIndex = imageIndex;
}

function showSizesForImage(imageIndex) {
    // Hide all size containers
    document.querySelectorAll('.sizes-container').forEach(container => {
        container.style.display = 'none';
    });
    
    // Show the selected image's sizes
    const selectedContainer = document.getElementById(`sizes-${imageIndex}`);
    if (selectedContainer) {
        selectedContainer.style.display = 'block';
    }
    
    // Clear selected size
    clearSelectedSize();
}

function selectSize(variantId, size, stock) {
    selectedVariantId = variantId;
    maxStock = stock;
    
    // Remove active class from all size options
    document.querySelectorAll('.size-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    // Add active class to clicked size
    event.target.closest('.size-option').classList.add('selected');
    
    // Show selected size info
    document.getElementById('selectedSizeText').textContent = size;
    document.getElementById('selectedStockText').textContent = stock;
    document.getElementById('selectedSizeInfo').style.display = 'flex';
    
    // Update quantity max
    document.getElementById('quantityInput').max = stock;
    if (parseInt(document.getElementById('quantityInput').value) > stock) {
        document.getElementById('quantityInput').value = stock;
    }
}

function clearSelectedSize() {
    selectedVariantId = null;
    maxStock = 10;
    document.querySelectorAll('.size-option').forEach(option => {
        option.classList.remove('selected');
    });
    document.getElementById('selectedSizeInfo').style.display = 'none';
    document.getElementById('quantityInput').value = 1;
}

function decreaseQuantity() {
    const input = document.getElementById('quantityInput');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantityInput');
    const currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);
    if (currentValue < maxValue) {
        input.value = currentValue + 1;
    }
}

function addToCart() {
    @guest
        alert('Please login to add items to cart');
        window.location.href = '{{ route('login') }}';
        return;
    @endguest
    
    if (!selectedVariantId) {
        showNotification('Please select a size first', 'error');
        return;
    }
    
    const quantity = parseInt(document.getElementById('quantityInput').value);
    const btn = event.target.closest('.add-to-cart-btn');
    btn.disabled = true;
    
    fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: {{ $product->id }},
            product_variant_id: selectedVariantId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            updateCartCount();
            btn.disabled = false;
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

function addToWishlist() {
    @guest
        alert('Please login to add items to wishlist');
        window.location.href = '{{ route('login') }}';
        return;
    @endguest
    
    const btn = event.target.closest('.wishlist-btn');
    btn.disabled = true;
    
    fetch('{{ route('wishlist.toggle') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: {{ $product->id }}
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            updateWishlistCount();
            btn.disabled = false;
        } else {
            showNotification(data.message || 'Failed to update wishlist', 'error');
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to update wishlist', 'error');
        btn.disabled = false;
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
                : type === 'error'
                ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
                : '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
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
.product-page {
    background: #f9fafb;
    min-height: 100vh;
    padding: 2rem 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
    font-size: 14px;
}

.breadcrumb a {
    color: #6b7280;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb a:hover {
    color: #10b981;
}

.breadcrumb span:last-child {
    color: #111827;
    font-weight: 500;
}

.product-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-bottom: 4rem;
}

/* Gallery Styles */
.product-gallery {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.main-image {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.main-image img {
    width: 100%;
    height: 500px;
    object-fit: cover;
}

.thumbnail-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.75rem;
}

.thumbnail {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.2s;
}

.thumbnail:hover,
.thumbnail.active {
    border-color: #10b981;
}

.thumbnail img {
    width: 100%;
    height: 100px;
    object-fit: cover;
}

.no-image-placeholder {
    background: white;
    border-radius: 16px;
    height: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #d1d5db;
}

.no-image-placeholder p {
    margin-top: 1rem;
    color: #9ca3af;
}

/* Product Info Styles */
.product-info {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.product-header {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.brand-badge {
    display: inline-block;
    background: #f3f4f6;
    color: #6b7280;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 1rem;
}

.product-header h1 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 1.5rem 0;
    line-height: 1.2;
}

.price-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.price {
    font-size: 36px;
    font-weight: 700;
    color: #10b981;
}

.category-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #f0fdf4;
    color: #065f46;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.info-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.description-text {
    font-size: 15px;
    color: #6b7280;
    line-height: 1.7;
    margin: 0;
}

/* Sizes Section */
.sizes-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.sizes-section h3 {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.5rem 0;
}

.size-hint {
    font-size: 13px;
    color: #6b7280;
    margin: 0 0 1.5rem 0;
}

.sizes-container {
    margin-bottom: 1rem;
}

.sizes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.75rem;
}

.size-option {
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 0.75rem;
    text-align: center;
    transition: all 0.2s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.size-option:hover:not(.out-of-stock) {
    border-color: #10b981;
    background: #f0fdf4;
    transform: translateY(-2px);
}

.size-option.selected {
    border-color: #10b981;
    background: #d1fae5;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.size-option.out-of-stock {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f3f4f6;
}

.size-option.out-of-stock:hover {
    border-color: #e5e7eb;
    background: #f3f4f6;
    transform: none;
}

.size-label {
    display: block;
    font-size: 16px;
    font-weight: 700;
    color: #111827;
}

.stock-label {
    display: block;
    font-size: 11px;
    color: #6b7280;
}

.no-sizes {
    text-align: center;
    color: #9ca3af;
    font-style: italic;
    padding: 2rem;
}

.selected-size-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: #d1fae5;
    color: #065f46;
    padding: 1rem 1.25rem;
    border-radius: 10px;
    margin-top: 1rem;
    font-size: 14px;
}

.selected-size-info svg {
    flex-shrink: 0;
    color: #10b981;
}

.selected-size-info strong {
    color: #047857;
}

/* Purchase Section */
.purchase-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 2rem 0;
    border-top: 1px solid #f3f4f6;
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.quantity-selector label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    min-width: 70px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-controls button {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    background: white;
    color: #374151;
    font-size: 20px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.quantity-controls button:hover {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.quantity-controls input {
    width: 70px;
    height: 44px;
    text-align: center;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
}

.action-buttons {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1rem;
}

.add-to-cart-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 14px 24px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
    transition: all 0.2s;
}

.add-to-cart-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
}

.add-to-cart-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.wishlist-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: white;
    color: #6b7280;
    padding: 14px 20px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s;
}

.wishlist-btn:hover {
    background: #fee2e2;
    color: #ef4444;
    border-color: #ef4444;
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

/* Details Tabs */
.details-tabs {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 2rem;
}

.detail-item {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
}

.detail-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.detail-header svg {
    color: #10b981;
    flex-shrink: 0;
}

.detail-header h4 {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin: 0;
}

.detail-item p {
    font-size: 14px;
    color: #4b5563;
    line-height: 1.7;
    margin: 0;
    white-space: pre-wrap;
}

/* Related Products */
.related-section {
    margin-top: 4rem;
}

.related-section h2 {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 2rem 0;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}

.related-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    text-decoration: none;
}

.related-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.related-image {
    height: 200px;
    overflow: hidden;
    background: #f9fafb;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.related-card:hover .related-image img {
    transform: scale(1.05);
}

.related-image .no-image {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #d1d5db;
}

.related-info {
    padding: 1.25rem;
}

.related-info h3 {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.5rem 0;
}

.related-price {
    font-size: 18px;
    font-weight: 700;
    color: #10b981;
    margin: 0;
}

@media (max-width: 1024px) {
    .product-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .product-gallery {
        position: static;
    }
    
    .main-image img {
        height: 400px;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    .product-header h1 {
        font-size: 24px;
    }
    
    .price {
        font-size: 28px;
    }
    
    .main-image img {
        height: 300px;
    }
    
    .sizes-grid {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .quantity-selector {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .quantity-selector label {
        min-width: auto;
    }
    
    .related-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
}
</style>
@endsection