<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        //users routes
        Route::prefix('dashboard')->group(function () {
            Route::resource('users', UserController::class);
        });

        //departments routes
        Route::prefix('dashboard')->group(function () {
            Route::resource('departments', DepartmentController::class);
        });

        //faculties routes
        Route::prefix('dashboard')->group(function () {
            Route::resource('faculties', FacultyController::class);
        });
    });
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
});
