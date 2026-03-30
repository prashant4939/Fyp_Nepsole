<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'price',
        'category_id',
        'product_details',
        'size_and_fit',
        'handle_and_care',
        'brand_id',
        'is_active',
        'sold',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the vendor that owns the product.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the first image for the product.
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->oldest();
    }

    /**
     * Scope to get only active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->whereHas('images.variants', function($q) {
            $q->where('stock', '>', 0);
        });
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock()
    {
        return $this->images()->whereHas('variants', function($q) {
            $q->where('stock', '>', 0);
        })->exists();
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPrice()
    {
        return 'Rs. ' . number_format($this->price, 2);
    }

    /**
     * Get total stock across all variants.
     */
    public function getTotalStock()
    {
        return ProductVariant::whereHas('productImage', function($q) {
            $q->where('product_id', $this->id);
        })->sum('stock');
    }

    /**
     * Get all available sizes for this product.
     */
    public function getAvailableSizes()
    {
        return ProductVariant::whereHas('productImage', function($q) {
            $q->where('product_id', $this->id);
        })
        ->where('stock', '>', 0)
        ->distinct()
        ->pluck('size')
        ->sort()
        ->values();
    }

    /**
     * Check if product is low in stock.
     */
    public function isLowStock($threshold = 10)
    {
        $totalStock = $this->getTotalStock();
        return $totalStock <= $threshold && $totalStock > 0;
    }

    /**
     * Get stock status.
     */
    public function getStockStatus()
    {
        $totalStock = $this->getTotalStock();
        if ($totalStock == 0) {
            return 'Out of Stock';
        } elseif ($this->isLowStock()) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }
}