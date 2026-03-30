<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'image',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variants for this image.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrl()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Get total stock for this image across all sizes.
     */
    public function getTotalStock()
    {
        return $this->variants()->sum('stock');
    }

    /**
     * Check if any size is in stock.
     */
    public function hasStock()
    {
        return $this->variants()->where('stock', '>', 0)->exists();
    }
}