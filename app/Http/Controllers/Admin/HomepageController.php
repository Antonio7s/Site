<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        return view('admin.sub-diretorios.homepage.index');
    }
}
