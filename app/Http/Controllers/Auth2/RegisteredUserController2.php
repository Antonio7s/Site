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
use Carbon\Carbon;

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
            // Validação dos campos
            'razao_social'         => ['required', 'string', 'max:255', 'unique:clinicas,razao_social'],
            'nome_fantasia'        => ['required', 'string', 'max:255'],
            'cnpj_cpf'             => ['required', 'string', 'max:18', 'unique:clinicas,cnpj_cpf'],
            'email'                => ['required', 'string', 'email', 'max:255', 'unique:clinicas,email'],
            'password'             => ['required', 'confirmed', Rules\Password::defaults()],
            'documentos'           => 'required|file|mimes:pdf|max:2048',

            // Dados de endereço e contato
            'telefone'             => 'required|string|max:20',
            'cep'                  => 'required|string|max:9',
            'endereco'             => 'required|string|max:255',
            'numero'               => 'required|string|max:10',
            'complemento'          => 'nullable|string|max:255',
            'bairro'               => 'required|string|max:255',
            'cidade'               => 'required|string|max:255',
            'uf'                   => 'required|string|max:2',

            // Contatos administrativos e financeiros
            'email_administrativo' => 'required|email|max:255',
            'email_faturamento'    => 'required|email|max:255',
            'telefone_local'       => 'required|string|max:20',
            'telefone_financeiro'  => 'required|string|max:20',
            'celular'              => 'required|string|max:20',

            // Dados do responsável pelo contrato
            'responsavel_nome'     => 'required|string|max:255',
            'rg'                   => 'required|string|max:20',
            'orgao_emissor'        => 'required|string|max:50',
            'data_emissao'         => 'required|date_format:d/m/Y',
            'cpf'                  => 'required|string|max:14', // Mapeado para responsavel_cpf
            'estado_civil'         => 'required|string|max:50',
        ]);

        // Processa o upload do documento (PDF)
        $documentoPath = null;
        if ($request->hasFile('documentos')) {
            $file = $request->file('documentos');
            $nomeArquivo = time() . '_' . $file->getClientOriginalName();
            $documentoPath = $file->storeAs('uploads/documentos', $nomeArquivo, 'private');
        }

        // Converte a data de emissão do formato d/m/Y para Y-m-d
        $dataEmissao = \Carbon\Carbon::createFromFormat('d/m/Y', $request->data_emissao)->format('Y-m-d');

        try {
            // Tenta criar a clínica com todos os campos
            $clinica = Clinica::create([
                'razao_social'         => $request->razao_social,
                'nome_fantasia'        => $request->nome_fantasia,
                'cnpj_cpf'             => $request->cnpj_cpf,
                'email'                => $request->email,
                'password'             => Hash::make($request->password),
                'documentos'           => $documentoPath,
                'telefone'             => $request->telefone,
                'cep'                  => $request->cep,
                'endereco'             => $request->endereco,
                'numero'               => $request->numero,
                'complemento'          => $request->complemento,
                'bairro'               => $request->bairro,
                'cidade'               => $request->cidade,
                'uf'                   => $request->uf,
                'email_administrativo' => $request->email_administrativo,
                'email_faturamento'    => $request->email_faturamento,
                'telefone_local'       => $request->telefone_local,
                'telefone_financeiro'  => $request->telefone_financeiro,
                'celular'              => $request->celular,
                'responsavel_nome'     => $request->responsavel_nome,
                'rg'                   => $request->rg,
                'orgao_emissor'        => $request->orgao_emissor,
                'data_emissao'         => $dataEmissao,
                'responsavel_cpf'      => $request->cpf,
                'estado_civil'         => $request->estado_civil,
                'porcentagem_lucro'    => 99,   // Valor padrão para a clinica
                'valor_fixo_lucro'     => 1,   // Valor padrão
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            // Verifica se o erro é de violação de unicidade para o campo 'razao_social'
            if (strpos($ex->getMessage(), 'clinicas.razao_social') !== false) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'razao_social' => 'Já existe uma clínica com essa Razão Social. Por favor, escolha outra.',
                    ]);
            }
            throw $ex;
        }

        event(new Registered($clinica));
        Auth::guard('clinic')->login($clinica);

        return redirect(route('admin-clinica.dashboard.index', [], false));
    }
}
