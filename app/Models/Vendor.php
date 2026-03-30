<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * Business types available for vendors
     */
    const BUSINESS_TYPES = [
        'sole_proprietorship' => 'Sole Proprietorship',
        'partnership' => 'Partnership',
        'private_limited' => 'Private Limited',
        'llp' => 'LLP',
        'other' => 'Other',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'business_name',
        'citizenship_certificate',
        'pan_number',
        'company_registration_certificate',
        'tax_certificate',
        'business_type',
        'is_verified',
        'is_active',
        'deactivation_note',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the vendor profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the vendor.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get active products for the vendor.
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    /**
     * Get order items for the vendor.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the business type label.
     */
    public function getBusinessTypeLabel()
    {
        return self::BUSINESS_TYPES[$this->business_type] ?? 'Unknown';
    }

    /**
     * Check if vendor is verified and active.
     */
    public function isApproved()
    {
        return $this->is_verified && $this->is_active;
    }

    /**
     * Scope to get only verified vendors.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope to get only active vendors.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}