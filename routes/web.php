<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileController2;
use Illuminate\Support\Facades\Route;

// Importação de Controller's
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

use App\Http\Controllers\Admin_clinica\DashboardClinicaController;


// Inclusão das rotas de autenticação
require __DIR__ . '/auth.php';
require __DIR__ . '/auth2.php';


// Rotas que exigem autenticação de user e têm o prefixo 'admin'
Route::middleware('auth', 'verified')->prefix('admin')->group(function () {
    
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
    Route::get('/dashboard', [DashboardClinicaController::class, 'index'])->name('admin-clinica.dashboard.index'); // DASHBOARD - EM BRANCO
    //Route::get('/profissionais', ['','dashboard'])->name('admin.clinica.servicos'); // Listagem de serviços
    //Route::get('/localização', ['','dashboard'])->name('admin.clinica.clinica'); //SOBRE A CLÍNICA
    //Route::get('/profissionais', ['','dashboard'])->name('admin.clinica.dashboard'); // VISUALIZAR OS PROCEDIMENTOS DISP. E  OS CADASTRADOS.
    //Route::get('/profissionais', ['','dashboard'])->name('admin.clinica.dashboard'); // CADASTRAR PROFISSIONAIS
    //Route::get('/profissionais', ['','dashboard'])->name('admin.clinica.dashboard'); // VISUALIZAR PROFISSIONAIS
    //Route::get('/agendamento', ['','dashboard'])->name('admin.clinica.dashboard'); // AGENDAR HORARIO PARA O PROF.
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

//gate para dashboard
Route::middleware(['auth', 'can:access'])->prefix('admin')->group(function () {
    // Dashboard
    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('/', 'index')->name('admin.dashboard.admin');
    });
});


Route::get('/clinica-pendente', function () {
    return view('admin-clinica/acesso/pendente');
})->name('clinica.pendente');

Route::get('/clinica-negado', function () {
    return view('admin-clinica/acesso/negado');
})->name('clinica.negado');


Route::get('/minhasinformacoes', [ProfileController::class, 'show'])->name('profile.show');



