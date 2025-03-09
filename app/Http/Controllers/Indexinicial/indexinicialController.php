<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\Category;
use App\Models\Faq;

class IndexInicialController extends Controller
{
    /**
     * Exibe a página inicial com os dados dinâmicos configurados pelo admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Tenta recuperar as configurações; se não houver, cria uma nova instância vazia.
        $settings = HomepageSetting::first() ?? new HomepageSetting();
        
        // Recupera todas as categorias cadastradas.
        $categories = Category::all();
        
        // Recupera todas as perguntas frequentes.
        $faqs = Faq::all();

        // Retorna a view "home" passando as variáveis.
        return view('home', compact('settings', 'categories', 'faqs'));
    }
}
