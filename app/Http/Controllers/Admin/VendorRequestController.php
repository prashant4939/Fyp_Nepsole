<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VendorRequestApproved;
use App\Mail\VendorRequestRejected;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class VendorRequestController extends Controller
{
    public function index()
    {
        $requests = VendorRequest::latest()->paginate(20);
        return view('admin.vendor-requests.index', compact('requests'));
    }

    public function show(VendorRequest $vendorRequest)
    {
        return view('admin.vendor-requests.show', compact('vendorRequest'));
    }

    public function approve(VendorRequest $vendorRequest)
    {
        if ($vendorRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $pin = null;
        $existingUser = User::where('email', $vendorRequest->email)->first();

        if ($existingUser) {
            // User already exists — just upgrade their role and ensure vendor profile exists
            $existingUser->update(['role' => 'vendor']);
            $user = $existingUser;

            if (!$user->vendor) {
                Vendor::create([
                    'user_id'       => $user->id,
                    'business_name' => $vendorRequest->shop_name,
                    'pan_number'    => 'PENDING-' . $user->id,
                    'business_type' => 'other',
                    'is_verified'   => true,
                    'is_active'     => true,
                ]);
            } else {
                $user->vendor->update(['is_verified' => true, 'is_active' => true]);
            }
        } else {
            // New user — generate PIN and create account
            $pin = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            $user = User::create([
                'name'     => $vendorRequest->name,
                'email'    => $vendorRequest->email,
                'phone'    => $vendorRequest->phone,
                'address'  => $vendorRequest->address,
                'password' => Hash::make($pin),
                'role'     => 'vendor',
            ]);

            Vendor::create([
                'user_id'       => $user->id,
                'business_name' => $vendorRequest->shop_name,
                'pan_number'    => 'PENDING-' . $user->id,
                'business_type' => 'other',
                'is_verified'   => true,
                'is_active'     => true,
            ]);
        }

        $vendorRequest->update(['status' => 'approved']);

        // Send approval email — pass pin (null if existing user, they already have a password)
        try {
            Mail::to($user->email)->send(new VendorRequestApproved($user->name, $vendorRequest->shop_name, $pin));
        } catch (\Exception $e) {
            \Log::error('Vendor approval email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.vendors.index')
            ->with('success', "Vendor approved. Login credentials sent to {$user->email}.");
    }

    public function reject(Request $request, VendorRequest $vendorRequest)
    {
        $request->validate([
            'admin_message' => 'required|string|max:1000',
        ]);

        if ($vendorRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $vendorRequest->update([
            'status'        => 'rejected',
            'admin_message' => $request->admin_message,
        ]);

        // Send rejection email
        try {
            Mail::to($vendorRequest->email)->send(
                new VendorRequestRejected($vendorRequest->name, $vendorRequest->shop_name, $request->admin_message)
            );
        } catch (\Exception $e) {
            \Log::error('Vendor rejection email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.vendor-requests.index')
            ->with('success', 'Vendor request rejected and notification email sent.');
    }
}
