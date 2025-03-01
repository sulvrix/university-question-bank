<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    public function getData()
    {
        return Department::all();
    }

    public function index()
    {
        return response()->view('errors.404', [], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all(); // Fetch all unique faculties
        $departments = Department::all();

        return view('admin.departments.create', compact('faculties', 'departments'));
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

            Department::create([
                'name' => $validatedData['name'],
                'faculty_id' => $validatedData['faculty_id'],
            ]);

            // Redirect to a specific route with a success message
            return redirect('/dashboard')->with('success', 'Department created successfully.');
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
        $department = Department::findOrFail($department->id);

        $faculties = Faculty::all(); // Fetch all unique faculties

        return view('admin.departments.edit', compact('department', 'faculties'));
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

        $department->name = $validatedData['name'];
        $department->faculty_id = $validatedData['faculty_id'];
        $department->save();

        // Redirect to a specific route with a success message
        return redirect('/dashboard')->with('success', 'Department updated successfully.');
    }
    public function show(Department $department)
    {
        return $this->edit($department);
    }
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect('/dashboard')->with('success', 'Department deleted successfully.');
    }
}
