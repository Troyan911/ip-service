<?php

use App\Exceptions\GeoServiceException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (
            AuthenticationException $e, $request
        ) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        });

        $exceptions->render(function (GeoServiceException $e, $request) {
            return response()->json([
                'message' => 'Geo service error',
                'error' => $e->getMessage(),
            ], 503);
        });

    })
    ->create();
