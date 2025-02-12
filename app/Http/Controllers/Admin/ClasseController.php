<?php

namespace App\Http\Controllers\Admin;

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
            'classe' => 'required|string|max:255',
        ]);

        // Cria no banco
        Classe::create([
            'classe' => $request->classe,
        ]);

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('classes.index')
                        ->with('success', 'Classe cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $classe = Classe::findOrFail($id); // Busca pelo ID
        return view('admin.sub-diretorios.classes.edit', compact('classe'));
    }

    public function update(Request $request, $id)
    {
        $clinica = Clinica::findOrFail($id);

        // Validação dos dados
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'cnpj_cpf' => 'required|string|unique:clinicas,cnpj_cpf,' . $id,
            'email' => 'required|email|unique:clinicas,email,' . $id,
        ]);

        // Atualiza os dados
        $classe->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Clínica atualizada com sucesso!');
    }

    public function show($id)
    {
        $clinica = Clinica::findOrFail($id);
        return view('admin.sub-diretorios.classes.show', compact('classe'));
    }

    public function destroy($id)
    {
        $clinica = Clinica::findOrFail($id);
        $clinica->delete();

        return redirect()->route('clinicas.index')->with('success', 'Clínica deletada com sucesso!');
    }
}
