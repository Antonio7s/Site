<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeusPedidosController extends Controller
{
    /**
     * Exibe os agendamentos (meus pedidos) do usuário autenticado.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function meusPedidos(Request $request)
    {
        // Obtém o usuário autenticado (para testes, certifique-se de que o id seja 2)
        $user = auth()->user();

        // Seleciona apenas os campos existentes na tabela agendamentos
        $agendamentos = DB::table('agendamentos')
            ->select('id', 'data', 'status', 'pagamento_id', 'user_id', 'horario_id', 'created_id', 'update_id')
            ->where('user_id', $user->id)
            ->orderBy('data', 'desc')
            ->get();

        // Se não houver registros, passa uma coleção vazia
        if ($agendamentos->isEmpty()) {
            $agendamentos = collect([]);
        }

        return view('meuspedidos.index', ['agendamentos' => $agendamentos]);
    }

    /**
     * Atualiza o status do agendamento para "Cancelado".
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizarStatus(Request $request)
    {
        $id = $request->input('id');
        $status = 'cancelado';

        DB::table('agendamentos')
            ->where('id', $id)
            ->update(['status' => $status]);

        return redirect()->back()->with('success', 'Agendamento cancelado com sucesso!');
    }
}
