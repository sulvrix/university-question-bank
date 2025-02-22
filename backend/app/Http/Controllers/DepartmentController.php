<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Department::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all(); // Fetch all unique faculties

        return view('departments.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'faculty_id' => 'required|integer|exists:faculties,id',
            ]);

            // Create a new user
            Department::create([
                'name' => $validatedData['name'],
                'faculty_id' => $validatedData['faculty_id'],
            ]);

            // Redirect to a specific route with a success message
            return redirect('/home')->with('success', 'User created successfully.');
        } catch (ValidationException $e) {
            // Return an error response if validation fails
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'faculty_id' => 'required|integer|exists:faculties,id',
        ]);

        // Update the user data
        $department->name = $validatedData['name'];
        $department->faculty_id = $validatedData['department_id'];
        $department->save();

        // Redirect to a specific route with a success message
        return redirect('/home')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect('/home')->with('success', 'User deleted successfully.');
    }
}
