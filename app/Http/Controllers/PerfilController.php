<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PerfilController extends Controller
{
    // Exibe o formulário de edição de perfil
    public function editar()
    {
        return view('perfil.editar');
    }

    // Processa a atualização dos dados do perfil
    public function atualizar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            // Adicione outras validações conforme necessário
        ]);

        $usuario = Auth::user();
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        // Atualize outros campos conforme necessário
        $usuario->save();

        return redirect()->route('perfil.editar')->with('sucesso', 'Perfil atualizado com sucesso!');
    }
}
