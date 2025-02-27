<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            // Admins can see all questions
            $exams = Exam::all();
        } else {
            // Non-admins can only see questions from their department
            $exams = Exam::where('department_id', $user->department_id)->get();
        }
        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $departments = Department::all();
            $questions = Question::with('subject')->get(); // Eager load subject
        } else {
            $departments = Department::where('id', $user->department_id)->get();
            $questions = Question::whereHas('subject', function ($query) use ($user) {
                $query->where('department_id', $user->department_id);
            })->with('subject')->get(); // Eager load subject
        }

        return view('exams.create', compact('departments', 'questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        //
    }
}
