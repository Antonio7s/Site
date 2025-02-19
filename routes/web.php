<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileController2;
use Illuminate\Support\Facades\Route;

// Importação de Controller's \ADMIN
use App\Http\Controllers\Admin\ClinicaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\EspecialidadeController;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\ProcedimentoController;
use App\Http\Controllers\Admin\ServicoDiferenciadoController;
use App\Http\Controllers\Admin\ContatoController;
use App\Http\Controllers\Admin\RelatorioController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\Admin\DashboardController;

// Importação de Controller's \Admin_clinica
use App\Http\Controllers\Admin_clinica\AgendaController;
use App\Http\Controllers\Admin_clinica\AdminClinicaController;
use App\Http\Controllers\Admin_clinica\DashboardClinicaController;
use App\Http\Controllers\Admin_clinica\ProfissionaisController;
use App\Http\Controllers\Admin_clinica\ServicosController;
// Inclusão das rotas de autenticação
require __DIR__ . '/auth.php';
require __DIR__ . '/auth2.php';


// Rotas que exigem AUTENTICACAO de user e AUTORIZAÇÃO de admin e têm o prefixo 'admin'.
Route::middleware('auth', 'verified', 'can:access')->prefix('admin')->group(function () {
    
    //Dashboard
    Route::controller(DashboardController::class)->prefix('dashboard')->group(function (){
        Route::get('/', 'index')->name('admin.dashboard.admin');
    });

    // Clínicas
    Route::get('/clinicas', [ClinicaController::class, 'index'])->name('admin.clinicas.index');
    Route::get('/clinicas/create', [ClinicaController::class, 'create'])->name('admin.clinicas.create');
    Route::get('/clinicas/{id}/edit', [ClinicaController::class, 'edit'])->name('admin.clinicas.edit');
    Route::put('/clinicas/{id}', [ClinicaController::class, 'update'])->name('admin.clinicas.update');
    Route::get('/clinicas/{id}/show', [ClinicaController::class, 'show'])->name('admin.clinicas.show');
    Route::delete('/clinicas/{id}', [ClinicaController::class, 'destroy'])->name('admin.clinicas.destroy'); // Corrigido para delete, já que é uma exclusão
    // Clínicas - Análise de cadastros
    Route::get('/clinicas/solicitacoes-de-cadastro/', [ClinicaController::class, 'solicitacoes_de_cadastro'])->name('admin.clinicas.solicitacoes');
    Route::match(['get', 'post'], 'clinicas/solicitacoes-de-cadastro/{id}/analise', [ClinicaController::class, 'analise'])->name('admin.clinicas.solicitacoes-de-cadastro.analise');
    Route::get('/clinicas/{id}/download', [ClinicaController::class, 'download'])->name('admin.clinicas.download');
    
    // Usuários
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
    
    // Especialidades
    Route::controller(EspecialidadeController::class)->prefix('especialidades')->group(function () {
        Route::get('/', 'index')->name('admin.especialidades.index');
        Route::get('/create',  'create')->name('admin.especialidades.create');
        Route::post('/', 'store')->name('admin.especialidades.store');
        Route::get('/{id}/edit', 'edit')->name('admin.especialidades.edit');
        Route::get('/{id}', 'show')->name('admin.especialidades.show');
        Route::put('/{id}', 'update')->name('admin.especialidades.update');
        Route::delete('/{id}', 'destroy')->name('admin.especialidades.destroy');
    });

   // Classes
   Route::controller(ClasseController::class)->prefix('classes')->group(function () {
        Route::get('/', 'index')->name('admin.classes.index');
        Route::get('/create', 'create')->name('admin.classes.create');
        Route::post('/', 'store')->name('admin.classes.store');
        Route::get('/{id}/edit', 'edit')->name('admin.classes.edit');
        Route::get('/{id}', 'show')-> name('admin.classes.show');
        Route::put('/{id}', 'update')->name('admin.classes.update');
        Route::delete('/{id}', 'destroy')->name('admin.classes.destroy');
   });
   
    // Procedimentos
    Route::controller(ProcedimentoController::class)->prefix('procedimentos')->group(function () {
        Route::get('/', 'index')->name('admin.procedimentos.index');
        Route::get('/create', 'create')->name('admin.procedimentos.create');
        Route::post('/', 'store')->name('admin.procedimentos.store');
        Route::get('/{id}/edit', 'edit')->name('admin.procedimentos.edit');
        Route::get('/{id}', 'show')-> name('admin.procedimentos.show');
        Route::put('/{id}', 'update')->name('admin.procedimentos.update');
        Route::delete('/{id}', 'destroy')->name('admin.procedimentos.destroy');
    });

    // Serviços Diferenciados
    Route::controller(ServicoDiferenciadoController::class)->prefix('servicos-diferenciados')->group(function () {
        Route::get('/', 'index')->name('admin.servicos-diferenciados.index');
        Route::get('/create', 'create')->name('admin.servicos-diferenciados.create');
    });

    // Outros
    Route::get('relatorios', [RelatorioController::class, 'index'])->name('admin.relatorios.index');
    Route::get('contatos', [ContatosController::class, 'index'])->name('admin.contatos.index');
    Route::get('homepage', [HomepageController::class], 'index')->name('admin.homepage.index');
    Route::get('mensagens', [InboxController::class], 'index')->name('admin.mensagens.index');
});

