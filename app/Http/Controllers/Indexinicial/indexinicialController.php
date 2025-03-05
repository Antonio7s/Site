<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\Category;
use App\Models\Faq;

class IndexInicialController extends Controller
{
    // Exibe a página inicial com os dados enviados pelo HomepageController (admin)
    public function index()
    {
        // Busca os dados conforme cadastrados/atualizados pelo admin
        $settings = HomepageSetting::first();
        $categories = Category::all();
        $faqs = Faq::all();

        // Retorna a view 'home' com os dados recebidos do admin
        return view('home', compact('settings', 'categories', 'faqs'));
    }
}
