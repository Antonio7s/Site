<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckClinicaStatus
{
    public function handle(Request $request, Closure $next)
    {
        $clinica = Auth::guard('clinic')->user();
        $status  = $clinica->status;

        switch ($status) {
            case 'pendente':
                return redirect()->route('clinica.pendente');
            case 'parcial':
                return redirect()->route('clinica.negado');
            case 'aprovado':
                return $next($request);
            default:
                return redirect()->route('login');
        }
    }
}
