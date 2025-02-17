<?php

namespace App\Http\Controllers\Admin;

use App\Models\User; // Certifique-se de usar o modelo correto de usuários
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
}