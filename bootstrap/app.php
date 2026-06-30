<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role.redirect' => \App\Http\Middleware\RoleRedirect::class,
        'role' => \App\Http\Middleware\EnsureUserRole::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'profile.complete' => \App\Http\Middleware\EnsureProfileIsComplete::class,
    ]);

    $middleware->validateCsrfTokens(except: [
        'payment/notification',
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
