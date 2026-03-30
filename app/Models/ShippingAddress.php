<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'city',
        'landmark',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the shipping address
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get orders using this shipping address
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Set this address as default and unset others
     */
    public function setAsDefault()
    {
        // Unset all other default addresses for this user
        self::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);
        
        // Set this as default
        $this->update(['is_default' => true]);
    }
}
