<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth2\LoginRequest2;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController2 extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Auth2.login'); // caminho da view
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest2 $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('admin-clinica', absolute: false));
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
