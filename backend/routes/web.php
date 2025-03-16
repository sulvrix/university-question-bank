<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;

// Public routes
Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Authentication routes (disable registration and enable email verification)
Auth::routes(['register' => false, 'verify' => true]);

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Dashboard route (default for authenticated users)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Administration routes
    Route::prefix('dashboard/administration')->group(function () {
        // Allow both admin and staff to access the dashboard
        Route::get('/', function () {
            return view('admin.index'); // Return the admin index view
        })->name('dashboard.administration');

        // Routes accessible only to admin
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class);
            Route::resource('departments', DepartmentController::class);
            Route::resource('faculties', FacultyController::class);
            Route::resource('universities', UniversityController::class);
        });

        // Routes accessible to both admin and staff
        Route::middleware('role:admin,staff')->group(function () {
            Route::resource('subjects', SubjectController::class);
        });
    });

    // Questions and Exams routes
    Route::prefix('dashboard')->group(function () {
        // Questions routes
        Route::middleware('role:teacher,commissioner,staff,admin')->group(function () {
            Route::get('questions/generate', [QuestionController::class, 'generate'])->name('questions.generate');
            Route::resource('questions', QuestionController::class)->names([
                'index' => 'dashboard.questions', // Customize the route name
            ]);
        });

        // Exams routes
        Route::middleware('role:commissioner,staff,admin')->group(function () {
            Route::resource('exams', ExamController::class)->names([
                'index' => 'dashboard.exams', // Customize the route name
            ]);
        });
    });
});

// Fallback route for 404 errors
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
