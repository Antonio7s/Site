<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\HomepageSetting;
use App\Models\Category;
use App\Models\Faq;
use Illuminate\Support\Facades\Log;

class IndexInicialController extends Controller
{
    // Método para exibir a homepage com as configurações, categorias, FAQ e horários disponíveis
    public function index()
    {
        $settings = HomepageSetting::first();
        $categories = Category::all();
        $faqs = Faq::all();

        $horarios = Horario::where('data', '>=', now())
            ->with(['medico.especialidades', 'clinica'])
            ->get();

        return view('home', compact('settings', 'categories', 'faqs', 'horarios'));
    }

    // Método AJAX para buscar horários (permanece conforme sua lógica)
    public function buscarHorarios(Request $request)
    {
        $query = $request->query('query');
        Log::info('Termo de busca:', ['query' => $query]);

        $horarios = Horario::where('data', '>=', now())
            ->whereHas('medico', function ($q) use ($query) {
                $q->whereHas('especialidades', function ($subQuery) use ($query) {
                    $subQuery->where('nome', 'like', "%$query%");
                });
            })
            ->with(['medico.especialidades', 'clinica'])
            ->get()
            ->map(function ($horario) {
                return [
                    'medico' => $horario->medico->nome,
                    'especialidades' => $horario->medico->especialidades->pluck('nome')->implode(', '),
                    'clinica' => $horario->clinica->nome,
                    'data' => $horario->data->format('d/m/Y'),
                    'horario' => $horario->horario_inicio,
                    'procedimento' => $horario->procedimento,
                ];
            });

        Log::info('Horários encontrados:', ['horarios' => $horarios]);

        return response()->json($horarios);
    }
}
