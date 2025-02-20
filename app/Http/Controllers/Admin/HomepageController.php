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
        $settings = HomepageSetting::first();
        $categories = Category::all();
        $faqs = Faq::all();

        return view('admin.sub-diretorios.homepage.index', compact('settings', 'categories', 'faqs'));
    }

    public function save(Request $request)
    {
        try {
            // Validação dos dados
            $request->validate([
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'categories' => 'nullable|array',
                'categories.*.title' => 'required|string|max:255',
                'categories.*.icon' => 'required|string|max:255',
                'categories.*.color' => 'required|string|max:7',
                'faq' => 'nullable|array',
                'faq.*.question' => 'required|string|max:255',
                'faq.*.answer' => 'required|string',
                'infoBasicas' => 'nullable|string',
                'playStoreLink' => 'nullable|url',
                'apkLink' => 'nullable|url',
            ]);

            // Salvar ou atualizar configurações gerais
            $settings = HomepageSetting::firstOrNew();
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('public/logos');
                $settings->logo_path = $logoPath;
            }
            if ($request->hasFile('banner')) {
                $bannerPath = $request->file('banner')->store('public/banners');
                $settings->banner_path = $bannerPath;
            }
            $settings->info_basicas = $request->input('infoBasicas');
            $settings->play_store_link = $request->input('playStoreLink');
            $settings->apk_link = $request->input('apkLink');
            $settings->save();

            // Salvar ou atualizar categorias
            if ($request->has('categories')) {
                Category::truncate(); // Remove todas as categorias existentes
                foreach ($request->input('categories') as $categoryData) {
                    Category::create($categoryData);
                }
            }

            // Salvar ou atualizar FAQ
            if ($request->has('faq')) {
                Faq::truncate(); // Remove todas as perguntas existentes
                foreach ($request->input('faq') as $faqData) {
                    Faq::create($faqData);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}