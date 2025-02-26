<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception, $request) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Validation error',
                    'errors' => $exception->errors(),
                ], 422);
            }

            if ($exception instanceof HttpException) {
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage() ?: 'HTTP error',
                ], $exception->getStatusCode());
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
                'exception' => get_class($exception),
                'details' => $exception->getMessage(),
            ], 500);
        });
    })->create();
