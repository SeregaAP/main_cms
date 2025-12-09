<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LoadLocaleFromSettings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            LoadLocaleFromSettings::class, // 👈 добавляем сюда
            
        ]);
    
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class, // ← правильный класс
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
