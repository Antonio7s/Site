<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController2 extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->clinica()->hasVerifiedEmail()
                    ? redirect()->intended(route('admin-clinica', absolute: false))
                    : view('auth2.verify-email');
    }
}
