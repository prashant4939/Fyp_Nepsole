<?php

namespace App\Http\Controllers;

use App\Mail\NewVendorRequestNotification;
use App\Models\VendorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VendorRequestController extends Controller
{
    public function create()
    {
        return view('vendor-request.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255|unique:vendor_requests,email',
            'phone'             => 'required|digits_between:7,15',
            'shop_name'         => 'required|string|max:255',
            'address'           => 'required|string|max:500',
            'citizenship_photo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tax_clearance'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'business_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'shop_name', 'address']);

        // Store uploaded files
        if ($request->hasFile('citizenship_photo')) {
            $data['citizenship_photo'] = $request->file('citizenship_photo')
                ->store('vendor_requests/citizenship', 'public');
        }
        if ($request->hasFile('tax_clearance')) {
            $data['tax_clearance'] = $request->file('tax_clearance')
                ->store('vendor_requests/tax', 'public');
        }
        if ($request->hasFile('business_document')) {
            $data['business_document'] = $request->file('business_document')
                ->store('vendor_requests/business', 'public');
        }

        $vendorRequest = VendorRequest::create($data);

        // Notify admin
        $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL', 'admin@nepsole.com'));
        try {
            Mail::to($adminEmail)->send(new NewVendorRequestNotification($vendorRequest));
        } catch (\Exception $e) {
            \Log::error('Admin notification email failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your vendor application has been submitted! We will review it and get back to you via email.');
    }
}
