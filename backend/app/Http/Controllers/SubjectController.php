<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function getData()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admins can see all subjects
            $subjects = Subject::all();
        } else {
            // Non-admins can only see subjects from their department
            $subjects = Subject::where('department_id', $user->department_id)->get();
        }

        return $subjects;
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
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admins can create subjects for any department
            $departments = Department::all();
            $faculties = Faculty::all();
        } else {
            // Non-admins can only create subjects for their own department
            $faculties = Faculty::all();
            $departments = Department::where('id', $user->department_id)->get();
        }

        return view('admin.subjects.create', compact('departments', 'faculties'));
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
                'level' => 'required|in:1,2,3,4,5',
                'department_id' => 'required|integer|exists:departments,id',
                'faculty_id' => 'required|integer|exists:faculties,id',
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
        $user = auth::User();
        if ($user->role === 'admin') {
            // Admins can create subjects for any department
            $departments = Department::all();
            $faculties = Faculty::all();
        } else {
            // Non-admins can only create subjects for their own department
            $faculties = Faculty::all();
            $departments = Department::where('id', $user->department_id)->get();
        }
        return view('admin.subjects.edit', compact('subject', 'departments', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:1,2,3,4,5',
            'department_id' => 'required|integer|exists:departments,id',
            'faculty_id' => 'required|integer|exists:faculties,id',
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
