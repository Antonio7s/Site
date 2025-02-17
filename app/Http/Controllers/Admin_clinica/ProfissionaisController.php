<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//models
use App\Models\Medico;

class ProfissionaisController extends Controller
{

    public function index(Request $request)
    {
        $profissionais = Medico::paginate(20);

        return view('admin-clinica.profissionais-associados.index', compact('profissionais'));
    }

    public function create()
    {
        return view('admin-clinica.profissionais-associados.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'id_clinica' => 'required|exists:clinicas,id', // Verifica se a clínica existe
            'primeiro_nome' => 'required|string|max:255',
            'segundo_nome' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048', // Validar a foto como uma imagem e com tamanho máximo de 2MB
            'email' => 'required|email|unique:medicos,email', // Validar email único para médicos
            'crm' => 'required|string|unique:medicos,crm', // Validar CRM único
        ]);

        // Cria a especialidade no banco
        Medico::create([
            'id_clinica' => $validated['id_clinica'],
            'primeiro_nome' => $validated['primeiro_nome'],
            'segundo_nome' => $validated['segundo_nome'] ?? null,
            'foto' => $request->hasFile('foto') ? $request->file('foto')->store('fotos_medicos') : null,
            'email' => $validated['email'],
            'crm' => $validated['crm'],
        ]);

        // Redireciona para a lista de especialidades com mensagem de sucesso
        return redirect()->route('clinica-admin.profissionais-associados.index')
                        ->with('success', 'Profissional cadastrado com sucesso!');
    }

    // Exibe os detalhes de um profissional
    public function show($id)
    {
        $profissional = Medico::findOrFail($id);
        return view('show', compact('profissional'));
    }

    // Exibe o formulário para editar um profissional
    public function edit($id)
    {
        $profissional = Medico::findOrFail($id);
        return view('.edit', compact('profissional'));
    }

    // Atualiza os dados do profissional
    public function update(Request $request, $id)
    {
        $especialidade = Medico::findOrFail($id);

        // Validação dos dados enviados
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Atualiza o profissional
        $profissional->update([
            'nome' => $request->nome,
        ]);

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('clinica-admin.profissionais-associados.index')
                         ->with('success', 'Profissional atualizado com sucesso!');
    }

    // Exclui uma especialidade
    public function destroy($id)
    {
        $profissional = Medico::findOrFail($id);
        $profissional->delete();

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('clinica-admin.profissionais-associados.index')
                         ->with('success', 'Profissional removido com sucesso!');
    }
}
