<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Procedimento;
use App\Models\Classe;

class ProcedimentoController extends Controller
{
    public function index(Request $request)
    {
        // Verifica se há um termo de pesquisa na requisição
        $search = $request->input('search');

        // Filtra os procedimentos com base no termo de pesquisa
        $procedimentos = Procedimento::when($search, function ($query, $search) {
            return $query->where('nome', 'like', '%' . $search . '%')
                         ->orWhereHas('classe', function ($query) use ($search) {
                             $query->where('nome', 'like', '%' . $search . '%');
                         });
        })->paginate(10);

        // Mantém a lista de classes para uso no formulário de criação/edição
        $classes = Classe::all();

        return view('admin.sub-diretorios.procedimentos.index', compact('procedimentos', 'classes'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('admin.sub-diretorios.procedimentos.create', compact('classes'));
    }

    public function store(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'classe_id' => 'required|exists:classes,id' // Valida se o ID existe na tabela 'classes'
        ]);

        // Cria no banco
        Procedimento::create([
            'nome' => $request->nome,
            'valor' => $request->valor,
            'classe_id' => $request->classe_id,
        ]);

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('admin.procedimentos.index')
                        ->with('success', 'Procedimento cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $procedimento  = Procedimento::findOrFail($id); // Busca pelo ID
        $classes = Classe::all();
        return view('admin.sub-diretorios.procedimentos.edit', compact('procedimento','classes'));
    }

    public function update(Request $request, $id)
    {
        $procedimento = Procedimento::findOrFail($id);

        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'classe_id' => 'required|exists:classes,id' // Valida se o ID existe na tabela 'classes'
        ]);

        // Atualiza os dados
        $procedimento->update($request->all());

        return redirect()->route('admin.procedimentos.index')->with('success', 'Procedimento atualizada com sucesso!');
    }

    public function show($id)
    {
        $procedimento = Procedimento::findOrFail($id);
        return view('admin.sub-diretorios.procedimentos.show', compact('procedimento'));
    }

    public function destroy($id)
    {
        $procedimento = Procedimento::findOrFail($id); // Nome correto
        $procedimento->delete(); // Nome correto

        return redirect()->route('admin.procedimentos.index')->with('success', 'Procedimento deletada com sucesso!');
    }
}