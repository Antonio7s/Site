<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileController2;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\HomeController;

//Importacao de controller de pagamento
use App\Http\Controllers\Pagamento\PagamentoController;


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

//Asaas
use App\Http\Controllers\AsaasController;


// Inclusão das rotas de autenticação
require __DIR__ . '/auth.php';
require __DIR__ . '/auth2.php';


use Illuminate\Auth\Notifications\VerifyEmail;
//use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('perfil.edit'); // Ajuste para seu redirecionamento
})->name('verification.verify');

// Rotas que exigem AUTENTICACAO de user e AUTORIZAÇÃO de admin e têm o prefixo 'admin'.
Route::middleware('auth', 'verified', 'can:access')->prefix('admin')->group(function () {
    
    //Dashboard
    Route::controller(DashboardController::class)->prefix('dashboard')->group(function (){
        Route::get('/', 'index')->name('admin.dashboard.admin');
    });

    // Clínicas
    Route::controller(ClinicaController::class)->prefix('clinicas')->group(function (){
        Route::get('/', 'index')->name('admin.clinicas.index');
        Route::get('/create', 'create')->name('admin.clinicas.create');
        Route::get('/{id}/edit', 'edit')->name('admin.clinicas.edit');
        Route::put('/{id}',  'update')->name('admin.clinicas.update');
        Route::get('/{id}/show',  'show')->name('admin.clinicas.show');
        Route::delete('/{id}',  'destroy')->name('admin.clinicas.destroy');

        // Clínicas - Análise de cadastros
        Route::get('/solicitacoes-de-cadastro',  'solicitacoes_de_cadastro')->name('admin.clinicas.solicitacoes');
        Route::match(['get', 'post'], '/solicitacoes-de-cadastro/{id}/analise',  'analise')->name('admin.clinicas.solicitacoes-de-cadastro.analise');
        Route::get('/{id}/download',  'download')->name('admin.clinicas.download');
    });

    // Usuários
    Route::controller(UsuarioController::class)->prefix('usuarios')->group(function (){
        Route::get('/', 'index')->name('admin.usuarios.index');
        Route::get('/{id}/edit', 'edit')->name('admin.usuarios.edit');
        Route::put('/{id}',  'update')->name('admin.usuarios.update');
        Route::get('/{id}/show',  'show')->name('admin.usuarios.show');
        Route::delete('/{id}',  'destroy')->name('admin.usuarios.destroy');
    });

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

    Route::get('contatos', [ContatoController::class, 'index'])->name('admin.contatos.index');


    //homepage
    /*
    Route::controller(HomeController::class)->prefix('home')->group(function () {
        Route::get('/', 'index')->name('admin.home.index');
        Route::post('/save', 'save')->name('admin.home.save');
    });
    */

    Route::post('/homepage/save', [HomepageController::class, 'save'])->name('admin.homepage.save');
    Route::get('/homepage', [HomepageController::class, 'index'])->name('admin.homepage.index');
    
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
    Route::controller(AgendaController::class)->prefix('agenda')->group(function () {
        //Agendamento
        Route::get('/index','index')->name('admin-clinica.agenda.index');

        Route::get('agendamento/index', 'agendamento_index')->name('admin-clinica.agenda.agendamento.index'); 
        //Route::get('agendamento/create', 'agendamento_create')->name('admin-clinica.agenda.agendamento.create'); 
        //Route::get('agendamento/show', 'agendamento_show')->name('admin-clinica.agenda.agendamento.create');

        //Horario
        //Route::get('/horario/index', 'horario_index')->name('admin-clinica.agenda.horario.index');
        Route::get('/horario/create', 'horario_create')->name('admin-clinica.agenda.horario.create');
        Route::get('/horario/show', 'horario_show')->name('admin-clinica.agenda.horario.show');

        /*
        Route::get('/search-medicos', [AgendaController::class, 'search'])->name('admin-clinica.agenda.search');
        // Rota para pegar a agenda do profissional
        Route::get('/agenda/getAgenda', [AgendaController::class, 'getAgenda'])->name('admin-clinica.agenda.getAgenda');
        // Rota para pegar os horários da agenda
        Route::get('/agenda/getHorarios', [AgendaController::class, 'getHorarios'])->name('admin-clinica.agenda.getHorarios');
        */
    });

});


// dashboard do usuário
/*
Route::get('/dashboard', function () {
    return redirect()->route('profile.edit');
})->middleware(['auth', 'verified'])->name('dashboard'); 
*/

//ROTAS QUE EXIGEM AUTENTICACAO DE USUARIO
Route::middleware('auth', 'verified')->group(function () {
    
    //Rotas do perfil do usuario
    Route::controller(ProfileController::Class)->prefix('perfil')->group(function () {
        Route::get('/', 'edit')->name('perfil.edit');
        Route::patch('/', 'update')->name('perfil.update');
        Route::delete('/', 'destroy')->name('perfil.destroy');

        Route::get('/minhas-informacoes', 'minhasInformacoes')->name('perfil.minhasInformacoes');
        Route::get('/agendamentos', 'agendamento')->name('perfil.agendamentos');
        Route::get('/meus-pedidos', 'meusPedidos')->name('perfil.meusPedidos');
    });

    //Rotas de checkout
    Route::controller(PagamentoController::class)->prefix('pagamento')->group(function () {
        Route::get('/', 'index')->name('pagamento.index');
        Route::post('/pagamento/gerar-pix', 'gerarPix')->name('pagamento.gerarPix');
        Route::post('/pagamento/gerar-boleto', 'gerarBoleto')->name('pagamento.gerarBoleto');
        Route::post('/finalizar-cartao', 'finalizarCartao')->name('pagamento.finalizarCartao');

        // Views de pagamento
        Route::get('pagamento-pix', 'pagamentoPix')->name('pagamento.pagamentoPix');
        Route::get('pagamento-boleto', 'pagamentoBoleto')->name('pagamento.pagamentoBoleto');
        
        // Views de falha no pagamento
        Route::get('falha-pix', 'falhaPix')->name('pagamento.falhaPix');
        Route::get('falha-boleto', 'falhaBoleto')->name('pagamento.falhaBoleto');
        
        //Views de Sucesso
        Route::get('sucesso-pix', 'sucessoPix')->name('pagamento.sucessoPix');
        
        //Aguardando pagamento
        Route::get('/verificar-pagamento', 'verificarPagamento');
    });
});

// Autenticação específica para clínicas
/*
Route::middleware('auth:clinic')->group(function () {
    Route::get('/profile2', [ProfileController::class, 'edit'])->name('profile.edit2');
    Route::patch('/profile2', [ProfileController::class, 'update'])->name('profile.update2');
    Route::delete('/profile2', [ProfileController::class, 'destroy'])->name('profile.destroy2');
});
*/


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


Route::get('/clinica-pendente', function () {
    return view('admin-clinica/acesso/pendente');
})->name('clinica.pendente');

Route::get('/clinica-negado', function () {
    return view('admin-clinica/acesso/negado');
})->name('clinica.negado');




Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/homepage/save', [HomepageController::class, 'save'])->name('admin.homepage.save');
});



// Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home.index');
// Route::post('/admin/home/save', [HomeController::class, 'save'])->name('admin.homepage.save');

//Asaas
Route::post('/asaas/webhook', [AsaasController::class, 'webhook']);



