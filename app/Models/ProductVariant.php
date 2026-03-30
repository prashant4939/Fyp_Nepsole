<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_image_id',
        'size',
        'stock',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'stock' => 'integer',
    ];

    /**
     * Get the product image that owns the variant.
     */
    public function productImage()
    {
        return $this->belongsTo(ProductImage::class);
    }

    /**
     * Check if variant is in stock.
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * Check if variant is low in stock.
     */
    public function isLowStock($threshold = 5)
    {
        return $this->stock <= $threshold && $this->stock > 0;
    }
}
