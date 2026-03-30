@extends('layouts.dashboard')

@section('title', 'Add Product - Vendor')
@section('panel-name', 'Vendor Panel')
@section('page-title', 'Add New Product')
@section('navbar-color', '#10b981')

@section('sidebar-nav')
@include('vendor.partials.sidebar')
@endsection

@section('content')
<div class="page-header-modern">
    <div class="header-content">
        <div>
            <h1 class="page-title">Add New Product</h1>
            <p class="page-subtitle">Create a new product listing for your store</p>
        </div>
        <a href="{{ route('vendor.products.index') }}" class="btn-back">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Products
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-error">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="form-card">
        <div class="card-header">
            <h2>Basic Information</h2>
            <p>Essential details about your product</p>
        </div>
        
        <div class="card-body">
            <div class="form-row-2">
                <div class="form-group">
                    <label for="name" class="required">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label for="price" class="required">Price (Rs.)</label>
                    <div class="input-with-icon">
                        <span class="input-icon">Rs.</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" step="0.01" min="0" required>
                    </div>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="category_id" class="required">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    <select id="brand_id" name="brand_id">
                        <option value="">Select brand (optional)</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Brief product description...">{{ old('description') }}</textarea>
            </div>

            <div class="form-row-3">
                <div class="form-group">
                    <label for="product_details">Details</label>
                    <textarea id="product_details" name="product_details" rows="3" placeholder="Product specifications...">{{ old('product_details') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="size_and_fit">Size & Fit</label>
                    <textarea id="size_and_fit" name="size_and_fit" rows="3" placeholder="Sizing information...">{{ old('size_and_fit') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="handle_and_care">Care</label>
                    <textarea id="handle_and_care" name="handle_and_care" rows="3" placeholder="Care instructions...">{{ old('handle_and_care') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-card">
        <div class="card-header">
            <h2>Product Images & Sizes</h2>
            <p>Upload images and specify available sizes with stock quantities</p>
        </div>
        
        <div class="card-body">
            <div id="imagesContainer">
                <!-- Images will be added here -->
            </div>

            <button type="button" class="btn-add-image" onclick="addImage()">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Image
            </button>
        </div>
    </div>

    <div class="form-actions-sticky">
        <button type="submit" class="btn-submit">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Create Product
        </button>
        <a href="{{ route('vendor.products.index') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
<style>
.page-header-modern {
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

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    color: #6b7280;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
}

.btn-back:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}

.alert {
    display: flex;
    align-items: start;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 14px;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.alert ul {
    margin: 0.5rem 0 0 0;
    padding-left: 1.25rem;
}

.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    border: 1px solid #f3f4f6;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
}

.card-header h2 {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 0.25rem 0;
}

.card-header p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.form-group label.required::after {
    content: " *";
    color: #ef4444;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
    background: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-group textarea {
    resize: vertical;
    font-family: inherit;
}

.input-with-icon {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-weight: 600;
    font-size: 14px;
}

.input-with-icon input {
    padding-left: 48px;
}

.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-row-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.image-entry {
    background: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.2s;
}

.image-entry:hover {
    border-color: #10b981;
    background: #f0fdf4;
}

.image-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.image-header h4 {
    margin: 0;
    color: #111827;
    font-size: 16px;
    font-weight: 600;
}

.sizes-section {
    margin-top: 1rem;
}

.sizes-section > label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 14px;
}

.sizes-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.size-entry {
    display: flex;
    gap: 0.5rem;
    align-items: end;
}

.size-entry > div {
    flex: 1;
}

.size-entry label {
    display: block;
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 0.375rem;
    font-weight: 500;
}

.size-entry input {
    width: 100%;
    padding: 8px 10px;
    font-size: 13px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
}

.btn-add-image {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    color: #10b981;
    padding: 12px 24px;
    border-radius: 10px;
    border: 2px dashed #10b981;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-add-image:hover {
    background: #f0fdf4;
}

.btn-remove {
    background: #fee2e2;
    color: #ef4444;
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-remove:hover {
    background: #fca5a5;
    color: white;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.form-actions-sticky {
    position: sticky;
    bottom: 0;
    background: white;
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 1rem;
    box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
    border-radius: 16px 16px 0 0;
    margin-top: 2rem;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 14px 32px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
    transition: all 0.2s;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    padding: 14px 32px;
    background: white;
    color: #6b7280;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #f9fafb;
    border-color: #9ca3af;
}

@media (max-width: 768px) {
    .form-row-2,
    .form-row-3 {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-back {
        justify-content: center;
    }
    
    .form-actions-sticky {
        flex-direction: column;
    }
}
</style>
<script>
let imageIndex = 0;

function addImage() {
    const container = document.getElementById('imagesContainer');
    const index = imageIndex++;
    
    const html = `
        <div class="image-entry" id="image-${index}">
            <div class="image-header">
                <h4>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Image ${index + 1}
                </h4>
                <button type="button" class="btn-remove" onclick="removeImage(${index})">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Remove
                </button>
            </div>
            
            <div class="form-group">
                <label class="required">Upload Image</label>
                <input type="file" name="images[${index}][file]" accept="image/*" required style="padding: 10px;">
            </div>
            
            <div class="sizes-section">
                <label>Sizes & Stock</label>
                <div class="sizes-container" id="sizes-${index}">
                    <!-- Sizes will be added here -->
                </div>
                <button type="button" class="btn-add-image btn-sm" onclick="addSize(${index})" style="margin-top: 0.5rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Size
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
    addSize(index); // Add first size automatically
}

function removeImage(imageIndex) {
    document.getElementById(`image-${imageIndex}`).remove();
}

let sizeCounters = {};

function addSize(imageIndex) {
    if (!sizeCounters[imageIndex]) {
        sizeCounters[imageIndex] = 0;
    }
    
    const sizeIndex = sizeCounters[imageIndex]++;
    const container = document.getElementById(`sizes-${imageIndex}`);
    
    const html = `
        <div class="size-entry" id="size-${imageIndex}-${sizeIndex}">
            <div>
                <label>Size</label>
                <input type="text" name="images[${imageIndex}][sizes][${sizeIndex}][size]" placeholder="e.g. 8, 9, 10" required>
            </div>
            <div>
                <label>Stock</label>
                <input type="number" name="images[${imageIndex}][sizes][${sizeIndex}][stock]" placeholder="10" min="1" required>
            </div>
            <button type="button" class="btn-remove btn-sm" onclick="removeSize(${imageIndex}, ${sizeIndex})" style="align-self: end;">×</button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
}

function removeSize(imageIndex, sizeIndex) {
    document.getElementById(`size-${imageIndex}-${sizeIndex}`).remove();
}

// Add first image on page load
document.addEventListener('DOMContentLoaded', function() {
    addImage();
});
</script>
@endsection