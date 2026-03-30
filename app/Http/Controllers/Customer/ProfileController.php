<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('customer.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the change password form.
     */
    public function editPassword()
    {
        return view('customer.profile.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    /**
     * Show the forgot password form.
     */
    public function showForgotForm()
    {
        return view('customer.auth.forgot-password');
    }

    /**
     * Send password reset link.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // Check if user has requested reset in last 60 seconds
        $recentRequest = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subSeconds(60))
            ->first();

        if ($recentRequest) {
            $remainingTime = 60 - Carbon::now()->diffInSeconds($recentRequest->created_at);
            return back()->withErrors(['email' => "Please wait {$remainingTime} seconds before requesting another reset."]);
        }

        // Delete old tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Create new token
        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        // Send email
        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        Mail::send('emails.reset-password', ['resetUrl' => $resetUrl, 'user' => $user], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password - NepSole');
        });

        return back()->with('status', 'Password reset link has been sent to your email! Link expires in 40 seconds.');
    }

    /**
     * Show the reset password form.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('customer.auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the token
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Check if token is expired (40 seconds)
        if (Carbon::parse($tokenData->created_at)->addSeconds(40)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'This reset link has expired. Please request a new one.']);
        }

        // Verify token
        if (!Hash::check($request->token, $tokenData->token)) {
            return back()->withErrors(['email' => 'Invalid reset token.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset successfully! You can now login.');
    }
}
