<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'landmark' => 'nullable|string|max:100',
            'is_default' => 'boolean'
        ]);

        $address = ShippingAddress::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'landmark' => $request->landmark,
            'is_default' => $request->is_default ?? false
        ]);

        // If this is set as default, unset others
        if ($address->is_default) {
            $address->setAsDefault();
        }

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully',
            'address' => $address
        ]);
    }

    public function setDefault(ShippingAddress $address)
    {
        // Verify ownership
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $address->setAsDefault();

        return response()->json([
            'success' => true,
            'message' => 'Default address updated'
        ]);
    }
}
