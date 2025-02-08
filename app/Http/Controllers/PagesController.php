<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function vendas()
    {
        return view('admin.sub-diretorios.dashboard.vendas');
    }

    public function site()
    {
        return view('admin.sub-diretorios.dashboard.site');
    }

    public function agendaOnline()
    {
        return view('admin.sub-diretorios.dashboard.serviços-diferenciados.agenda-online');
    }

    public function classes()
    {
        return view('admin.sub-diretorios.dashboard.serviços-diferenciados.classes');
    }

    public function contatos()
    {
        return view('admin.sub-diretorios.dashboard.serviços-diferenciados.contatos');
    }

    public function usuarios()
    {
        return view('admin.sub-diretorios.dashboard.serviços-diferenciados.usuarios');
    }

    
}