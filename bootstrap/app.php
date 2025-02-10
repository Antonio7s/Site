<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException; // Adicione esta importação
use Illuminate\Support\Arr;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(
            guests: '/login', // Rota para onde os convidados (não autenticados) são redirecionados
            users: function ($request) {
                // Verifica se o usuário está autenticado pelo guard 'clinic'
                if (Auth::guard('clinic')->check()) {
                    return route('admin-clinica'); // Redireciona para '/dashboard2' se autenticado pelo guard 'clinic'
                }
                // Redireciona para a rota padrão de index para outros guards
                return route('profile.edit');
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            $guards = $e->guards();
            
            // Pega o primeiro guard ou usa null
            $guard = Arr::first($guards);

            // Define a rota com base no guard
            $loginRoute = match($guard) {
                'clinic' => 'login2', // Nome da rota para clínicas
                default  => 'login'   // Rota padrão
            };

            return $request->expectsJson()
                ? response()->json(['message' => $e->getMessage()], 401)
                : redirect()->guest(route($loginRoute));
        });
    })->create();