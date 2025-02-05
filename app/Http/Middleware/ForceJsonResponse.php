<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        // Força a requisição a aceitar JSON
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
