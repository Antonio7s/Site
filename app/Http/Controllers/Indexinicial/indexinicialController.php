<?php 

namespace App\Http\Controllers\Indexinicial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\Faq;
use App\Models\Category;

class IndexInicialController extends Controller
{
    public function index()
    {
        // Busca o primeiro registro de configurações da homepage
        $homepageSettings = HomepageSetting::first();

        // Se existir um registro, e o campo banner_path estiver vazio e houver um valor em path, atribuímos esse valor a banner_path.
        if ($homepageSettings && empty($homepageSettings->banner_path) && !empty($homepageSettings->path)) {
            $homepageSettings->banner_path = $homepageSettings->path;
        }

        $faqs = Faq::all();
        $categories = Category::all();

        // Passa os dados para a view
        return view('home.index', compact('homepageSettings', 'faqs', 'categories'));
    }
}
