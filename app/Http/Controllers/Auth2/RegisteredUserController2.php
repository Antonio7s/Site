<?php

namespace App\Http\Controllers\Auth2;

use App\Http\Controllers\Controller;
use App\Models\Clinica;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController2 extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth2.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'razao_social' => ['required', 'string', 'max:255'],
            'nome_fantasia' => ['required', 'string', 'max:255'],  // Nome Fantasia
            'cnpj_cpf' => ['required', 'string', 'max:18', 'unique:clinicas'],  // CNPJ/CPF
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Clinica::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $clinica = Clinica::create([
            'razao_social' => $request->razao_social,
            'nome_fantasia' => $request->nome_fantasia,  // Nome Fantasia
            'cnpj_cpf' => $request->cnpj_cpf,  // CNPJ/CPF
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($clinica));

        Auth::guard('clinic')->login($clinica);


        return redirect(route('admin-clinica.dashboard.index', absolute: false));
    }
}
