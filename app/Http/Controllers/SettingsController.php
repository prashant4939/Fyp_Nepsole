<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('settings.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('settings.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')
                ->store('profile_images', 'public');
        }

        $user->update($data);

        return redirect()->route('settings.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('settings.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'  => 'required',
            'password'          => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully!');
    }
}
