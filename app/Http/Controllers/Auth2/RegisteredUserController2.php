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
            'documentos'     => 'required|file|mimes:pdf|max:2048',

            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'cnpj_cpf' => 'required|string|unique:clinicas,cnpj_cpf',
            'telefone' => 'required|string|max:20',
            'cep' => 'required|string|max:9',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
            'email_administrativo' => 'required|email',
            'email_faturamento' => 'required|email',
            'telefone_local' => 'required|string|max:20',
            'telefone_financeiro' => 'required|string|max:20',
            'celular' => 'required|string|max:20',
            'responsavel_nome' => 'required|string|max:255',
            'rg' => 'required|string|max:20',
            'orgao_emissor' => 'required|string|max:50',
            'data_emissao' => 'required|date_format:d/m/Y',
            'cpf' => 'required|string|max:14|unique:users,cpf',
            'estado_civil' => 'required|string|max:50',
        ]);

        $documentoPath = null;
        if ($request->hasFile('documentos')) {
            $file = $request->file('documentos');
            // Gera um nome único para o arquivo
            $nomeArquivo = time() . '_' . $file->getClientOriginalName();
            // Armazena o arquivo no disco 'private' dentro da pasta 'uploads/documentos'
            $documentoPath = $file->storeAs('uploads/documentos', $nomeArquivo, 'private');
        }

        $clinica = Clinica::create([
            'razao_social' => $request->razao_social,
            'nome_fantasia' => $request->nome_fantasia,  // Nome Fantasia
            'cnpj_cpf' => $request->cnpj_cpf,  // CNPJ/CPF
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'documentos'     => $documentoPath, // Salva o caminho do arquivo PDF
        ]);

        event(new Registered($clinica));

        Auth::guard('clinic')->login($clinica);


        return redirect(route('admin-clinica.dashboard.index', absolute: false));
    }
}
