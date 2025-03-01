<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Add your API route group here
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => CheckUserRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
