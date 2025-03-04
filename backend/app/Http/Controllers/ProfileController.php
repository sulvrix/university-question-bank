<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(404);
        }

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$user->id}",
            'old_password' => 'nullable|string|min:6',
            'password' => 'nullable|string|min:6|confirmed',
        ];

        // Add conditional rule for old_password
        if ($request->filled('password')) {
            $rules['old_password'] = 'required|string|min:6';
        }

        // Validate the request
        $validatedData = $request->validate($rules);

        // Check if the old password is provided and matches the current password
        if ($request->filled('old_password')) {
            if (!Hash::check($validatedData['old_password'], $user->password)) {
                throw ValidationException::withMessages([
                    'old_password' => ['The old password is incorrect.'],
                ]);
            }
        }

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Update password if provided
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
