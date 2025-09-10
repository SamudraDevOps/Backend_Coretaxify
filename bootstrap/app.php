<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'account.type' => \App\Http\Middleware\CheckAccountType::class,
            'account.representation' => \App\Http\Middleware\CheckRepresentation::class,
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthenticated',
                    'status' => 401
                ], 401);
            }
        });

        // Handle domain/business logic errors
        $exceptions->render(function (\DomainException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'status' => 422
                ], 422);
            }
        });
        //
    })->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(
            '*',
            SymfonyRequest::HEADER_X_FORWARDED_FOR
            | SymfonyRequest::HEADER_X_FORWARDED_HOST
            | SymfonyRequest::HEADER_X_FORWARDED_PORT
            | SymfonyRequest::HEADER_X_FORWARDED_PROTO
        );
    })->create();
