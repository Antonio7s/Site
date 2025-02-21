<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\Category;
use App\Models\Faq;

class indexinicialController extends Controller
{
    public function index(Request $request)
    {
        // Recupera os dados da homepage
        $settings = HomepageSetting::first();
        $categories = Category::all();
        $faqs = Faq::all();

        // Retorna a view 'admin/Home/index' com os dados
        return view('admin.Home.index', compact('settings', 'categories', 'faqs'));
    }
}