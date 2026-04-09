<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'shop_name',
        'address',
        'citizenship_photo',
        'tax_clearance',
        'business_document',
        'status',
        'admin_message',
    ];
}
