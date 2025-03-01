<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

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
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
            'block' => 'required|integer',
            'department_id' => 'required|exists:departments,id',
            'questions' => 'required|array|min:5',
            'questions.*' => 'exists:questions,id',
        ]);

        // Create the exam
        $exam = Exam::create([
            'name' => $request->name,
            'level' => $request->level,
            'block' => $request->block,
            'department_id' => $request->department_id,
        ]);

        // Attach selected questions to the exam
        $exam->questions()->attach($request->questions);

        // Generate PDF
        $questions = Question::whereIn('id', $request->questions)->get();
        $pdf = PDF::loadView('exams.pdf', compact('exam', 'questions'));

        // Define the PDF path
        $pdfDirectory = 'exams'; // Relative directory inside storage/app/public
        $pdfFileName = $exam->id . '.pdf';
        $pdfPath = $pdfDirectory . '/' . $pdfFileName;

        // Create the directory if it doesn't exist
        if (!Storage::disk('public')->exists($pdfDirectory)) {
            Storage::disk('public')->makeDirectory($pdfDirectory);
        }

        // Save the PDF to the directory
        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Save the relative PDF path to the exam record
        $exam->update(['pdf_path' => $pdfPath]);

        // Redirect or return response
        return redirect()->route('dashboard.exams')->with('success', 'Exam created successfully!');
    }

    /**
     * Display the specified resource.
     */


    public function show(Exam $exam)
    {
        // Check if the PDF file exists in storage
        if ($exam->pdf_path && Storage::disk('public')->exists($exam->pdf_path)) {
            // Generate the URL to the PDF file
            $pdfUrl = asset('storage/' . $exam->pdf_path);

            // Redirect to the PDF URL (will open in a new window/tab)
            return redirect($pdfUrl);
        }

        // If the PDF file does not exist, return a 404 response
        abort(404, 'PDF file not found.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        // Retrieve all questions for filtering
        $questions = Question::with('subject')->get();

        // Retrieve departments (if needed for the dropdown)
        $departments = Department::all();

        // Retrieve the IDs of questions already attached to the exam
        $selectedQuestions = $exam->questions->pluck('id')->toArray();

        return view('exams.edit', compact('exam', 'questions', 'departments', 'selectedQuestions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
            'block' => 'required|integer',
            'department_id' => 'required|exists:departments,id',
            'questions' => 'required|array|min:5',
            'questions.*' => 'exists:questions,id',
        ]);

        // Update the exam details
        $exam->update([
            'name' => $request->name,
            'level' => $request->level,
            'block' => $request->block,
            'department_id' => $request->department_id,
        ]);

        // Sync the selected questions with the exam
        $exam->questions()->sync($request->questions);

        // Regenerate the PDF
        $questions = Question::whereIn('id', $request->questions)->get();
        $pdf = PDF::loadView('exams.pdf', compact('exam', 'questions'));

        // Define the PDF path
        $pdfDirectory = 'exams'; // Relative directory inside storage/app/public
        $pdfFileName = $exam->id . '.pdf';
        $pdfPath = $pdfDirectory . '/' . $pdfFileName;

        // Create the directory if it doesn't exist
        if (!Storage::disk('public')->exists($pdfDirectory)) {
            Storage::disk('public')->makeDirectory($pdfDirectory);
        }

        // Save the updated PDF to the directory
        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Update the PDF path in the exam record
        $exam->update(['pdf_path' => $pdfPath]);

        // Redirect or return response
        return redirect()->route('dashboard.exams')->with('success', 'Exam updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        // Delete the PDF file if it exists
        if ($exam->pdf_path && file_exists($exam->pdf_path)) {
            unlink($exam->pdf_path);
        }
        $exam->delete();
        return redirect('/dashboard/exams')->with('success', 'Exam deleted successfully.');
    }
}
