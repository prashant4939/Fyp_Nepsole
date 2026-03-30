<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class VendorController extends Controller
{
    /**
     * Show vendor portal with login/signup options
     */
    public function portal()
    {
        return view('vendor.portal');
    }

    /**
     * Show vendor login form
     */
    public function showLogin()
    {
        return view('vendor.login');
    }

    /**
     * Handle vendor login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            $user = auth()->user();

            // Check if user is a vendor
            if ($user->role !== 'vendor') {
                auth()->logout();
                return back()->withErrors(['email' => 'These credentials do not match a vendor account.']);
            }

            // Check if vendor is approved
            $vendor = $user->vendor;
            if (!$vendor || !$vendor->is_verified) {
                auth()->logout();
                return redirect()->route('vendor.pending')
                    ->with('error', 'Your vendor account is pending approval. Please wait for admin verification.');
            }

            // Check if vendor is active
            if (!$vendor->is_active) {
                auth()->logout();
                return back()->withErrors(['email' => 'Your vendor account has been deactivated. Please contact support.']);
            }

            $request->session()->regenerate();
            return redirect()->route('vendor.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show vendor registration form
     */
    public function showRegistrationForm()
    {
        return view('vendor.register');
    }

    /**
     * Handle vendor registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'business_name' => ['required', 'string', 'max:255'],
            'pan_number' => ['required', 'string', 'max:20', 'unique:vendors'],
            'business_type' => ['required', 'in:sole_proprietorship,partnership,private_limited,llp,other'],
            'citizenship_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'company_registration_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'tax_certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
        ]);

        // Handle file uploads
        $citizenshipPath = $request->file('citizenship_certificate')->store('vendor_docs/citizenship', 'public');
        $registrationPath = $request->file('company_registration_certificate')->store('vendor_docs/registration', 'public');
        $taxPath = $request->hasFile('tax_certificate') 
            ? $request->file('tax_certificate')->store('vendor_docs/tax', 'public') 
            : null;

        // Create vendor profile
        Vendor::create([
            'user_id' => $user->id,
            'business_name' => $request->business_name,
            'pan_number' => $request->pan_number,
            'business_type' => $request->business_type,
            'citizenship_certificate' => $citizenshipPath,
            'company_registration_certificate' => $registrationPath,
            'tax_certificate' => $taxPath,
            'is_verified' => false,
            'is_active' => false,
        ]);

        return redirect()->route('vendor.pending')->with('success', 'Vendor registration submitted successfully! Please wait for admin approval.');
    }

    /**
     * Show pending approval page
     */
    public function pending()
    {
        return view('vendor.pending');
    }
}