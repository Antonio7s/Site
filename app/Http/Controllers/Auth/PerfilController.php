<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class PerfilController extends Controller
{
    // Método para exibir o formulário de edição
    public function editarPerfil()
    {
        return view('profile.alterar_informacoes');
    }

    // Método para atualizar as informações do usuário
    public function atualizarPerfil(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'data_nascimento' => 'required|date',
        ]);

        // Atualizar as informações do usuário autenticado
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->telefone = $request->input('telefone');
        $user->data_nascimento = $request->input('data_nascimento');
        $user->save();

        // Redirecionar com mensagem de sucesso
        return redirect()->route('perfil.editar')->with('success', 'Informações atualizadas com sucesso!');
    }
}
