<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Agendamento;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function show(Request $request): View
    {
        return view('minhasinformacoes', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Carrega os agendamentos do usuário com os relacionamentos definidos:
     * Agendamento → Horário → [Procedimento e Agenda → Médico → Clínica]
     */
    public function agendamentos(): View
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Eager loading do relacionamento com Horário
        $agendamentos = Agendamento::with(['horario'])->where('user_id', $user->id)->get();

        foreach ($agendamentos as $agendamento) {
            // Pega o Horário, e dentro dele pega as informações de Agenda, Médico e Clínica
            $horario = $agendamento->horario;

            // Pega o horário de início do agendamento
            $agendamento->horario_inicio = $horario ? $horario->inicio : null;

            // Verifica se o Horário tem um Procedimento relacionado
            $agendamento->procedimento_nome = $horario && $horario->procedimento ? $horario->procedimento->nome : null;

            // Pega a Agenda relacionada ao horário
            $agenda = $horario ? $horario->agenda : null;

            // Verifica se existe Agenda, Médico e Clínica, e atribui os valores
            $medico = $agenda ? $agenda->medico : null;
            $agendamento->medico_nome = $medico ? $medico->nome : null;

            $clinica = $medico ? $medico->clinica : null;
            $agendamento->clinica_nome = $clinica ? $clinica->nome : null;
        }

        return view('profile.agendamentos', compact('agendamentos'));
    }

    public function minhasInformacoes(): View
    {
        return view('profile.minhasInformacoes');
    }

    /**
     * Carrega os pedidos (agendamentos com status "agendado") usando os mesmos relacionamentos.
     */
    public function meusPedidos(): View
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Eager loading do relacionamento com Horário
        $agendamentos = Agendamento::with(['horario'])->where('user_id', $user->id)
            ->where('status', 'agendado')
            ->orderBy('data', 'desc')
            ->get();

        foreach ($agendamentos as $agendamento) {
            // Pega o Horário, e dentro dele pega as informações de Agenda, Médico e Clínica
            $horario = $agendamento->horario;

            // Pega o horário de início do agendamento
            $agendamento->horario_inicio = $horario ? $horario->inicio : null;

            // Verifica se o Horário tem um Procedimento relacionado
            $agendamento->procedimento_nome = $horario && $horario->procedimento ? $horario->procedimento->nome : null;

            // Pega a Agenda relacionada ao horário
            $agenda = $horario ? $horario->agenda : null;

            // Verifica se existe Agenda, Médico e Clínica, e atribui os valores
            $medico = $agenda ? $agenda->medico : null;
            $agendamento->medico_nome = $medico ? $medico->nome : null;

            $clinica = $medico ? $medico->clinica : null;
            $agendamento->clinica_nome = $clinica ? $clinica->nome : null;
        }

        return view('profile.meuspedidos', compact('agendamentos'));
    }
}
