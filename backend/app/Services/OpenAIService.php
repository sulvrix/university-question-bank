<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class OpenAIService
{
    public function chat($prompt, $model = 'gpt-4o-mini', $maxTokens = 500, $temperature = 0.7)
    {
        try {
            $response = OpenAI::chat()->create([
                'model'    => $model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => $maxTokens,
                'temperature' => $temperature,
            ]);

            return $response['choices'][0]['message']['content'] ?? null;
        } catch (\Exception $e) {
            Log::error('OpenAI API error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function extractTextFromPDF($file)
    {
        try {
            // Ensure the file exists and is a valid PDF
            if (!$file || !$file->isValid() || $file->getClientOriginalExtension() !== 'pdf') {
                Log::error('Invalid or unsupported file', ['file' => $file]);
                return null;
            }

            // Get the file's temporary path
            $filePath = $file->getRealPath();

            // Ensure the file is readable
            if (!is_readable($filePath)) {
                Log::error('File is not readable', ['filePath' => $filePath]);
                return null;
            }

            // Parse the PDF and extract text
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            // Log the extracted text for debugging
            Log::info('PDF text extracted successfully', ['text' => $text]);

            return $text;
        } catch (\Exception $e) {
            Log::error('PDF text extraction error', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
