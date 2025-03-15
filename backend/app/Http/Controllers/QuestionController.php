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
        } elseif ($user->role === 'teacher') {
            // Non-admins can only see questions from their department
            $questions = Question::where('subject_id', $user->subject_id)->get();
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
            'text' => 'required|string|unique:questions,text,NULL,id,subject_id,' . $request->input('subject_id'),
            'answers' => 'required|array|size:4',
            'answers.*.text' => 'required|string',
            'correct_answer' => 'required|integer|between:0,3',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'points' => 'nullable|integer',
            'subject_id' => 'required|exists:subjects,id',
        ], [
            'text.unique' => 'The question already exists for this subject.',
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
            'text' => 'required|string|unique:questions,text,' . $question->id . ',id,subject_id,' . $request->input('subject_id'),
            'answers' => 'required|array|size:4',
            'answers.*.text' => 'required|string',
            'correct_answer' => 'required|integer|between:0,3',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'points' => 'nullable|integer',
            'subject_id' => 'required|exists:subjects,id',
        ], [
            'text.unique' => 'The question already exists for this subject.',
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
        // Decode the answers if they are stored as JSON
        $answers = is_array($question->answers) ? $question->answers : json_decode($question->answers, true);

        // Find the correct answer
        $correctAnswer = 'N/A';
        foreach ($answers as $answer) {
            if (isset($answer['is_correct']) && $answer['is_correct']) {
                $correctAnswer = $answer['text']; // Access 'text' as an array key
                break;
            }
        }

        // Add the correct answer as a computed property to the question
        $question->correct_answer = $correctAnswer;

        // Pass the question and answers to the view
        return view('questions.show', [
            'question' => $question,
            'answers' => $answers, // Pass the decoded answers to the view
        ]);
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
