<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function verificarLogin(Request $request)
    {
        // Validação dos dados enviados (garante que email e password foram informados)
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Credenciais fixas (hardcoded)
        $emailChumbado    = 'admin';
        $passwordChumbado = '123'; // Em produção, nunca armazene senha em texto plano!

        // Verifica se os dados enviados são iguais aos valores fixos
        if ($request->email === $emailChumbado && $request->password === $passwordChumbado) {
            return response()->json([
                'message' => 'Credenciais válidas.'
            ], 200);
        }

        return response()->json([
            'message' => 'Credenciais inválidas.'
        ], 401);
    }
}
