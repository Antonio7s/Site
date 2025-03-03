<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query(); // Usando o modelo de usuários

        // Filtro de pesquisa por nome, CPF ou e-mail
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%") // Nome do usuário
                  ->orWhere('cpf', 'LIKE', "%{$search}%") // CPF do usuário
                  ->orWhere('email', 'LIKE', "%{$search}%"); // E-mail do usuário
            });
        }

        // Paginação com 30 registros por página e mantendo os filtros na URL
        $usuarios = $query->paginate(30)->appends($request->query());

        // Retornando a view correta (admin/sub-diretorios/usuarios/usuarios.blade.php)
        return view('admin.sub-diretorios.usuarios.usuarios', compact('usuarios'));
    }

    // Método para exibir o formulário de edição de um usuário
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.sub-diretorios.usuarios.edit', compact('user'));
    }

    // Método para atualizar os dados de um usuário
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'cpf' => 'nullable|string|unique:users,cpf,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
        ]);

        // Atualiza os dados
        $user->update($request->all());

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // Método para exibir os detalhes de um usuário
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.sub-diretorios.usuarios.show', compact('user'));
    }

    // Método para deletar um usuário
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário deletado com sucesso!');
    }

}