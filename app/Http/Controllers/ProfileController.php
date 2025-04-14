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
        $user = $request->user();
        $agendamentos = Agendamento::with([
            'horario',
            'horario.procedimento',
            'horario.agenda.medico'
        ])
            ->where('user_id', $user->id)
            ->where('status', 'agendado')
            ->orderBy('data', 'desc')
            ->get();

        $agendamentos->transform(function ($agendamento) {
            return $this->formatAgendamento($agendamento);
        });

        return view('profile.edit', [
            'user' => $user,
            'agendamentos' => $agendamentos,
        ]);
    }

    public function show(Request $request): View
    {
        return view('Minhasinformacoes', [
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

    private function formatAgendamento($agendamento)
    {
        $horario = $agendamento->horario;
        
        $agendamento->horario_inicio = $horario ? $horario->horario_inicio : null;
        $agendamento->procedimento_nome = ($horario && $horario->procedimento) ? $horario->procedimento->nome : null;

        if ($horario && $horario->agenda) {
            $medico = $horario->agenda->medico;
            if ($medico) {
                $agendamento->medico_nome = $medico->profissional_nome . ' ' . $medico->profissional_sobrenome;
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

        $agendamentos->transform(function ($agendamento) {
            return $this->formatAgendamento($agendamento);
        });

        return view('profile.agendamentos', compact('agendamentos'));
    }

    public function minhasInformacoes(): View
    {
        return view('profile.Minhasinformacoes');
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

        $agendamentos->transform(function ($agendamento) {
            return $this->formatAgendamento($agendamento);
        });

        return view('profile.meuspedidos', compact('agendamentos'));
    }
}
