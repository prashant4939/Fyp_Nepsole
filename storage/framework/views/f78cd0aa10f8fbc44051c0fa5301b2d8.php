<?php $__env->startSection('title', 'NepSole - Experience Nepali Footwear'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .hero {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(139, 92, 246, 0.9)), 
                    url('https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=1200') center/cover;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 4rem 2rem;
    }

    .hero-content {
        max-width: 800px;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero p {
        font-size: 1.125rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        line-height: 1.6;
    }

    .hero-btn {
        display: inline-block;
        padding: 1rem 2.5rem;
        background: #ef4444;
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.4);
    }

    .hero-btn:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
    }

    .featured-section {
        max-width: 1200px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    .section-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 3rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        width: 100%;
        height: 240px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        position: relative;
    }

    .product-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #ef4444;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .product-info {
        padding: 1.25rem;
    }

    .product-name {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #6366f1;
        margin-bottom: 1rem;
    }

    .product-btn {
        width: 100%;
        padding: 0.75rem;
        background: #6366f1;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .product-btn:hover {
        background: #4f46e5;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="hero">
    <div class="hero-content">
        <h1>Step into Tradition:<br>Experience NepSole Footwear</h1>
        <p>Discover handcrafted shoes that blend rich Nepali heritage with modern style and comfort. Every pair tells a story.</p>
        <a href="#products" class="hero-btn">Explore Our Collection</a>
    </div>
</section>

<section class="featured-section" id="products">
    <h2 class="section-title">Featured Products</h2>
    
    <div class="products-grid">
        <div class="product-card">
            <div class="product-image" style="background: linear-gradient(135deg, #1e3a2e, #2d5a45);">
                👢
            </div>
            <div class="product-info">
                <h3 class="product-name">Classic Dhakal Leather Boots</h3>
                <p class="product-price">Rs. 2,999</p>
                <a href="#" class="product-btn">View Product</a>
            </div>
        </div>

        <div class="product-card">
            <div class="product-image" style="background: linear-gradient(135deg, #e5e7eb, #d1d5db);">
                👟
            </div>
            <div class="product-info">
                <h3 class="product-name">Modern Everest Sneakers</h3>
                <p class="product-price">Rs. 3,499</p>
                <a href="#" class="product-btn">View Product</a>
            </div>
        </div>

        <div class="product-card">
            <div class="product-image" style="background: linear-gradient(135deg, #d4a574, #c89456);">
                🥿
            </div>
            <div class="product-info">
                <h3 class="product-name">Handwoven Himalayan Sandals</h3>
                <p class="product-price">Rs. 1,899</p>
                <a href="#" class="product-btn">View Product</a>
            </div>
        </div>

        <div class="product-card">
            <div class="product-image" style="background: linear-gradient(135deg, #f3f4f6, #e5e7eb);">
                👟
            </div>
            <div class="product-info">
                <h3 class="product-name">Caliber Shoes WHITE/GRN</h3>
                <p class="product-price">Rs. 2,599</p>
                <a href="#" class="product-btn">View Product</a>
            </div>
        </div>

        <div class="product-card">
            <div class="product-image" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                👟
                <span class="product-badge">NEW</span>
            </div>
            <div class="product-info">
                <h3 class="product-name">Goldstar Sneaks</h3>
                <p class="product-price">Rs. 2,299</p>
                <a href="#" class="product-btn">View Product</a>
            </div>
        </div>

        <div class="product-card">
            <div class="product-image" style="background: linear-gradient(135deg, #d4a574, #b8956a);">
                🥾
            </div>
            <div class="product-info">
                <h3 class="product-name">Durable Sherpa Hikers</h3>
                <p class="product-price">Rs. 4,199</p>
                <a href="#" class="product-btn">View Product</a>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Desktop\Fyp_Nepsole\Fyp_Nepsole\resources\views/home.blade.php ENDPATH**/ ?>