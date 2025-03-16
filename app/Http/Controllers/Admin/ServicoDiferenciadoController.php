<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\ServicoDiferenciado;
use App\Models\Procedimento;
use Exception;

class ServicoDiferenciadoController extends Controller
{
    public function index()
    {
        // Carrega as clínicas com os serviços diferenciados e o procedimento vinculado
        $clinicas = Clinica::with('servicosDiferenciados.procedimento')->get();

        // Para cada clínica, atribui a lista de serviços diferenciados (caso não haja, ficará vazia)
        foreach ($clinicas as $clinica) {
            $clinica->listaServicos = $clinica->servicosDiferenciados;
        }

        return view('admin.sub-diretorios.servicos-diferenciados.index', compact('clinicas'));
    }
    
    public function create()
    {
        // Obtém os dados necessários para o cadastro
        $clinicas = \App\Models\Clinica::all();
        $procedimentos = \App\Models\Procedimento::all();

        return view('admin.sub-diretorios.servicos-diferenciados.create', compact('clinicas', 'procedimentos'));
    }

       // Armazena um novo registro
       public function store(Request $request)
       {
           // Validação dos dados recebidos
           $validated = $request->validate([
               'clinica_id'      => 'required|exists:clinicas,id',
               'dataInicial'     => 'required|date',
               'dataFinal'       => 'nullable|date',
               'procedimento_id' => 'required|exists:procedimentos,id',
               'preco_customizado' => 'required|numeric',
           ]);
   
           // Cria o novo serviço diferenciado
           ServicoDiferenciado::create([
               'clinica_id'      => $validated['clinica_id'],
               'data_inicial'    => $validated['dataInicial'],
               'data_final'      => $validated['dataFinal'],
               'procedimento_id' => $validated['procedimento_id'],
               'preco_customizado'           => $validated['preco_customizado'],
           ]);
   
           return redirect()->route('admin.servicos-diferenciados.index')
                            ->with('success', 'Serviço Diferenciado criado com sucesso!');
       }

       public function edit($id)
       {
           $servico = ServicoDiferenciado::findOrFail($id);
           $clinicas = Clinica::all();
           $procedimentos = Procedimento::all();
   
           return view('admin.sub-diretorios.servicos-diferenciados.edit', compact('servico', 'clinicas', 'procedimentos'));
       }
   
       public function update(Request $request, $id)
       {
           // Validação com os nomes dos campos do formulário (camelCase)
           $validated = $request->validate([
               'clinica_id' => 'required|exists:clinicas,id',
               'dataInicial' => 'required|date',
               'dataFinal' => 'nullable|date',
               'procedimento_id' => 'required|exists:procedimentos,id',
               'preco_customizado' => 'required|numeric|min:0' // Campo correto (nome do input do formulário)
           ]);
       
           // Busca o serviço
           $servico = ServicoDiferenciado::findOrFail($id);
       
           // Atualiza os campos mapeando para os nomes corretos do banco de dados (snake_case)
           $servico->update([
               'clinica_id' => $validated['clinica_id'],
               'data_inicial' => $validated['dataInicial'],
               'data_final' => $validated['dataFinal'],
               'procedimento_id' => $validated['procedimento_id'],
               'preco_customizado' => $validated['preco_customizado']
           ]);
       
           return redirect()->route('admin.servicos-diferenciados.index')
                            ->with('success', 'Serviço atualizado com sucesso!');
       }
   
       public function destroy($id)
       {
           $servico = ServicoDiferenciado::findOrFail($id);
           $servico->delete();
   
           return redirect()->route('admin.servicos-diferenciados.index')->with('success', 'Serviço excluído com sucesso!');
       }
}
