<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function Index()
    {
        return User::all();
    }

    public function create()
    {
        // Fetch all users
        $users = User::all();

        // Get unique roles
        $roles = $users->unique('role')->pluck('role');

        // Get unique departments
        $departments = $users->unique('department_id')->map(function ($user) {
            return [
                'id' => $user->department_id,
                'name' => $user->department->name,
            ];
        });

        return view('users.create', compact('users', 'roles', 'departments'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|string|in:admin,staff,commissioner,teacher',
                'status' => 'required|string|in:active,inactive',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',
                'department_id' => 'required|integer|exists:departments,id',
            ]);

            // Create a new user
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'],
                'status' => $validatedData['status'],
                'password' => bcrypt($validatedData['password']),
                'department_id' => $validatedData['department_id'],
            ]);

            // Redirect to a specific route with a success message
            return redirect('/home')->with('success', 'User created successfully.');
        } catch (ValidationException $e) {
            // Return an error response if validation fails
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,staff,commissioner,teacher',
            'status' => 'required|string|in:active,inactive',
            'new_password' => 'nullable|string|min:6|confirmed',
            'new_password_confirmation' => 'nullable|string|min:6',
            'department_id' => 'required|integer|exists:departments,id',
        ]);

        // Update the user data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->status = $validatedData['status'];
        if (!empty($validatedData['new_password'])) {
            $user->password = bcrypt($validatedData['new_password']);
        }
        $user->department_id = $validatedData['department_id'];
        $user->save();

        // Redirect to a specific route with a success message
        return redirect('/home')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/home')->with('success', 'User deleted successfully.');
    }
}
