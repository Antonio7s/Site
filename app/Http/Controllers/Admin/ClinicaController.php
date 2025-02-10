<?php

namespace App\Http\Controllers\Admin;
use App\Models\Clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClinicaController extends Controller
{
    public function index(Request $request)
    {
        // Usando paginação: exibe 10 registros por página
        $clinicas = Clinica::paginate(10);

        // Se precisar de filtros, você pode pegar os parâmetros de $request aqui e ajustar a query

        // Retorna a view, passando a variável com os dados paginados
        return view('/admin/sub-diretorios/clinicas/clinicas', compact('clinicas'));
    }
}
