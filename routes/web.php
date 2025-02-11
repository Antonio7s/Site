<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileController2;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ClinicaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\EspecialidadeController;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\ProcedimentoController;
use App\Http\Controllers\Admin\ServicoDiferenciadoController;


Route::prefix('admin')->group(function(){
    Route::get('/clinicas', [ClinicaController::class, 'index'])->name('clinicas.index');
    Route::get('/clinicas/{id}/edit', [ClinicaController::class, 'edit'])->name('clinicas.edit');
    Route::get('/clinicas/{id}/show', [ClinicaController::class, 'show'])->name('clinicas.show');
    Route::get('/clinicas/destroy', [ClinicaController::class, 'destroy'])->name('clinicas.destroy');

    //clinicas/registro
    //clinicas/solicitacoes-de-cadastro
    //clinicas/solicitacoes-de-cadastro-analise
});

    // Rotas que exigem autenticação de user e têm o prefixo 'admin'
Route::middleware('auth', 'verified')->prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin/sub-diretorios/dashboard/vendas')->name('dashboard.admin');
    Route::view('', 'admin/login');
    Route::view('clinicas1', 'admin/sub-diretorios/clinicas/clinicas');
    Route::view('clinicas2', 'admin/sub-diretorios/clinicas/registro-de-clinica');
    Route::view('clinicas3', 'admin/sub-diretorios/clinicas/solicitacoes-de-cadastro');
    Route::view('clinicas4', 'admin/sub-diretorios/clinicas/analise');
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('especialidades', [EspecialidadeController::class, 'index'])->name('especialidades.index');
    Route::get('especialidades/create', [EspecialidadeController::class, 'create'])->name('especialidades.create');
    Route::post('especialidades', [EspecialidadeController::class, 'store'])->name('especialidades.store');
    Route::get('classes', [ClasseController::class, 'index'])->name('classes.index');
    Route::get('classes', [ClasseController::class, 'create'])->name('classes.index');
    Route::get('classes', [ClasseController::class, 'edit'])->name('classes.index');
    Route::get('classes', [ClasseController::class, 'delet'])->name('classes.index');
    Route::get('classes', [ClasseController::class, 'update'])->name('classes.index');

    // Procedimentos
    Route::view('procedimentos', 'admin/sub-diretorios/procedimentos/procedimentos');
    Route::view('procedimentos2', 'admin/sub-diretorios/procedimentos/create');
    Route::view('relatorios', 'admin/sub-diretorios/relatorios');
    Route::view('contatos', 'admin/sub-diretorios/contatos');
    Route::view('homepage', 'admin/sub-diretorios/homepage');
    Route::view('mensagens', 'admin/sub-diretorios/inbox');
    Route::view('lucro', 'admin/sub-diretorios/lucro');
    Route::get('servicos-diferenciados', [ServicoDiferenciadoController::class, 'index'])->name('servicos-diferenciados.index');
    Route::get('servicos-diferenciados/create', [ServicoDiferenciadoController::class, 'create'])->name('servicos-diferenciados.create');
});

// INDEX
Route::view('/', 'Home/index')->name('index');;
Route::view('/fale-conosco', 'Home/fale-conosco');
Route::view('/politicas-de-privacidade', 'Home/politicas-de-privacidade');
Route::view('/sobre-a-medexame', 'Home/sobre-a-medexame');
Route::view('/Pagina-usuario', 'Home/paginadousuario');


// ADMIN DA CLINICA
Route::get('/admin-clinica', function () {
    return view('Clinica/Adminclinica');
})->middleware(['auth:clinic', 'verified'])->name('admin-clinica');


// CLINICA INDEX
Route::view('/clinica', 'Clinica/Paginaclinica');

// BUSCA
Route::view('/busca', 'busca/busca');
Route::view('/em-construcao', 'em-construcao');

// Protegendo o dashboard do usuário com autenticação e verificação de e-mail
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

