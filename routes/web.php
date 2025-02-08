<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// INDEX
Route::view('/', 'Home/index');
Route::view('/fale-conosco', 'Home/fale-conosco');
Route::view('/politicas-de-privacidade', 'Home/politicas-de-privacidade');
Route::view('/sobre-a-medexame', 'Home/sobre-a-medexame');
Route::view('/Pagina-usuario', 'Home/paginadousuario');

// ADMIN DO SITE
Route::view('/admin', 'admin/login');
Route::view('/admin/dashboard', 'admin/sub-diretorios/dashboard/vendas');
Route::view('/admin/clinicas1', 'admin/sub-diretorios/clinicas/clinicas');
Route::view('/admin/clinicas2', 'admin/sub-diretorios/clinicas/registro-de-clinica');
Route::view('/admin/clinicas3', 'admin/sub-diretorios/clinicas/solicitacoes-de-cadastro');
Route::view('/admin/clinicas4', 'admin/sub-diretorios/clinicas/analise');
Route::view('/admin/usuarios', 'admin/sub-diretorios/usuarios');
Route::view('/admin/especialidades', 'admin/sub-diretorios/especialidades');
Route::view('/admin/especialidades2', 'admin/sub-diretorios/especialidades-add');
Route::view('/admin/classes', 'admin/sub-diretorios/classes');
Route::view('/admin/classes2', 'admin/sub-diretorios/classes-add');
Route::view('/admin/procedimentos', 'admin/sub-diretorios/procedimentos');
Route::view('/admin/procedimentos2', 'admin/sub-diretorios/procedimentos-add');
Route::view('/admin/relatorios', 'admin/sub-diretorios/relatorios');
Route::view('/admin/contatos', 'admin/sub-diretorios/contatos');
Route::view('/admin/homepage', 'admin/sub-diretorios/homepage');
Route::view('/admin/mensagens', 'admin/sub-diretorios/inbox');
Route::view('/admin/lucro', 'admin/sub-diretorios/lucro');
Route::view('/admin/servicos-diferenciados1', 'admin/sub-diretorios/servicos-diferenciados/visualizar');
Route::view('/admin/servicos-diferenciados2', 'admin/sub-diretorios/servicos-diferenciados/adicionar');

// ADMIN DA CLINICA
Route::get('/admin-clinica', function () {
    return view('Clinica/Adminclinica');
})->middleware(['auth:clinic'])->name('admin-clinica');

// CLINICA INDEX
Route::view('/clinica', 'Clinica/Paginaclinica');

// BUSCA
Route::view('/busca', 'busca/busca');
Route::view('/em-construcao', 'em-construcao');

// Protegendo o dashboard com autenticação e verificação de e-mail
Route::get('/dashboard', function () {
    return redirect()->route('profile.edit');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Grupo de rotas para ADMIN com Middleware de autorização
    Route::middleware('can:access')->prefix('admin')->group(function () {
        Route::get('/dashboard/vendas', [PagesController::class, 'vendas'])->name('admin.dashboard.vendas');
        Route::get('/dashboard/site', [PagesController::class, 'site'])->name('admin.dashboard.site');

        // Serviços diferenciados
        Route::prefix('dashboard/servicos-diferenciados')->group(function () {
            Route::get('/agenda-online', [PagesController::class, 'agendaOnline'])->name('admin.dashboard.servicos.agenda-online');
            Route::get('/classes', [PagesController::class, 'classes'])->name('admin.dashboard.servicos.classes');
            Route::get('/contatos', [PagesController::class, 'contatos'])->name('admin.dashboard.servicos.contatos');
            Route::get('/usuarios', [PagesController::class, 'usuarios'])->name('admin.dashboard.servicos.usuarios');
        });
    });
});

// Autenticação específica para clínicas
Route::middleware('auth:clinic')->group(function () {
    Route::get('/profile2', [ProfileController::class, 'edit'])->name('profile.edit2');
    Route::patch('/profile2', [ProfileController::class, 'update'])->name('profile.update2');
    Route::delete('/profile2', [ProfileController::class, 'destroy'])->name('profile.destroy2');
});

// Inclusão das rotas de autenticação
require __DIR__ . '/auth.php';
require __DIR__ . '/auth2.php';

