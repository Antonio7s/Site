<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('admin.sub-diretorios.relatorios.index');
    }
}
