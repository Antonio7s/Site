<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController2 extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // Use auth('clinic') para acessar o usuário autenticado da clínica
        $clinica = auth('clinic')->user();

        if ($clinica->hasVerifiedEmail()) {
            return redirect()->intended(route('admin-clinica.dashboard.index', absolute: false));
        }

        $clinica->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}

