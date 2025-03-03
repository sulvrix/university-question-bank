<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;
use OpenAI\Laravel\Facades\OpenAI;


class QuestionController extends Controller
{
    // Display a list of questions
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admins can see all questions
            $questions = Question::all();
        } else {
            // Non-admins can only see questions from their department
            $questions = Question::whereHas('subject', function ($query) use ($user) {
                $query->where('department_id', $user->department_id);
            })->get();
        }

        // Add a computed property for the correct answer
        foreach ($questions as $question) {
            $answers = is_array($question->answers) ? $question->answers : json_decode($question->answers, true);
            $correctAnswer = 'N/A';
            foreach ($answers as $answer) {
                if (isset($answer['is_correct']) && $answer['is_correct']) {
                    $correctAnswer = $answer['text'];
                    break;
                }
            }
            $question->correct_answer = $correctAnswer;
        }

        return view('questions.index', compact('questions'));
    }

    // Show the form to create a new question
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admins can see all subjects
            $subjects = Subject::all();
        } else {
            // Non-admins can only see subjects from their department
            $subjects = Subject::where('department_id', $user->department_id)->get();
        }

        return view('questions.create', compact('subjects'));
    }

    // Store a new question
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'answers' => 'required|array|size:4',
            'answers.*.text' => 'required|string',
            'correct_answer' => 'required|integer|between:0,3',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'points' => 'nullable|integer',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $answers = $request->input('answers');
        $correctAnswerIndex = $request->input('correct_answer');
        foreach ($answers as $index => &$answer) {
            $answer['is_correct'] = ($index == $correctAnswerIndex);
        }

        Question::create([
            'text' => $request->input('text'),
            'answers' => $answers,
            'difficulty' => $request->input('difficulty'),
            'points' => $request->input('points'),
            'subject_id' => $request->input('subject_id'),
        ]);

        return redirect()->route('dashboard.questions')->with('success', 'Question created successfully.');
    }

    // Show the form to edit a question
    public function edit(Question $question)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admins can see all subjects
            $subjects = Subject::all();
        } else {
            // Non-admins can only see subjects from their department
            $subjects = Subject::where('department_id', $user->department_id)->get();
        }

        return view('questions.edit', compact('question', 'subjects'));
    }

    // Update a question
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'text' => 'required|string',
            'answers' => 'required|array|size:4',
            'answers.*.text' => 'required|string',
            'correct_answer' => 'required|integer|between:0,3',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'points' => 'nullable|integer',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $answers = $request->input('answers');
        $correctAnswerIndex = $request->input('correct_answer');
        foreach ($answers as $index => &$answer) {
            $answer['is_correct'] = ($index == $correctAnswerIndex);
        }

        $question->update([
            'text' => $request->input('text'),
            'answers' => $answers,
            'difficulty' => $request->input('difficulty'),
            'points' => $request->input('points'),
            'subject_id' => $request->input('subject_id'),
        ]);

        return redirect()->route('dashboard.questions')->with('success', 'Question updated successfully.');
    }

    public function show(Question $question)
    {
        return $this->edit($question);
    }
    // Delete a question
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('dashboard.questions')->with('success', 'Question deleted successfully.');
    }

    public function generate()
    {
        return view('questions.generate');
    }
}
