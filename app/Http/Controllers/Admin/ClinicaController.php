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
            'cnpj_cpf' => 'required|string|unique:clinicas,cnpj_cpf,' . $id,
            'email' => 'required|email|unique:clinicas,email,' . $id,
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


}
