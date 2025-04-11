<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telefone' => ['required', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            //telefone, cpf
        ]);

        $telefone = preg_replace('/\D/', '', $request->telefone); // Remove tudo que não é número
        //$cpf = preg_replace('/\D/', '', $request->cpf); // Remove pontos e traços

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'telefone' => $telefone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('perfil.edit', absolute: false));
    }
}
