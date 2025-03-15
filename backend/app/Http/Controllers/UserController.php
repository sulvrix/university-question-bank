<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Subject;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function getData()
    {
        return User::all()->map(function ($user) {
            if ($user->subject_id === null) {
                $user->subject = (object) ['name' => 'None'];
            }
            return $user;
        });
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

        $users = User::all();
        $departments = Department::all();
        $subjects = Subject::all();

        return view('admin.users.create', compact('users', 'roles', 'statuses', 'departments', 'subjects'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|min:4|max:16|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|string|in:admin,staff,commissioner,teacher',
                'status' => 'required|string|in:active,inactive',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',
                'department_id' => 'required|integer|exists:departments,id',
            ]);


            // Custom validation for subject_id when role is teacher
            if ($validatedData['role'] === 'teacher') {
                $request->validate([
                    'subject_id' => 'required|integer|exists:subjects,id',
                ]);
                $validatedData['subject_id'] = $request->input('subject_id');
            } else {
                $validatedData['subject_id'] = null; // Set subject_id to null if role is not teacher
            }

            // Create a new user
            User::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'],
                'status' => $validatedData['status'],
                'password' => bcrypt($validatedData['password']),
                'department_id' => $validatedData['department_id'],
                'subject_id' => $validatedData['subject_id'],
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

        $departments = Department::all();
        $subjects = Subject::all();

        return view('admin.users.edit', compact('user', 'roles', 'statuses', 'departments', 'subjects'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:4|max:16|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,staff,commissioner,teacher',
            'status' => 'required|string|in:active,inactive',
            'department_id' => 'required|integer|exists:departments,id',
        ]);

        // Custom validation for subject_id when role is teacher
        if ($validatedData['role'] === 'teacher') {
            $request->validate([
                'subject_id' => 'required|integer|exists:subjects,id',
            ]);
            $validatedData['subject_id'] = $request->input('subject_id');
        } else {
            $validatedData['subject_id'] = null; // Set subject_id to null if role is not teacher
        }

        // Update the user data
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->status = $validatedData['status'];
        $user->department_id = $validatedData['department_id'];
        $user->subject_id = $validatedData['subject_id'];
        $user->save();

        // Redirect to a specific route with a success message
        return redirect('/dashboard')->with('success', 'User updated successfully.');
    }

    public function show(User $user)
    {
        return $this->edit($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/dashboard')->with('success', 'User deleted successfully.');
    }
}
