<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController2 extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->clinica()->hasVerifiedEmail()) {
            return redirect()->intended(route('admin-clinica', absolute: false).'?verified=1');
        }

        if ($request->clinica()->markEmailAsVerified()) {
            event(new Verified($request->clinica()));
        }

        return redirect()->intended(route('admin-clinica', absolute: false).'?verified=1');
    }
}
