

<?php $__env->startSection('title', 'View Product - Vendor'); ?>
<?php $__env->startSection('panel-name', 'Vendor Panel'); ?>
<?php $__env->startSection('page-title', 'Product Details'); ?>
<?php $__env->startSection('navbar-color', '#10b981'); ?>

<?php $__env->startSection('sidebar-nav'); ?>
<?php echo $__env->make('vendor.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header-modern">
    <div class="header-content">
        <div>
            <h1 class="page-title"><?php echo e($product->name); ?></h1>
            <p class="page-subtitle">Product details and inventory overview</p>
        </div>
        <div class="header-actions">
            <a href="<?php echo e(route('vendor.products.edit', $product)); ?>" class="btn-edit">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="<?php echo e(route('vendor.products.index')); ?>" class="btn-back">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>
</div>

<div class="view-layout">
    <div class="view-main">
        <div class="info-card">
            <div class="card-header">
                <h2>Product Information</h2>
            </div>
            
            <div class="card-body">
                <div class="info-row-2">
                    <div class="info-item">
                        <label>Name</label>
                        <span><?php echo e($product->name); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <label>Price</label>
                        <span class="price">Rs. <?php echo e(number_format($product->price, 2)); ?></span>
                    </div>
                </div>
                
                <div class="info-row-2">
                    <div class="info-item">
                        <label>Category</label>
                        <span><?php echo e($product->category->name); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <label>Brand</label>
                        <span><?php echo e($product->brand ? $product->brand->name : 'N/A'); ?></span>
                    </div>
                </div>
                
                <div class="info-row-2">
                    <div class="info-item">
                        <label>Status</label>
                        <span class="badge <?php echo e($product->is_active ? 'badge-active' : 'badge-inactive'); ?>">
                            <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                    
                    <div class="info-item">
                        <label>Units Sold</label>
                        <span class="sold-count"><?php echo e($product->sold); ?></span>
                    </div>
                </div>
                
                <?php if($product->description): ?>
                    <div class="text-section">
                        <label>Description</label>
                        <p><?php echo e($product->description); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($product->product_details || $product->size_and_fit || $product->handle_and_care): ?>
            <div class="info-card">
                <div class="card-header">
                    <h2>Additional Details</h2>
                </div>
                
                <div class="card-body">
                    <?php if($product->product_details): ?>
                        <div class="text-section">
                            <label>Product Details</label>
                            <p><?php echo e($product->product_details); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="info-row-2">
                        <?php if($product->size_and_fit): ?>
                            <div class="text-section">
                                <label>Size & Fit</label>
                                <p><?php echo e($product->size_and_fit); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($product->handle_and_care): ?>
                            <div class="text-section">
                                <label>Care Instructions</label>
                                <p><?php echo e($product->handle_and_care); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="view-sidebar">
        <div class="stats-card">
            <div class="stat-item">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div>
                    <div class="stat-value"><?php echo e($product->images->count()); ?></div>
                    <div class="stat-label">Images</div>
                </div>
            </div>
            <div class="stat-item">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <div>
                    <div class="stat-value"><?php echo e($product->images->sum(function($img) { return $img->variants->sum('stock'); })); ?></div>
                    <div class="stat-label">Total Stock</div>
                </div>
            </div>
        </div>

        <?php if($product->images->count() > 0): ?>
            <div class="images-card">
                <div class="card-header">
                    <h2>Images & Sizes</h2>
                </div>
                
                <div class="card-body">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="image-preview">
                            <img src="<?php echo e(asset('storage/' . $image->image)); ?>" alt="Product Image">
                            
                            <?php if($image->variants->count() > 0): ?>
                                <div class="sizes-preview">
                                    <?php $__currentLoopData = $image->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="size-badge">
                                            <span class="size"><?php echo e($variant->size); ?></span>
                                            <span class="stock"><?php echo e($variant->stock); ?> units</span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="no-sizes">No sizes available</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-card">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h4>No Images</h4>
                <p>Add images to this product</p>
                <a href="<?php echo e(route('vendor.products.edit', $product)); ?>" class="btn-add">Add Images</a>
            </div>
        <?php endif; ?>
    </div>
</div>
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

.header-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
    transition: all 0.2s;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
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

.view-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 1.5rem;
}

.info-card,
.images-card,
.stats-card,
.empty-card {
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
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.info-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.info-row-2:last-child {
    margin-bottom: 0;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item span {
    font-size: 15px;
    color: #111827;
    font-weight: 500;
}

.price {
    color: #10b981;
    font-weight: 700;
    font-size: 18px;
}

.sold-count {
    color: #3b82f6;
    font-weight: 700;
}

.badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    width: fit-content;
}

.badge-active {
    background: #d1fae5;
    color: #065f46;
}

.badge-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.text-section {
    padding-top: 1.5rem;
    border-top: 1px solid #f3f4f6;
}

.info-row-2:first-child + .text-section,
.card-body > .text-section:first-child {
    padding-top: 0;
    border-top: none;
}

.text-section label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
}

.text-section p {
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
    margin: 0;
}

.stats-card {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.stat-item svg {
    color: white;
    flex-shrink: 0;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: white;
    line-height: 1;
}

.stat-label {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

.image-preview {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.image-preview:last-child {
    margin-bottom: 0;
}

.image-preview img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.sizes-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.size-badge {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.size-badge .size {
    font-weight: 700;
    color: #111827;
    font-size: 14px;
}

.size-badge .stock {
    font-size: 11px;
    color: #6b7280;
}

.no-sizes {
    color: #9ca3af;
    font-style: italic;
    font-size: 13px;
    margin: 0;
    text-align: center;
}

.empty-card {
    padding: 3rem 2rem;
    text-align: center;
}

.empty-card svg {
    color: #d1d5db;
    margin: 0 auto 1rem;
}

.empty-card h4 {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.empty-card p {
    font-size: 14px;
    color: #6b7280;
    margin: 0 0 1.5rem 0;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    color: #10b981;
    padding: 10px 20px;
    border-radius: 10px;
    border: 2px dashed #10b981;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-add:hover {
    background: #f0fdf4;
}

@media (max-width: 1024px) {
    .view-layout {
        grid-template-columns: 1fr;
    }
    
    .info-row-2 {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-actions {
        justify-content: stretch;
    }
    
    .btn-edit,
    .btn-back {
        flex: 1;
        justify-content: center;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/vendor/products/show.blade.php ENDPATH**/ ?>