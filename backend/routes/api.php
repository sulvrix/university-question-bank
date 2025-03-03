<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/rephrase', function (Request $request) {
    Log::info('Rephrase request received', ['question' => $request->input('question')]);

    $question = $request->input('question');

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "You are an expert in rephrasing.
                    Rephrase the following question three times, and make sure each rephrased question is listed on a new line,
                    without combining them into a single sentence. Here is the question to rephrase: $question
                    Keep in mind that if the provided question is not valid, you should respond with 'wrong.'"
                ]
            ],
            'max_tokens' => 100,
            'n' => 1
        ]);

        Log::info('OpenAI response', ['response' => $response]);

        $rephrases = explode("\n", $response['choices'][0]['message']['content']); // Split by newline

        return response()->json([
            'rephrases' => $rephrases
        ]);
    } catch (\Exception $e) {
        Log::error('OpenAI API error', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

//generate route
Route::post('/generate', function (Request $request) {
    // Validate the uploaded file
    $request->validate([
        'pdf' => 'required|mimes:pdf|max:10240', // Max 10MB
    ]);

    try {
        // Extract text from the PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('pdf')->path());
        $pdfText = $pdf->getText();

        // Use OpenAI API to generate questions
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Generate 5 multiple-choice questions based on the following text. Each question should have 4 choices, with one correct answer. Format the response as a valid JSON array of objects, where each object has the following structure:
                    {
                        'question': 'The question text',
                        'choices': ['Choice 1', 'Choice 2', 'Choice 3', 'Choice 4'],
                        'correct_answer': 'The correct choice'
                    }\n\n$pdfText\n\nReturn only the JSON array, without any additional text or explanations."
                ]
            ],
            'max_tokens' => 500, // Adjust tokens as needed
            'temperature' => 0.7,
        ]);

        // Extract the JSON from the OpenAI response
        $responseContent = $response['choices'][0]['message']['content'];

        // Remove Markdown code block syntax (```json and ```)
        $jsonString = preg_replace('/```json|```/', '', $responseContent);

        // Decode the JSON string
        $questions = json_decode($jsonString, true);

        // Validate the extracted questions
        if (!is_array($questions)) {
            return response()->json(['error' => 'Invalid questions format'], 500);
        }

        // Return the questions and PDF text as a JSON response
        return response()->json([
            'questions' => $questions,
            'pdfText' => $pdfText // Include the PDF text in the response
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/generate', function (Request $request) {
    $page = $request->query('page', 1); // Get the page number from the query string
    $pdfText = $request->query('pdfText', ''); // Get the PDF text from the query string
    $perPage = 5; // Number of questions per page

    try {
        // Use OpenAI API to generate questions
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Generate $perPage multiple-choice questions based on the following text. Each question should have 4 choices, with one correct answer. Format the response as a valid JSON array of objects, where each object has the following structure:
                    {
                        'question': 'The question text',
                        'choices': ['Choice 1', 'Choice 2', 'Choice 3', 'Choice 4'],
                        'correct_answer': 'The correct choice'
                    }\n\n$pdfText\n\nReturn only the JSON array, without any additional text or explanations."
                ]
            ],
            'max_tokens' => 500, // Adjust tokens as needed
            'temperature' => 0.7,
        ]);

        // Extract the JSON from the OpenAI response
        $responseContent = $response['choices'][0]['message']['content'];

        // Remove Markdown code block syntax (```json and ```)
        $jsonString = preg_replace('/```json|```/', '', $responseContent);

        // Decode the JSON string
        $questions = json_decode($jsonString, true);

        // Validate the extracted questions
        if (!is_array($questions)) {
            return response()->json(['error' => 'Invalid questions format'], 500);
        }

        // Return the questions as a JSON response
        return response()->json([
            'questions' => $questions
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
