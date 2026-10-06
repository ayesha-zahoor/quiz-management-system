<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        'system.admin' => \App\Http\Middleware\SystemAdminMiddleware::class,
         'institute.admin' => \App\Http\Middleware\InstituteAdminMiddleware::class,
          'teacher' => \App\Http\Middleware\TeacherMiddleware::class,
           'student' => \App\Http\Middleware\StudentMiddleware::class,
    ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
