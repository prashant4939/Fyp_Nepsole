<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VendorManagementController extends Controller
{
    /**
     * Display pending vendors
     */
    public function index()
    {
        $pendingVendors = Vendor::with('user')
            ->where('is_verified', false)
            ->latest()
            ->get();

        $approvedVendors = Vendor::with('user')
            ->where('is_verified', true)
            ->latest()
            ->get();

        return view('admin.vendors.index', compact('pendingVendors', 'approvedVendors'));
    }

    /**
     * Show vendor details
     */
    public function show(Vendor $vendor)
    {
        $vendor->load('user');
        return view('admin.vendors.show', compact('vendor'));
    }

    /**
     * Approve vendor
     */
    public function approve(Vendor $vendor)
    {
        $vendor->update([
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Send approval email
        $this->sendApprovalEmail($vendor);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor approved successfully! Approval email sent.');
    }

    /**
     * Reject/Delete vendor
     */
    public function reject(Vendor $vendor)
    {
        $user = $vendor->user;
        
        // Delete vendor and user
        $vendor->delete();
        $user->delete();

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor application rejected and deleted.');
    }

    /**
     * Deactivate vendor
     */
    public function deactivate(Request $request, Vendor $vendor)
    {
        $request->validate([
            'deactivation_note' => 'required|string|max:500'
        ]);

        $vendor->update([
            'is_active' => false,
            'deactivation_note' => $request->deactivation_note,
        ]);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor deactivated successfully.');
    }

    /**
     * Reactivate vendor
     */
    public function reactivate(Vendor $vendor)
    {
        $vendor->update([
            'is_active' => true,
            'deactivation_note' => null,
        ]);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor reactivated successfully.');
    }

    /**
     * Send approval email to vendor
     */
    private function sendApprovalEmail(Vendor $vendor)
    {
        $data = [
            'vendor_name' => $vendor->user->name,
            'business_name' => $vendor->business_name,
            'login_url' => route('login'),
        ];

        Mail::send('emails.vendor-approved', $data, function ($message) use ($vendor) {
            $message->to($vendor->user->email, $vendor->user->name)
                    ->subject('Your Vendor Account Has Been Approved - NepSole');
        });
    }
}