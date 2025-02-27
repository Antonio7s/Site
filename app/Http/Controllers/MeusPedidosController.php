<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Exibe os agendamentos (meus pedidos) do usuário autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function meusPedidos(Request $request)
    {
        $user = auth()->user();

        $pedidos = DB::table('agendamentos')
            ->join('horarios', 'agendamentos.horario_id', '=', 'horarios.id')
            ->join('procedimentos', 'agendamentos.procedimento_id', '=', 'procedimentos.id')
            ->join('classes', 'agendamentos.classe_id', '=', 'classes.id')
            ->select(
                'agendamentos.id',
                'agendamentos.nome as nome_agendamento',
                'classes.nome as medico',
                'procedimentos.nome as procedimento',
                'agendamentos.data',
                'horarios.horario',
                'procedimentos.preco as precos',
                'agendamentos.status'
            )
            ->where('agendamentos.user_id', $user->id)
            ->orderBy('agendamentos.data', 'desc')
            ->get();

        if ($pedidos->isEmpty()) {
            $pedidos = collect([]);
        }

        return view('meuspedidos.index', compact('pedidos'));
    }

    /**
     * Atualiza o status para Cancelado
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
