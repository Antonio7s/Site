<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardClinicaController extends Controller
{
    public function index()
    {
        return view('/admin-clinica/dashboard/index');
    }
}
