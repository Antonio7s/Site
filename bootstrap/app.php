<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use Closure;

/**
 * Middleware que verifica se o usuário (clinica) possui status "aprovado".
 */
class CheckClinicaStatus
{
    public function handle(Request $request, Closure $next)
    {
        //Auth::guard('clinic')->user()->status;
        $clinica = Auth::guard('clinic')->user(); // Obtém a clínica autenticada

        $status = $clinica->status;

        // Verifica o status e redireciona para a rota correspondente
        switch ($status) {
            case 'pendente':
                // Redireciona para uma página informando que a clínica está pendente de aprovação
                return redirect()->route('clinica.pendente');
            case 'parcial':
                // Redireciona para uma página que indica acesso negado.
                return redirect()->route('clinica.negado');
            case 'aprovado':
                // Se estiver aprovado, permite o acesso normalmente
                return $next($request);
            default:
                // Opcional: redireciona para uma página de erro ou logout
                return redirect()->route('login');
        }
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(
            guests: '/login', // Rota para convidados (não autenticados)
            users: function ($request) {
                // Se o usuário estiver autenticado com o guard 'clinic'
                if (Auth::guard('clinic')->check()) {
                    return route('admin-clinica.dashboard.index');
                }
                // Rota padrão para outros guards
                return route('perfil.edit');
            }
        );

        // Registra o middleware customizado com um alias
        $middleware->alias([
            'check.clinica.status' => CheckClinicaStatus::class,
        ]);

        // Se desejar que ele seja aplicado globalmente, pode usá-lo com:
        // $middleware->append(CheckClinicaStatus::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            $guards = $e->guards();
            $guard = Arr::first($guards);
            $loginRoute = match($guard) {
                'clinic' => 'login2', // Rota para clínicas
                default  => 'login'   // Rota padrão
            };

            return $request->expectsJson()
                ? response()->json(['message' => $e->getMessage()], 401)
                : redirect()->guest(route($loginRoute));
        });
    })->create();
