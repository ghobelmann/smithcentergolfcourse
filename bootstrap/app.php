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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\CheckSessionTimeout::class,
        ]);
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle CSRF token mismatch
        $exceptions->render(function (Illuminate\Session\TokenMismatchException $e, $request) {
            \Log::warning('CSRF Token Mismatch', [
                'url' => $request->url(),
                'user_id' => auth()->id(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your session has expired. Please log in again.',
                    'error' => 'csrf_token_mismatch',
                    'redirect' => route('login')
                ], 419);
            }

            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please log in again.')
                ->with('info', 'This may have happened due to inactivity or opening multiple tabs.');
        });

        // Handle authentication exceptions
        $exceptions->render(function (Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Authentication required.',
                    'error' => 'authentication_required',
                    'redirect' => route('login')
                ], 401);
            }

            return redirect()->route('login')
                ->with('error', 'Please log in to continue.');
        });

        // Handle session store exceptions
        $exceptions->render(function (Illuminate\Contracts\Encryption\DecryptException $e, $request) {
            if (str_contains($e->getMessage(), 'session') || str_contains($e->getMessage(), 'payload')) {
                \Log::warning('Session Decryption Error', [
                    'url' => $request->url(),
                    'user_agent' => $request->userAgent(),
                    'ip' => $request->ip()
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Session error. Please log in again.',
                        'error' => 'session_decrypt_error',
                        'redirect' => route('login')
                    ], 419);
                }

                return redirect()->route('login')
                    ->with('error', 'Session error. Please log in again.');
            }
        });
    })->create();
