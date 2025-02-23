<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Auth::routes();

// Dashboard route (default for authenticated users)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin routes (administration section)
Route::middleware(['auth', 'role:admin'])->prefix('dashboard/administration')->group(function () {
    Route::get('/', function () {
        return view('admin.index'); // Return the admin index view
    })->name('dashboard.administration');

    Route::resource('users', UserController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('faculties', FacultyController::class);
    Route::resource('universities', UniversityController::class);
});

// Questions routes (questions section)
Route::middleware(['auth'])->prefix('dashboard/questions')->group(function () {
    Route::get('/', function () {
        return view('questions.index'); // Return the questions index view
    })->name('dashboard.questions');
});

// Questions routes (questions section)
Route::middleware(['auth'])->prefix('dashboard/exams')->group(function () {
    Route::get('/', function () {
        return view('exams.index'); // Return the questions index view
    })->name('dashboard.exams');
});

// Fallback route for 404 errors
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
