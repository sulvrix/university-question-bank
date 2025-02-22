<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        //users routes
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::get('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

        //departments routes
        Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
        Route::get('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');

        //faculties routes
        Route::get('/faculties/create', [FacultyController::class, 'create'])->name('faculties.create');
        Route::post('/faculties', [FacultyController::class, 'store'])->name('faculties.store');
        Route::get('faculties/{faculty}/edit', [FacultyController::class, 'edit'])->name('faculties.edit');
        Route::get('/faculties/{faculty}', [FacultyController::class, 'destroy'])->name('faculties.destroy');
        Route::put('/faculties/{faculty}', [FacultyController::class, 'update'])->name('faculties.update');
    });
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
});
