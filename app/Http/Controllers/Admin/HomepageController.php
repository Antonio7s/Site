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
            \Log::info('Dados recebidos no método save:', $request->all());

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

            $settings = HomepageSetting::first() ?? new HomepageSetting();

            if ($request->hasFile('logo')) {
                if ($settings->logo_path && Storage::exists($settings->logo_path)) {
                    Storage::delete($settings->logo_path);
                }
                $logoPath = $request->file('logo')->store('public/logos');
                $settings->logo_path = $logoPath;
                \Log::info('Logo salvo com sucesso:', ['path' => $logoPath]);
            }

            if ($request->hasFile('banner')) {
                if ($settings->banner_path && Storage::exists($settings->banner_path)) {
                    Storage::delete($settings->banner_path);
                }
                $bannerPath = $request->file('banner')->store('public/banners');
                $settings->banner_path = $bannerPath;
                \Log::info('Banner salvo com sucesso:', ['path' => $bannerPath]);
            }

            $settings->info_basicas    = $request->input('infoBasicas');
            $settings->play_store_link = $request->input('playStoreLink');
            $settings->apk_link        = $request->input('apkLink');
            $settings->save();
            \Log::info('Configurações gerais salvas com sucesso.');

            if ($request->has('categories')) {
                Category::truncate();
                foreach ($request->input('categories') as $categoryData) {
                    Category::create($categoryData);
                }
                \Log::info('Categorias salvas com sucesso:', $request->input('categories'));
            }

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
