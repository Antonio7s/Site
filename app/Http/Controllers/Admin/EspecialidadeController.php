<?php

namespace App\Http\Controllers\Admin;
use App\Models\Especialidade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    public function index(Request $request)
    {
        $especialidades = Especialidade::paginate(10);

        return view('admin.sub-diretorios.especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('admin.sub-diretorios.especialidades.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Cria a especialidade no banco
        Especialidade::create([
            'nome' => $request->nome,
        ]);

        // Redireciona para a lista de especialidades com mensagem de sucesso
        return redirect()->route('admin.especialidades.index')
                        ->with('success', 'Especialidade cadastrada com sucesso!');
    }

    // Exibe os detalhes de uma especialidade
    public function show($id)
    {
        $especialidade = Especialidade::findOrFail($id);
        return view('admin.sub-diretorios.especialidades.show', compact('especialidade'));
    }

    // Exibe o formulário para editar uma especialidade
    public function edit($id)
    {
        $especialidade = Especialidade::findOrFail($id);
        return view('admin.sub-diretorios.especialidades.edit', compact('especialidade'));
    }

    // Atualiza os dados da especialidade
    public function update(Request $request, $id)
    {
        $especialidade = Especialidade::findOrFail($id);

        // Validação dos dados enviados
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Atualiza a especialidade
        $especialidade->update([
            'nome' => $request->nome,
        ]);

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('admin.especialidades.index')
                         ->with('success', 'Especialidade atualizada com sucesso!');
    }

    // Exclui uma especialidade
    public function destroy($id)
    {
        $especialidade = Especialidade::findOrFail($id);
        $especialidade->delete();

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('admin.especialidades.index')
                         ->with('success', 'Especialidade removida com sucesso!');
    }


}
