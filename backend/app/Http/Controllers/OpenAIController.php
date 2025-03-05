<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function rephrase(Request $request)
    {
        Log::info('Received rephrase request', ['request' => $request->all()]);

        $question = $request->input('question');

        if (!$question) {
            Log::error('Rephrase API error: No question provided');
            return response()->json(['error' => 'No question provided'], 400);
        }

        try {
            // Updated prompt to check for invalid questions
            $prompt = "If the following input is not a valid question, respond with only the word 'wrong'. Otherwise, rephrase the question three times, each on a new line:\n\n$question";

            $response = $this->openAIService->chat($prompt);

            if (!$response) {
                Log::error('Rephrase API error: No valid response received');
                return response()->json(['error' => 'Failed to generate rephrased questions'], 500);
            }

            // If the response is 'wrong', return it as a single-item array
            if (trim($response) === 'wrong') {
                return response()->json(['rephrases' => ['wrong']]);
            }

            // Split the response into an array of rephrased questions
            $rephrases = explode("\n", trim($response));

            // Filter out any empty or null entries
            $rephrases = array_filter($rephrases, function ($rephrase) {
                return !empty(trim($rephrase));
            });

            // Re-index the array to ensure it's sequential
            $rephrases = array_values($rephrases);

            return response()->json(['rephrases' => $rephrases]);
        } catch (\Exception $e) {
            Log::error('Rephrase API exception: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function generateQuestions(Request $request)
    {
        $request->validate(['pdf' => 'required|mimes:pdf|max:10240']);

        // Extract text from the PDF
        $text = $this->openAIService->extractTextFromPDF($request->file('pdf'));

        if (!$text) {
            Log::error('Failed to extract text from PDF');
            return response()->json(['error' => 'Failed to extract text from PDF'], 500);
        }

        // Generate questions using OpenAI
        $prompt = "Generate 5 multiple-choice questions from the following text. Format as JSON:
        [
            {'question': '...', 'choices': ['...', '...', '...', '...'], 'correct_answer': '...'}
        ]
        Text: $text";

        $response = $this->openAIService->chat($prompt, 'gpt-4o-mini', 1000);

        if (!$response) {
            Log::error('Failed to generate questions from OpenAI API');
            return response()->json(['error' => 'Failed to generate questions'], 500);
        }

        // Clean up the response and decode JSON
        $cleanedResponse = preg_replace('/```json|```/', '', $response);
        $questions = json_decode($cleanedResponse, true);

        if (!is_array($questions)) {
            Log::error('Invalid response format from OpenAI API', ['response' => $response]);
            return response()->json(['error' => 'Invalid response format'], 500);
        }

        // Return the questions and the extracted text for pagination
        return response()->json(['questions' => $questions, 'text' => $text]);
    }

    // Handle "Load More" functionality
    public function loadMoreQuestions(Request $request)
    {
        $text = $request->input('text');
        $page = $request->input('page', 1); // Get the page number from the request
        $perPage = 5; // Number of questions to generate per page

        if (!$text) {
            Log::error('No text found for generating more questions');
            return response()->json(['error' => 'No text found'], 400);
        }

        // Generate questions using OpenAI
        $prompt = "Generate $perPage multiple-choice questions from the following text. Format as JSON:
        [
            {'question': '...', 'choices': ['...', '...', '...', '...'], 'correct_answer': '...'}
        ]
        Text: $text";

        $response = $this->openAIService->chat($prompt, 'gpt-4o-mini', 1000);

        if (!$response) {
            Log::error('Failed to generate more questions from OpenAI API');
            return response()->json(['error' => 'Failed to generate more questions'], 500);
        }

        // Clean up the response and decode JSON
        $cleanedResponse = preg_replace('/```json|```/', '', $response);
        $questions = json_decode($cleanedResponse, true);

        if (!is_array($questions)) {
            Log::error('Invalid response format from OpenAI API', ['response' => $response]);
            return response()->json(['error' => 'Invalid response format'], 500);
        }

        return response()->json(['questions' => $questions]);
    }
}
