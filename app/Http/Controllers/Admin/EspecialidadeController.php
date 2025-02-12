<?php

namespace App\Http\Controllers\Admin;
use App\Models\Especialidade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    public function index(Request $request)
    {
        $especialidades = Especialidade::paginate(10);


        // Retorna a view 'usuarios.index' passando os usuarios
        return view('admin.sub-diretorios.especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('admin.sub-diretorios.especialidades.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'especialidade' => 'required|string|max:255',
        ]);

        // Cria a especialidade no banco
        Especialidade::create([
            'especialidade' => $request->especialidade,
        ]);

        // Redireciona para a lista de especialidades com mensagem de sucesso
        return redirect()->route('especialidades.index')
                        ->with('success', 'Especialidade cadastrada com sucesso!');
    }

}
