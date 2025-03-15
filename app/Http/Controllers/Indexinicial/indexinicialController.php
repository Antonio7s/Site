<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\Faq;
use App\Models\Category;

class IndexInicialController extends Controller
{
    public function index()
    {
        // Buscando os dados do banco de dados
        $homepageSettings = HomepageSetting::first();
        $faqs = Faq::all();
        $categories = Category::all();

        // Passando os dados para a view
        return view('index', compact('homepageSettings', 'faqs', 'categories'));
    }
}