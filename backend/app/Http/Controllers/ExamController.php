<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use App\Models\Subject;
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

        $exams = Exam::where('department_id', $user->department_id)->get();

        // Fetch all PDF files from the exams folder
        $pdfFiles = Storage::disk('public')->files('exams');

        // Check for orphaned files (files without a corresponding exam record)
        foreach ($pdfFiles as $pdfFile) {
            $examId = pathinfo($pdfFile, PATHINFO_FILENAME); // Extract exam ID from filename
            $examExists = Exam::where('id', $examId)->exists();

            if (!$examExists) {
                // Delete exam record for the orphaned file
                Exam::destroy($examId);
            }
        }


        $exams = Exam::where('department_id', $user->department_id)->get();

        // Fetch the PDF files from storage and generate URLs
        foreach ($exams as $exam) {
            if ($exam->pdf_path && Storage::disk('public')->exists($exam->pdf_path)) {
                // Generate a URL for the PDF file
                $exam->pdf_url = Storage::disk('public')->url($exam->pdf_path);
            } else {
                // If the PDF file doesn't exist, set the URL to null
                $exam->pdf_url = null;
            }
            $subject = Subject::find($exam->subject_id);
            $exam->subjectName = $subject ? $subject->name : 'Unknown Subject';
            $exam->subjectSemester = $subject ? $subject->semester : 'Unknown Semester';
        }

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();


        $subjects = Subject::where('department_id', $user->department->id)->get();
        $examiners = User::where('role', 'teacher')
            ->where('department_id', $user->department_id)
            ->with('subjects') // Eager load the subjects relationship
            ->get();
        $departments = Department::where('id', $user->department_id)->get();
        $questions = Question::whereHas('subject', function ($query) use ($user) {
            $query->where('department_id', $user->department_id);
        })->with('subject')->get(); // Eager load subject


        return view('exams.create', compact('departments', 'questions', 'examiners', 'subjects'));
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
            'block' => 'nullable|integer',
            'department_id' => 'required|exists:departments,id',
            'questions' => 'required|array|min:5',
            'questions.*' => 'exists:questions,id',
            'examiner' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'date' => 'required|date|after:now',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);



        // Create the exam
        $exam = Exam::create([
            'name' => $request->name,
            'level' => $request->level,
            'block' => $request->block,
            'department_id' => $request->department_id,
            'subject_id' => $request->subject_id,
            'date' => $request->date,
            'duration' => $request->duration,
            'examiner' => $request->examiner,
        ]);

        // Attach selected questions to the exam
        $exam->questions()->attach($request->questions);
        // Fetch the subject name
        $subject = Subject::find($request->subject_id);
        $subjectName = $subject ? $subject->name : 'Unknown Subject';
        $subjectSemester = $subject ? $subject->semester : 'Unknown Semester';

        $logo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo16.png')));
        $HadhramutUniversityLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/universities/hu.png')));
        $engFacLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/faculties/hu-engfac.png')));
        $medFacLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/faculties/hu-medfac.png')));

        $data = [
            'HadhramutUniversityLogo' => $HadhramutUniversityLogo,
            'engFacLogo' =>  $engFacLogo,
            'medFacLogo' => $medFacLogo,
            'logo' => $logo,
            'subjectName' => $subjectName,
            'subjectSemester' => $subjectSemester,
            // Other data...
        ];

        // Generate PDF
        $questions = Question::whereIn('id', $request->questions)->get();
        $pdf = PDF::loadView('exams.pdf', $data, compact('exam', 'questions'));

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

    public function show(Exam $exam)
    {
        // Get the exam and its questions
        $questions = $exam->questions;
        $answers = $exam->questions->pluck('pivot.answer', 'id');

        $logo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo16.png')));
        $HadhramutUniversityLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/universities/hu.png')));
        $engFacLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/faculties/hu-engfac.png')));
        $medFacLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/faculties/hu-medfac.png')));

        // Fetch the subject name
        $subject = Subject::find($exam->subject_id);
        $subjectName = $subject ? $subject->name : 'Unknown Subject';
        $subjectSemester = $subject ? $subject->semester : 'Unknown Semester';

        $data = [
            'HadhramutUniversityLogo' => $HadhramutUniversityLogo,
            'engFacLogo' =>  $engFacLogo,
            'medFacLogo' => $medFacLogo,
            'logo' => $logo,
            'subjectName' => $subjectName,
            'subjectSemester' => $subjectSemester,
        ];


        // Generate the PDF using the DomPDF library
        $pdf = PDF::loadView('exams.pdf', $data, compact('exam', 'questions', 'answers'));

        // Stream the PDF to the browser with inline headers
        return $pdf->stream('exam_' . $exam->id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        // Retrieve all questions for filtering
        $user = Auth::user();

        $departments = Department::where('id', $user->department_id)->get();
        $examiners = User::where('role', 'teacher')->where('department_id', $user->department_id)->get();
        $questions = Question::whereHas('subject', function ($query) use ($user) {
            $query->where('department_id', $user->department_id);
        })->with('subject')->get(); // Eager load subject
        $subjects = Subject::where('department_id', $user->department->id)->get();


        // Retrieve the IDs of questions already attached to the exam
        $selectedQuestions = $exam->questions->pluck('id')->toArray();

        return view('exams.edit', compact('exam', 'questions', 'departments', 'selectedQuestions', 'examiners', 'subjects'));
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
            'block' => 'nullable|integer',
            'department_id' => 'required|exists:departments,id',
            'questions' => 'required|array|min:5',
            'questions.*' => 'exists:questions,id',
            'examiner' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'date' => 'required|date|after:today',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        // Update the exam details
        $exam->update([
            'name' => $request->name,
            'level' => $request->level,
            'block' => $request->block,
            'department_id' => $request->department_id,
            'subject_id' => $request->subject_id,
            'date' => $request->date,
            'duration' => $request->duration,
            'examiner' => $request->examiner,
        ]);

        $logo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo16.png')));
        $HadhramutUniversityLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/universities/hu.png')));
        $engFacLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/faculties/hu-engfac.png')));
        $medFacLogo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/faculties/hu-medfac.png')));

        // Fetch the subject name
        $subject = Subject::find($exam->subject_id);
        $subjectName = $subject ? $subject->name : 'Unknown Subject';
        $subjectSemester = $subject ? $subject->semester : 'Unknown Semester';

        $data = [
            'HadhramutUniversityLogo' => $HadhramutUniversityLogo,
            'engFacLogo' =>  $engFacLogo,
            'medFacLogo' => $medFacLogo,
            'logo' => $logo,
            'subjectName' => $subjectName,
            'subjectSemester' => $subjectSemester,
        ];

        // Sync the selected questions with the exam
        $exam->questions()->sync($request->questions);

        // Regenerate the PDF
        $questions = Question::whereIn('id', $request->questions)->get();
        $pdf = PDF::loadView('exams.pdf', $data, compact('exam', 'questions'));

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
        // Delete the PDF file if it exists in storage
        if ($exam->pdf_path && Storage::disk('public')->exists($exam->pdf_path)) {
            Storage::disk('public')->delete($exam->pdf_path);
        }

        // Delete the exam record
        $exam->delete();

        return redirect()->route('dashboard.exams')->with('success', 'Exam deleted successfully.');
    }
}
