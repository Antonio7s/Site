<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt or redirect based on user role.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Verifica se o usuário tem o email verificado
        if ($request->user()->hasVerifiedEmail()) {
            // Verifica se o usuário é um admin e redireciona para o dashboard
            if (Auth::check() && $request->user()->access_level === 'admin') {
                return redirect()->route('admin.dashboard.admin');
            }

            // Se não for admin, redireciona para o perfil do usuário
            return redirect()->route('perfil.edit');
        }

        // Se o email não foi verificado, exibe a página de verificação de email
        return view('auth.verify-email');
    }
}
