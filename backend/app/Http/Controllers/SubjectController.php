<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    public function getData()
    {
        return Subject::all();
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
        $departments = Department::all(); // Fetch all unique departments
        $subjects = Subject::all(); // Fetch all unique departments
        return view('admin.subjects.create', compact('departments', 'subjects'));
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
                'level' => 'required|in:1,2,3',
                'department_id' => 'required|integer|exists:departments,id',
            ]);

            Subject::create([
                'name' => $validatedData['name'],
                'level' => $validatedData['level'],
                'department_id' => $validatedData['department_id'],
            ]);

            // Redirect to a specific route with a success message
            return redirect('/dashboard')->with('success', 'Subject created successfully.');
        } catch (ValidationException $e) {
            // Return an error response if validation fails
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $subject = Subject::findOrFail($subject->id);
        $departments = Department::all(); // Fetch all unique departments // Fetch all unique departments
        return view('admin.subjects.edit', compact('subject', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:1,2,3',
            'department_id' => 'required|integer|exists:departments,id',
        ]);

        $subject->name = $validatedData['name'];
        $subject->level = $validatedData['level'];
        $subject->department_id = $validatedData['department_id'];
        $subject->save();

        // Redirect to a specific route with a success message
        return redirect('/dashboard')->with('success', 'Subject updated successfully.');
    }

    public function show(Subject $subject)
    {
        return $this->edit($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect('/dashboard')->with('success', 'Subject deleted successfully.');
    }
}
