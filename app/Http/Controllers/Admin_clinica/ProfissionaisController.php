<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Medico;
use App\Models\Especialidade;
use App\Models\Procedimento;
use App\Models\Agenda;
use App\Models\MedicoEspecialidade;
use App\Models\MedicoProcedimento;


class ProfissionaisController extends Controller
{
    public function index(Request $request)
    {
        // $profissionais = Medico::paginate(20);

        // Obtém a clínica autenticada via guard 'clinic'
        $clinicaId = auth()->guard('clinic')->user()->id;

        // Filtra os profissionais que pertencem à clínica autenticada e pagina os resultados
        $profissionais = Medico::where('clinica_id', $clinicaId)->paginate(20);

        return view('admin-clinica.profissionais-associados.index', compact('profissionais'));
    }

    public function create()
    {
        $especialidades = Especialidade::all();
        $procedimentos = Procedimento::all();
        return view('admin-clinica.profissionais-associados.create', compact('especialidades', 'procedimentos'));
    }

    public function store(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'clinica_id'      => 'required|exists:clinicas,id',
            'profissional_nome'   => 'required|string|max:255',
            'profissional_sobrenome'    => 'nullable|string|max:255',
            'foto_url'        => 'nullable|image|max:2048',
            'email'           => 'required|email|unique:medicos,email',
            'telefone'        => 'required|string|max:20',
            'conselho_nome'  => 'required|string|max:20',
            'conselho_numero' => 'required|string|max:20',
            'especialidades'  => 'required|array',
            'especialidades.*'=> 'exists:especialidades,id',
            'procedimentos'   => 'required|array',
            'procedimentos.*' => 'exists:procedimentos,id',
        ]);

        // Captura apenas os campos necessários para o médico
        $dados = $request->only([
            'clinica_id', 'profissional_nome', 'profissional_sobrenome', 'email', 'telefone', 'conselho_nome', 'conselho_numero','foto_url',
        ]);

        // Upload da foto, se existir
        if ($request->hasFile('foto_url')) {
            $dados['foto_url'] = $request->file('foto_url')->store('fotos_medicos', 'public');
        }

        // Cria o médico no banco de dados
        $medico = Medico::create($dados);

        // Associa as especialidades e procedimentos usando os dados do request
        $medico->especialidades()->attach($request->especialidades);
        $medico->procedimentos()->attach($request->procedimentos);

        //ASSOCIAR AGENDA.
        $agendaPadrao = Agenda::create([
            'medico_id' => $medico->id, // Associando a agenda ao médico recém-criado
            'tipo' => 'padrao', // outros campos necessários
            // outros valores default, caso haja
        ]);

        // Associar a agenda padrão ao médico (usando save, pois é um relacionamento HasOne)
        $medico->agenda()->save($agendaPadrao);


        return redirect()->route('admin-clinica.profissionais-associados.index')
                         ->with('success', 'Profissional cadastrado com sucesso!');
    }

    // Exibe os detalhes de um profissional
    public function show($id)
    {
        $profissional = Medico::with(['especialidades', 'procedimentos'])->findOrFail($id);
        return view('admin-clinica.profissionais-associados.show', compact('profissional'));
    }

    // Exibe o formulário para editar um profissional
    public function edit($id)
    {
        $profissional = Medico::findOrFail($id);
        $especialidades = Especialidade::all();
        $procedimentos = Procedimento::all();
        return view('admin-clinica.profissionais-associados.edit', compact('profissional', 'especialidades', 'procedimentos'));
    }

    // Atualiza os dados do profissional
    public function update(Request $request, $id)
    {
        $profissional = Medico::findOrFail($id);

        // Validação dos dados enviados
        $request->validate([
            'clinica_id'      => 'required|exists:clinicas,id',
            'profissional_nome'   => 'required|string|max:255',
            'profissional_sobrenome'    => 'nullable|string|max:255',
            'foto_url'        => 'nullable|image|max:2048',
            'email'           => "required|email|unique:medicos,email,{$id}",
            'telefone'        => 'required|string|max:20',
            'conselho_nome'   => "required|string|unique:medicos,crm,{$id}",
            'conselho_numero' => 'required|string|max:20',
            'especialidades'  => 'required|array',
            'especialidades.*'=> 'exists:especialidades,id',
            'procedimentos'   => 'required|array',
            'procedimentos.*' => 'exists:procedimentos,id',
        ]);

        // Atualiza os dados do médico
        $dados = $request->only(['profissional_nome', 'profissional_sobrenome', 'email', 'telefone', 'crm','clinica_id']);

        if ($request->hasFile('foto_url')) {
            $dados['foto_url'] = $request->file('foto_url')->store('fotos_medicos', 'public');
        }

        $profissional->update($dados);

        // Atualiza os relacionamentos: remove os antigos e insere os novos
        $profissional->especialidades()->sync($request->especialidades);
        $profissional->procedimentos()->sync($request->procedimentos);

        return redirect()->route('admin-clinica.profissionais-associados.index')
                         ->with('success', 'Profissional atualizado com sucesso!');
    }

    // Exclui um profissional
    public function destroy($id)
    {
        $profissional = Medico::findOrFail($id);
        $profissional->delete();

        return redirect()->route('admin-clinica.profissionais-associados.index')
                         ->with('success', 'Profissional removido com sucesso!');
    }
}
