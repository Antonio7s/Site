<?php

namespace App\Http\Controllers\Admin;
use App\Models\Clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClinicaController extends Controller
{
    public function index(Request $request)
    {
        // Usando paginação: exibe 10 registros por página
        $clinicas = Clinica::paginate(10);

        // Se precisar de filtros, você pode pegar os parâmetros de $request aqui e ajustar a query

        // Retorna a view, passando a variável com os dados paginados
        return view('/admin/sub-diretorios/clinicas/index', compact('clinicas'));
    }

    public function edit($id)
    {
        $clinica = Clinica::findOrFail($id); // Busca a clínica pelo ID
        return view('admin.sub-diretorios.clinicas.edit', compact('clinica'));
    }

    public function update(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);

        // Validação dos dados
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'cnpj_cpf' => 'nullable|string|unique:clinicas,cnpj_cpf,' . $id,
            'email' => 'nullable|email|unique:clinicas,email,' . $id,
            'nome_fantasia' => 'nullable|string|max:255',
            'cep' => 'nullable|string|max:10', // Formato: 00000-000
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
            /*
            'banco' => 'required|string|max:255',
            'numero_banco' => 'required|string|max:4',
            'agencia' => 'required|string|max:10',
            'conta_corrente' => 'required|string|max:20',
            'titular_conta' => 'required|string|max:255',
            'cpf_titular' => 'required|string|max:14',
            */
        ]);

        // Atualiza os dados
        $clinica->update($request->all());

        return redirect()->route('admin.clinicas.index')->with('success', 'Clínica atualizada com sucesso!');
    }

    public function show($id)
    {
        $clinica = Clinica::findOrFail($id);
        return view('admin.sub-diretorios.clinicas.show', compact('clinica'));
    }

    public function destroy($id)
    {
        $clinica = Clinica::findOrFail($id);
        $clinica->delete();

        return redirect()->route('admin.clinicas.index')->with('success', 'Clínica deletada com sucesso!');
    }


    /*
    // ANALISE DA CLÍNICA
    */

    public function create() // CADASTRAR UMA NOVA CLÍNICA
    {
        return view('admin.sub-diretorios.clinicas.create');
    }

    //exibir todas as clínicas com status == pendente
    public function solicitacoes_de_cadastro(Request $request)
    {
        $clinicas = Clinica::where('status', 'pendente')->paginate(10);
        return view('admin.sub-diretorios.clinicas.solicitacoes-de-cadastro.solicitacoes-de-cadastro', compact('clinicas'));
    }

    public function analise(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);
    
        // Verifica se a requisição é POST e se há uma ação definida
        if ($request->isMethod('post')) {
            if ($request->input('acao') === 'aprovar') {
                $clinica->status = 'aprovado';
            } elseif ($request->input('acao') === 'negar') {
                $clinica->status = 'negado';
            }
    
            $clinica->save();
            //return redirect()->back()->with('success', 'Status atualizado com sucesso!');
            return redirect()->route('admin.clinicas.solicitacoes')->with('success', 'Status atualizado com sucesso!');

        }
    
        return view('admin.sub-diretorios.clinicas.solicitacoes-de-cadastro.analise', compact('clinica'));
    }
    
}
