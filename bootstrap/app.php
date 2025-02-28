<?php

use App\Http\Middleware\CheckClinicaStatus;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(
            guests: '/login',
            users: function ($request) {
                if (Auth::guard('clinic')->check()) {
                    return route('admin-clinica.dashboard.index');
                }
                return route('perfil.edit');
            }
        );

        // Registra o middleware customizado com um alias
        $middleware->alias([
            'check.clinica.status' => CheckClinicaStatus::class,
        ]);

        // Exclui a rota '/asaas/webhook' da verificação CSRF
        $middleware->validateCsrfTokens(except: [
            'asaas/webhook',
        ]);

        // Caso queira aplicar globalmente:
        // $middleware->append(CheckClinicaStatus::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            $guards = $e->guards();
            $guard  = Arr::first($guards);
            $loginRoute = match($guard) {
                'clinic' => 'login2',
                default  => 'login'
            };

            return $request->expectsJson()
                ? response()->json(['message' => $e->getMessage()], 401)
                : redirect()->guest(route($loginRoute));
        });
    })->create();
