<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenAIController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/rephrase', [OpenAIController::class, 'rephrase']);
Route::post('/generate', [OpenAIController::class, 'generateQuestions']);
Route::get('/generate', [OpenAIController::class, 'loadMoreQuestions']);
Route::get('/clear', [OpenAIController::class, 'clearFile']);
