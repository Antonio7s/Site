<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        return view('admin.sub-diretorios.inbox.index');
    }
}
