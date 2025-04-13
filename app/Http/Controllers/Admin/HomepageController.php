<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\HomepageSetting;
use App\Models\Category;
use App\Models\Faq;

class HomepageController extends Controller
{
    public function index()
    {
        $homepageSettings = HomepageSetting::first();
        $categories = Category::all();
        $faqs = Faq::all();

        return view('admin.sub-diretorios.homepage.index', compact('homepageSettings', 'categories', 'faqs'));
    }

    public function save(Request $request)
    {
        try {
            \Log::info('Dados recebidos no método save:', $request->all());

            // Validação dos dados
            $validatedData = $request->validate([
                'logo'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banner'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'categories'         => 'nullable|array',
                'categories.*.title' => 'required|string|max:255',
                'categories.*.icon'  => 'required|string|max:255',
                'categories.*.color' => 'required|string|max:7',
                'faq'                => 'nullable|array',
                'faq.*.question'     => 'required|string|max:255',
                'faq.*.answer'       => 'required|string',
                'infoBasicas'        => 'nullable|string',
                'playStoreLink'      => 'nullable|url',
                'apkLink'            => 'nullable|url',
            ]);

            \Log::info('Dados validados com sucesso:', $validatedData);

            // Busca ou cria uma nova instância de HomepageSetting
            $settings = HomepageSetting::first() ?? new HomepageSetting();

            // Upload do logo
            if ($request->hasFile('logo')) {
                if ($settings->logo_path && file_exists(public_path($settings->logo_path))) {
                    unlink(public_path($settings->logo_path));
                }
                $logoFile = $request->file('logo');
                $destinationPath = public_path('images');
                $logoName = time() . '-' . $logoFile->getClientOriginalName();
                $logoFile->move($destinationPath, $logoName);
                $settings->logo_path = 'images/' . $logoName;
                \Log::info('Logo salvo com sucesso:', ['path' => $settings->logo_path]);
            }


            // Upload do banner utilizando Storage
            if ($request->hasFile('banner')) {
                // Remove o banner antigo, se existir
                if ($settings->banner_path && Storage::disk('public')->exists(str_replace('storage/', '', $settings->banner_path))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $settings->banner_path));
                }

                // Armazena novo banner em storage/app/public/banners
                $bannerPath = $request->file('banner')->store('banners', 'public');

                // Salva o caminho acessível publicamente
                $settings->banner_path = 'storage/' . $bannerPath;
                \Log::info('Banner salvo com sucesso:', ['path' => $settings->banner_path]);
            }
            

            // Atualiza as demais configurações
            $settings->info_basicas    = $request->input('infoBasicas');
            $settings->play_store_link = $request->input('playStoreLink');
            $settings->apk_link        = $request->input('apkLink');
            $settings->save();
            \Log::info('Configurações gerais salvas com sucesso.');

            // Salva as categorias
            if ($request->has('categories')) {
                // Remove todas as categorias existentes
                Category::truncate();
                foreach ($request->input('categories') as $categoryData) {
                    Category::create($categoryData);
                }
                \Log::info('Categorias salvas com sucesso:', $request->input('categories'));
            }

            // Salva as perguntas frequentes (FAQ)
            if ($request->has('faq')) {
                Faq::truncate();
                foreach ($request->input('faq') as $faqData) {
                    Faq::create($faqData);
                }
                \Log::info('FAQ salvo com sucesso:', $request->input('faq'));
            }

            return response()->json([
                'success' => true,
                'message' => 'Configurações salvas com sucesso!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao salvar as configurações:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar as configurações: ' . $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], 500);
        }
    }
}
