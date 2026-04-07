<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_status',
        'total_price',
        'payment_method',
        'shipping_address_id',
        'transaction_id',
        'payment_status',
        'paid_amount',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shipping address for the order
     */
    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    /**
     * Get the order items for the order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the total number of items in the order
     */
    public function getTotalItemsAttribute()
    {
        return $this->orderItems->sum('quantity');
    }

    /**
     * Check if order is pending
     */
    public function isPending()
    {
        return $this->order_status === 'pending';
    }

    /**
     * Check if order is processing
     */
    public function isProcessing()
    {
        return $this->order_status === 'processing';
    }

    /**
     * Check if order is cancelled
     */
    public function isCancelled()
    {
        return $this->order_status === 'cancelled';
    }

    /**
     * Check if order is confirmed
     */
    public function isConfirmed()
    {
        return $this->order_status === 'confirmed';
    }

    /**
     * Check if order is dispatched
     */
    public function isDispatched()
    {
        return $this->order_status === 'dispatched';
    }

    /**
     * Check if all order items are confirmed by vendors
     */
    public function allItemsConfirmed()
    {
        return $this->orderItems()->where('status', '!=', 'confirmed')->count() === 0;
    }

    /**
     * Check if any order item is cancelled
     */
    public function hasCancelledItems()
    {
        return $this->orderItems()->where('status', 'cancelled')->exists();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->order_status) {
            'pending' => 'warning',
            'processing' => 'info',
            'confirmed' => 'success',
            'dispatched' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get payment method label
     */
    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'khalti' => 'Khalti',
            'cod' => 'Cash on Delivery',
            default => $this->payment_method
        };
    }
}
