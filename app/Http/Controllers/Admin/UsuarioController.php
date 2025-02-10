<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::paginate(10);

        // Busca todos os usuarios do banco de dados
        $usuarios = User::all();

        // Retorna a view 'usuarios.index' passando os usuarios
        return view('/admin/sub-diretorios/usuarios/usuarios', compact('usuarios'));
    }
}
