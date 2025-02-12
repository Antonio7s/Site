<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // Certifique-se de que o usuário tenha permissão de 'access' antes de acessar qualquer método
        $this->middleware('can:access');
    }

    public function index(Request $request)
    {
        // Pega os usuários do banco de dados
        $usuarios = User::paginate(10);

        // Retorna a view 'usuarios.index' passando os usuários
        return view('/admin/sub-diretorios/usuarios/usuarios', compact('usuarios'));
    }
}
