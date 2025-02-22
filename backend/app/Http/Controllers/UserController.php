<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function getData()
    {
        return User::all();
    }

    public function Index()
    {
        return response()->view('errors.404', [], 404);
    }

    public function create()
    {
        // Define all possible roles explicitly
        $roles = ['admin', 'staff', 'commissioner', 'teacher'];
        $statuses = ['active', 'inactive'];

        // Fetch all users (if needed)
        $users = User::all();

        // Fetch unique departments (if needed)
        $departments = Department::all();

        return view('admin.users.create', compact('users', 'roles', 'statuses', 'departments'));
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
            return redirect('/dashboard')->with('success', 'User created successfully.');
        } catch (ValidationException $e) {
            // Return an error response if validation fails
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function edit(User $user)
    {
        // Fetch the user being edited
        $user = User::findOrFail($user->id);

        // Fetch unique roles
        $roles = ['admin', 'staff', 'commissioner', 'teacher'];
        $statuses = ['active', 'inactive'];

        // Fetch unique departments
        $departments = Department::all();

        return view('admin.users.edit', compact('user', 'roles', 'statuses', 'departments'));
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
        return redirect('/dashboard')->with('success', 'User updated successfully.');
    }

    public function show(User $user)
    {
        return $this->destroy($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/dashboard')->with('success', 'User deleted successfully.');
    }
}
