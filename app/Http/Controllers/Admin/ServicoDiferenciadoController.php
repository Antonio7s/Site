<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinica;

class ServicoDiferenciadoController extends Controller
{
    public function index()
    {
        // Carrega as clínicas com os serviços diferenciados e o procedimento vinculado
        $clinicas = Clinica::with('servicosDiferenciados.procedimento')->get();

        // Para cada clínica, atribui a lista de serviços diferenciados (caso não haja, ficará vazia)
        foreach ($clinicas as $clinica) {
            $clinica->listaServicos = $clinica->servicosDiferenciados;
        }

        return view('admin.sub-diretorios.servicos-diferenciados.index', compact('clinicas'));
    }
    
    public function create()
    {
        // Obtém os dados necessários para o cadastro
        $clinicas = \App\Models\Clinica::all();
        $procedimentos = \App\Models\Procedimento::all();

        return view('admin.sub-diretorios.servicos-diferenciados.create', compact('clinicas', 'procedimentos'));
    }
}
