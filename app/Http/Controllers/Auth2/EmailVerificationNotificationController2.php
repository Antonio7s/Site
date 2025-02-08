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
        if ($request->clinica()->hasVerifiedEmail()) {
            return redirect()->intended(route('admin-clinica', absolute: false));
        }

        $request->clinica()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
