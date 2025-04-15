<?php

namespace App\Http\Controllers\Admin;

use App\Models\Clinica;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClinicaController extends Controller
{
    // Método para listar clínicas com busca e paginação
    public function index(Request $request)
    {
        $query = Clinica::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                  ->orWhere('cnpj_cpf', 'like', "%{$search}%")
                  ->orWhere('cidade', 'like', "%{$search}%");
            });
        }

        // Paginação e anexação dos parâmetros da query
        $clinicas = $query->paginate(30)->appends($request->query());

        // Verifica se a requisição é AJAX
        if ($request->ajax()) {
            return view('admin.sub-diretorios.clinicas.index', compact('clinicas'))->render();
        }

        // Retorna a view com os dados
        return view('admin.sub-diretorios.clinicas.index', compact('clinicas'));
    }

    // Método para exibir o formulário de edição de uma clínica
    public function edit($id)
    {
        $clinica = Clinica::findOrFail($id);
        return view('admin.sub-diretorios.clinicas.edit', compact('clinica'));
    }

    // Método para atualizar os dados de uma clínica
    public function update(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);

        // Validação dos dados
        $validatedData = $request->validate([
            'razao_social' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'cnpj_cpf' => 'nullable|string|unique:clinicas,cnpj_cpf,' . $id,
            'email' => 'nullable|email|unique:clinicas,email,' . $id,
            'nome_fantasia' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:10',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:2',
            'email_administrativo' => 'nullable|email|max:255',
            'email_faturamento' => 'nullable|email|max:255',
            'telefone_local' => 'nullable|string|max:15',
            'telefone_financeiro' => 'nullable|string|max:15',
            'celular' => 'nullable|string|max:15',
            'responsavel_nome' => 'nullable|string|max:255',
            'rg' => 'nullable|string|max:20',
            'orgao_emissor' => 'nullable|string|max:20',
            'data_emissao' => 'nullable|date',
            'cpf' => 'nullable|string|max:14',
            'estado_civil' => 'nullable|string|max:20',
            'porcentagem_lucro' => 'nullable|numeric',
            'valor_fixo_lucro' => 'nullable|numeric',
            'wallet_id' => 'nullable|string|max:255',
        ]);
            //Informacoes de taxa
            //


            //Atualizar senha.
            // Verifica se foi fornecida uma nova senha
            if ($request->has('password') && !empty($request->password)) {
                // Atualiza a senha, com hash de segurança
                $validatedData['password'] = bcrypt($request->password);
            } else {
                // Se não foi fornecida senha, não altere o campo 'password'
                unset($validatedData['password']);
            }
            
            
        // Atualiza os dados
        //$clinica->update($request->all());
        // Atualiza os dados apenas com os dados validados
        $clinica->update($validatedData);

        return redirect()->route('admin.clinicas.index')->with('success', 'Clínica atualizada com sucesso!');
    }

    // Método para exibir os detalhes de uma clínica
    public function show($id)
    {
        $clinica = Clinica::findOrFail($id);
        return view('admin.sub-diretorios.clinicas.show', compact('clinica'));
    }

    // Método para deletar uma clínica
    public function destroy($id)
    {
        $clinica = Clinica::findOrFail($id);
        $clinica->delete();

        return redirect()->route('admin.clinicas.index')->with('success', 'Clínica deletada com sucesso!');
    }

    // Método para exibir o formulário de cadastro de uma nova clínica
    public function create()
    {
        return view('admin.sub-diretorios.clinicas.create');
    }

    // Método para listar solicitações de cadastro com status "pendente"
    public function solicitacoes_de_cadastro(Request $request)
    {
        $clinicas = Clinica::where('status', 'pendente')->paginate(10);
        return view('admin.sub-diretorios.clinicas.solicitacoes-de-cadastro.solicitacoes-de-cadastro', compact('clinicas'));
    }

    // Método para analisar e aprovar/negar solicitações de cadastro
    public function analise(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);

        if ($request->isMethod('post')) {
            $acao = $request->input('acao');

            if ($acao === 'aprovar') {
                $clinica->status = 'aprovado';
            } elseif ($acao === 'negar') {
                $clinica->status = 'negado';
            }

            $clinica->save();
            return redirect()->route('admin.clinicas.solicitacoes')->with('success', 'Status atualizado com sucesso!');
        }

        return view('admin.sub-diretorios.clinicas.solicitacoes-de-cadastro.analise', compact('clinica'));
    }

    // Método para download de documentos
    public function download($id)
    {
        $clinica = Clinica::findOrFail($id);
        $documentoPath = $clinica->documentos;

        if (!Storage::disk('private')->exists($documentoPath)) {
            return response()->json(['message' => 'Arquivo não encontrado'], 404);
        }
        
        return Storage::disk('private')->download($documentoPath);
    }
}