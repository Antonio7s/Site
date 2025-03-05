<?php  

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Agendamento;
use App\Models\Clinica;
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
     * Método auxiliar para formatar os dados do agendamento.
     * Extrai o horário de início, o nome do procedimento, o nome do médico
     * (concatenando profissional_nome e profissional_sobrenome) e a razão social da clínica.
     * O caminho para obter a clínica é: medicos (clinica_id) - Clinicas (id, razão_social).
     */
    private function formatAgendamento($agendamento)
    {
        $horario = $agendamento->horario;
        
        // Pega o horário de início, se existir
        $agendamento->horario_inicio = $horario ? $horario->horario_inicio : null;

        // Nome do procedimento, se existir
        $agendamento->procedimento_nome = ($horario && $horario->procedimento)
            ? $horario->procedimento->nome
            : null;

        if ($horario && $horario->agenda) {
            $medico = $horario->agenda->medico;
            if ($medico) {
                // Monta o nome completo do médico
                $agendamento->medico_nome = $medico->profissional_nome . ' ' . $medico->profissional_sobrenome;
                // Busca o clinica_id do médico e consulta a tabela Clinicas para recuperar a razão_social
                $clinica = Clinica::find($medico->clinica_id);
                $agendamento->clinica_nome = $clinica ? $clinica->razao_social : null;
            } else {
                $agendamento->medico_nome = null;
                $agendamento->clinica_nome = null;
            }
        } else {
            $agendamento->medico_nome = null;
            $agendamento->clinica_nome = null;
        }

        return $agendamento;
    }

    public function agendamentos(): View
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $agendamentos = Agendamento::with([
            'horario',
            'horario.procedimento',
            'horario.agenda.medico'
        ])
            ->where('user_id', $user->id)
            ->get();

        // Formata cada agendamento utilizando o método auxiliar
        $agendamentos->transform(function ($agendamento) {
            return $this->formatAgendamento($agendamento);
        });

        return view('profile.agendamentos', compact('agendamentos'));
    }

    public function minhasInformacoes(): View
    {
        return view('profile.minhasInformacoes');
    }

    public function meusPedidos(): View
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $agendamentos = Agendamento::with([
            'horario',
            'horario.procedimento',
            'horario.agenda.medico'
        ])
            ->where('user_id', $user->id)
            ->where('status', 'agendado')
            ->orderBy('data', 'desc')
            ->get();

        // Formata cada agendamento utilizando o método auxiliar
        $agendamentos->transform(function ($agendamento) {
            return $this->formatAgendamento($agendamento);
        });

        return view('profile.meuspedidos', compact('agendamentos'));
    }
}
