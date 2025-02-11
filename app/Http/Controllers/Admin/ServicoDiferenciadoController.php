<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\Procedimento;

class ServicoDiferenciadoController extends Controller
{
    public function index(){
        return view('admin.sub-diretorios.servicos-diferenciados.index');
    }

    public function create()
    {
        // Obtém os dados necessários de cada modelo
        $clinicas = Clinica::all();
        $procedimentos = Procedimento::all();

        return view('admin.sub-diretorios.servicos-diferenciados.create', compact('clinicas','procedimentos'));
    }
}
