<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UniversityController extends Controller
{
    public function getData()
    {
        return University::all();
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
        $universities = University::all(); // Fetch all unique faculties

        return view('admin.universities.create', compact('universities'));
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
            ]);

            University::create([
                'name' => $validatedData['name'],
            ]);

            // Redirect to a specific route with a success message
            return redirect('/dashboard')->with('success', 'University created successfully.');
        } catch (ValidationException $e) {
            // Return an error response if validation fails
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(University $university)
    {
        return $this->edit($university);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(University $university)
    {

        return view('admin.universities.edit', compact('university'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, University $university)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $university->name = $validatedData['name'];
        $university->save();

        // Redirect to a specific route with a success message
        return redirect('/dashboard')->with('success', 'University updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(University $university)
    {
        $university->delete();
        return redirect('/dashboard')->with('success', 'University deleted successfully.');
    }
}
