<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::paginate(10);

        return view('/admin/sub-diretorios/classes/index', compact('classes'));
    }

    public function create()
    {
        return view('admin.sub-diretorios.classes.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Cria no banco
        Classe::create([
            'nome' => $request->nome,
        ]);

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('admin.classes.index')
                        ->with('success', 'Classe cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $classe = Classe::findOrFail($id); // Busca pelo ID
        return view('admin.sub-diretorios.classes.edit', compact('classe'));
    }

    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);

        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Atualiza os dados
        $classe->update($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Classe atualizada com sucesso!');
    }

    public function show($id)
    {
        $classe = Classe::findOrFail($id);
        return view('admin.sub-diretorios.classes.show', compact('classe'));
    }

    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Classe deletada com sucesso!');
    }
}
