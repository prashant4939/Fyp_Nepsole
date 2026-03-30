@extends('layouts.dashboard')

@section('title', 'My Products - Vendor')
@section('panel-name', 'Vendor Panel')
@section('page-title', 'My Products')
@section('navbar-color', '#10b981')

@section('sidebar-nav')
@include('vendor.partials.sidebar')
@endsection

@section('content')
<div class="products-header">
    <div class="header-content">
        <div>
            <h1 class="page-title">My Products</h1>
            <p class="page-subtitle">Manage your product inventory</p>
        </div>
        <a href="{{ route('vendor.products.create') }}" class="btn-add-product">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Product
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<div class="products-container">
    @forelse($products as $product)
        <div class="product-card">
            <div class="product-image-wrapper">
                @if($product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="{{ $product->name }}" class="product-image">
                    @if($product->images->count() > 1)
                        <span class="image-count">+{{ $product->images->count() - 1 }}</span>
                    @endif
                @else
                    <div class="no-image">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>No Image</span>
                    </div>
                @endif
            </div>
            
            <div class="product-details">
                <div class="product-header">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <span class="product-status {{ $product->is_active ? 'active' : 'inactive' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <p class="product-price">Rs. {{ number_format($product->price, 2) }}</p>
                
                <div class="product-meta">
                    <span class="meta-item">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        {{ $product->category->name }}
                    </span>
                    @if($product->brand)
                        <span class="meta-item">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            {{ $product->brand->name }}
                        </span>
                    @endif
                </div>
                
                <div class="product-stats">
                    <div class="stat">
                        <span class="stat-value">{{ $product->images->count() }}</span>
                        <span class="stat-label">Images</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">{{ $product->images->sum(function($img) { return $img->variants->sum('stock'); }) }}</span>
                        <span class="stat-label">Stock</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">{{ $product->sold }}</span>
                        <span class="stat-label">Sold</span>
                    </div>
                </div>
            </div>
            
            <div class="product-actions">
                <a href="{{ route('vendor.products.show', $product) }}" class="btn-action btn-view">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View
                </a>
                <a href="{{ route('vendor.products.edit', $product) }}" class="btn-action btn-edit">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('vendor.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3>No Products Yet</h3>
            <p>Start building your inventory by adding your first product.</p>
            <a href="{{ route('vendor.products.create') }}" class="btn-add-product">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Your First Product
            </a>
        </div>
    @endforelse
</div>

@if($products->hasPages())
    <div class="pagination-wrapper">
        {{ $products->links() }}
    </div>
@endif

<style>
.products-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.25rem 0;
}

.page-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.btn-add-product {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
    transition: all 0.2s;
}

.btn-add-product:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
}

.alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.products-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    border: 1px solid #f3f4f6;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.product-image-wrapper {
    position: relative;
    width: 100%;
    height: 240px;
    background: #f9fafb;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-count {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #9ca3af;
    gap: 0.5rem;
}

.no-image span {
    font-size: 14px;
    font-weight: 500;
}

.product-details {
    padding: 1.25rem;
}

.product-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.product-name {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin: 0;
    line-height: 1.4;
    flex: 1;
}

.product-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-status.active {
    background: #d1fae5;
    color: #065f46;
}

.product-status.inactive {
    background: #fee2e2;
    color: #991b1b;
}

.product-price {
    font-size: 24px;
    font-weight: 700;
    color: #10b981;
    margin: 0 0 1rem 0;
}

.product-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 13px;
    color: #6b7280;
    background: #f9fafb;
    padding: 4px 10px;
    border-radius: 6px;
}

.product-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
}

.stat {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

.stat-label {
    display: block;
    font-size: 12px;
    color: #6b7280;
    margin-top: 2px;
}

.product-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    border-top: 1px solid #f3f4f6;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 12px;
    border: none;
    background: white;
    color: #6b7280;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    border-right: 1px solid #f3f4f6;
}

.btn-action:last-child {
    border-right: none;
}

.btn-action:hover {
    background: #f9fafb;
}

.btn-view:hover {
    color: #3b82f6;
}

.btn-edit:hover {
    color: #10b981;
}

.btn-delete:hover {
    color: #ef4444;
    background: #fef2f2;
}

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
    font-size: 20px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0 0 2rem 0;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .products-container {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-add-product {
        justify-content: center;
    }
}
</style>
@endsection
