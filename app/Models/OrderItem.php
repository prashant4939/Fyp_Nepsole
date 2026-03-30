<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'size',
        'quantity',
        'unit_price',
        'total_price',
        'vendor_id',
        'status',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Boot method to calculate total_price automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            if (is_null($orderItem->total_price)) {
                $orderItem->total_price = $orderItem->quantity * $orderItem->unit_price;
            }
        });
    }

    /**
     * Get the order that owns the order item
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for the order item
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the vendor for the order item
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the product variant for the order item
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get subtotal (alias for total_price)
     */
    public function getSubtotalAttribute()
    {
        return $this->total_price ?? ($this->quantity * $this->unit_price);
    }

    /**
     * Check if item is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if item is confirmed
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if item is cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }
}
