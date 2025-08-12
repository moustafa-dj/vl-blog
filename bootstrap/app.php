<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api:__DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function(){
            Route::middleware('api')
            ->prefix('api/v1/user')
            ->name('api.v1.user')
            ->group(base_path('routes/api/user/index.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function (Illuminate\Http\Request $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            return route('login.index');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'exception' => class_basename($e),
                ],500);
            }

            // Let Laravel handle web exceptions normally
            return null;
        });

        $exceptions->render(function(ValidationException $e , Illuminate\Http\Request $request){
            return response()->json([
                'erros' => $e->errors()
            ],$e->status);
        });
        
    })->create();
