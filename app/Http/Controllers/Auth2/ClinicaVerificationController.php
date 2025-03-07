<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
//use App\Http\Requests\EmailVerificationRequest; // Importando o request personalizado
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\EmailVerificationRequest; // Importação corrigida

class ClinicaVerificationController extends Controller
{
    /**
     * Show the email verification notification.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Retorna a view para verificação de email
        return view('auth2.verify-email'); // Certifique-se de ter uma view para isso
    }

    /**
     * Handle the email verification process.
     *
     * @param  \App\Http\Requests\EmailVerificationRequest  $request
     * @param  string  $id
     * @param  string  $hash
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(EmailVerificationRequest $request, $id, $hash)
    {
        $user = Auth::guard('clinic')->user();

        // Verifica se o usuário está autenticado
        if (!$user) {
            return redirect()->route('clinica.verification.notice')
                ->withErrors(['error' => 'Usuário não autenticado']);
        }

        // Verifica se o ID corresponde ao usuário autenticado
        if (! hash_equals((string) $user->getKey(), (string) $id)) {
            return redirect()->route('clinica.verification.notice')
                ->withErrors(['error' => 'Link de verificação inválido.']);
        }

        // Verifica se o hash corresponde ao email do usuário
        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return redirect()->route('clinica.verification.notice')
                ->withErrors(['error' => 'Link de verificação inválido.']);
        }

        // Se o e-mail ainda não foi verificado, marca como verificado
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        // Redireciona para o dashboard
        return redirect()->route('admin-clinica.dashboard.index');
    }

    /**
     * Resend the verification email notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        // Resend logic
        $request->user('clinic')->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
