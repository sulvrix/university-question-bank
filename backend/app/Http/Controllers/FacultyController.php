<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Faculty::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all(); // Fetch all unique faculties
        $universities = University::all(); // Fetch all unique faculties

        return view('faculties.create', compact('faculties', 'universities'));
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
                'university_id' => 'required|integer|exists:university,id',
            ]);

            Faculty::create([
                'name' => $validatedData['name'],
                'university_id' => $validatedData['university_id'],
            ]);

            // Redirect to a specific route with a success message
            return redirect('/dashboard')->with('success', 'Faculty created successfully.');
        } catch (ValidationException $e) {
            // Return an error response if validation fails
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        return $this->destroy($faculty);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {

        $faculties = Faculty::all(); // Fetch all unique faculties

        return view('faculties.edit', compact('faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $faculty->name = $validatedData['name'];
        $faculty->save();

        // Redirect to a specific route with a success message
        return redirect('/dashboard')->with('success', 'Faculty updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect('/dashboard')->with('success', 'Faculty deleted successfully.');
    }
}
