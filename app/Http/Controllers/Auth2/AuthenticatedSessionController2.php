<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth2\LoginRequest2;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Clinica;

class AuthenticatedSessionController2 extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth2.login'); // caminho da view
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest2 $request): RedirectResponse
    {
        // Realiza a autenticação com a guard 'clinic'
        $request->authenticate();

        // Regenera a sessão
        $request->session()->regenerate();

        // Verifique se o usuário está autenticado na guard 'clinic'
        $user = Auth::guard('clinic')->user();

        // // Verifique se o e-mail do usuário está verificado
        // if ($user && !$user->hasVerifiedEmail()) {
        //     return redirect()->route('clinica.verification.notice'); // Rota de verificação de e-mail da clínica
        // }

        // Caso o e-mail esteja verificado, redirecione para o painel administrativo da clínica
        return redirect()->route('admin-clinica.dashboard.index');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('clinic')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

