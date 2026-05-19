<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Setup / Installation Routes (wizard চালানোর জন্য)
            Route::middleware('web')
                ->group(base_path('routes/setup.php'));

            // Admin Panel Routes
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin'      => \App\Http\Middleware\IsAdmin::class,
            'check_install' => \App\Http\Middleware\CheckInstallation::class,
        ]);

        // সব web request-এ installation check চালানো হবে
        $middleware->web(append: [
            \App\Http\Middleware\CheckInstallation::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
