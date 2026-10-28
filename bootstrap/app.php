<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Usuario ya autenticado que entra al login -> va al dashboard
        $middleware->redirectUsersTo(fn () => route('dashboard.index'));

        // Usuario sin sesión que entra a una ruta protegida -> va al login
        $middleware->redirectGuestsTo(fn () => route('login'));

        // Alias para evitar almacenamiento en caché de páginas privadas
        $middleware->alias([
            'nocache' => \App\Http\Middleware\Seguridad\NoCacheHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();