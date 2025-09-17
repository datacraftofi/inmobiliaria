<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',      // 👈 agrega el mapeo API
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias personalizados de middleware de ruta
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);

        // (Opcional) si creas tu propio VerifyCsrfToken y quieres excluir rutas, no es necesario tocar aquí.
        // Puedes seguir usando web.php con CSRF o api.php sin CSRF.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
