<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;
use illuminate\Support\Facades\Log;

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
