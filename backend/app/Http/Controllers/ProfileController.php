<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

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
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        // Check if the email is being updated
        $emailChanged = $user->email !== $validatedData['email'];

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // If the email was changed, mark the email as unverified
        if ($emailChanged && $user instanceof MustVerifyEmail) {
            $user->email_verified_at = null;
            $user->save();

            // Trigger the email verification notification
            $user->sendEmailVerificationNotification();

            // Redirect with a message informing the user that a verification email has been sent
            return redirect()->route('profile.edit')->with('status', 'A verification email has been sent to your new email address. Please verify it to complete the update.');
        }

        // If the email was not changed, just save the user model
        $user->save();

        // Redirect with a success message
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }
}