// Rotas que exigem autenticação de clínica e têm o prefixo 'admin-clinica'
Route::middleware(['auth:clinic', 'verified', 'check.clinica.status'])->prefix('admin-clinica')->group(function () {
    
    //Dashboard
    Route::get('/dashboard', [DashboardClinicaController::class, 'index'])->name('admin-clinica.dashboard.index'); // DASHBOARD - EM BRANCO
    
    //Servicos
    Route::get('/servicos', [ServicosController::class,'index'])->name('admin-clinica.servicos.index'); // Listagem de serviços
    
    //Sobre
    Route::get('/sobre', [AdminClinicaController::class,'index'])->name('admin-clinica.sobre.index'); //SOBRE A CLÍNICA
        
    // Profissionais
    Route::controller(ProfissionaisController::class)->prefix('profissionais')->group(function () {
        Route::get('/', 'index')->name('admin-clinica.profissionais-associados.index');
        Route::get('/create', 'create')->name('admin-clinica.profissionais-associados.create');
        Route::post('/', 'store')->name('admin-clinica.profissionais-associados.store');
        Route::get('/{id}/edit', 'edit')->name('admin-clinica.profissionais-associados.edit');
        Route::get('/{id}', 'show')-> name('admin-clinica.profissionais-associados.show');
        Route::put('/{id}', 'update')->name('admin-clinica.profissionais-associados.update');
        Route::delete('/{id}', 'destroy')->name('admin-clinica.profissionais-associados.destroy');
    });

    //Agenda
    Route::get('/agendamento/index', [AgendaController::class,'index'])->name('admin-clinica.agenda.index'); // AGENDAR HORARIO PARA O PROF.
    Route::get('/agendamento/create', [AgendaController::class,'index'])->name('admin-clinica.agenda.create'); // AGENDAR HORARIO PARA O PROF.
});

// Páginas públicas (Index e outras estáticas)
Route::name('public.')->group(function () {
    Route::view('/', 'Home/index')->name('index');
    Route::view('fale-conosco', 'Home/fale-conosco')->name('fale-conosco');
    Route::view('politicas-de-privacidade', 'Home/politicas-de-privacidade')->name('politicas');
    Route::view('sobre-a-medexame', 'Home/sobre-a-medexame')->name('sobre');
    Route::view('pagina-usuario', 'Home/paginadousuario')->name('pagina-usuario');

    // BUSCA
    Route::view('/busca', 'busca/busca');
    Route::view('/em-construcao', 'em-construcao');
});




// dashboard do usuário
Route::get('/dashboard', function () {
    return redirect()->route('profile.edit');
})->middleware(['auth', 'verified'])->name('dashboard');


// ??????
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Autenticação específica para clínicas
/*
Route::middleware('auth:clinic')->group(function () {
    Route::get('/profile2', [ProfileController::class, 'edit'])->name('profile.edit2');
    Route::patch('/profile2', [ProfileController::class, 'update'])->name('profile.update2');
    Route::delete('/profile2', [ProfileController::class, 'destroy'])->name('profile.destroy2');
});
*/



Route::get('/clinica-pendente', function () {
    return view('admin-clinica/acesso/pendente');
})->name('clinica.pendente');

Route::get('/clinica-negado', function () {
    return view('admin-clinica/acesso/negado');
})->name('clinica.negado');


Route::get('/minhasinformacoes', [ProfileController::class, 'show'])->name('profile.show');


Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');


Route::get('/admin/inbox', function () {
    return view('admin.sub-diretorios.inbox.inbox');
})->name('admin.inbox');

Route::get('/admin/inbox', [App\Http\Controllers\Admin\InboxController::class, 'index'])->name('admin.inbox');

