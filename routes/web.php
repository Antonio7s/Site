<?php

use Illuminate\Support\Facades\Route;


// INDEX

Route::get('/', function () {
    return view('/Home/index');
});

Route::get('/fale-conosco', function () {
    return view('/Home/fale-conosco');
});

Route::get('/politicas-de-privacidade', function () {
    return view('/Home/politicas-de-privacidade');
});

Route::get('/sobre-a-medexame', function () {
    return view('/Home/sobre-a-medexame');
});


// LOGIN E CADASTRO

Route::get('/login', function () {
    return view('/login');
});

Route::get('/redirecionar-login', function () {
    return view('/login/redirecionar-login');
});

Route::get('/login-paciente', function () {
    return view('/login/login-paciente');
});

Route::get('/login-clinica', function () {
    return view('/login/login-clinica');
});

Route::get('/cadastro', function () {
    return view('/cadastro/cadastro');
});

Route::get('/cadastro/analise', function () {
    return view('/cadastro/poscadrastro');
});

//ADMIN DO SITE

Route::get('/admin', function () {
    return view('/admin/login');
});

Route::get('/admin/dashboard', function () {
    return view('/admin/sub-diretorios/dashboard/vendas');
});

        Route::get('/admin/clinicas1', function () {
            return view('/admin/sub-diretorios/clinicas/clinicas');
        });

        Route::get('/admin/clinicas2', function () {
            return view('/admin/sub-diretorios/clinicas/registro-de-clinica');
        });

        Route::get('/admin/clinicas3', function () {
            return view('/admin/sub-diretorios/clinicas/solicitacoes-de-cadastro');
        });

        Route::get('/admin/clinicas4', function () {
            return view('/admin/sub-diretorios/clinicas/analise');
        });

        Route::get('/admin/clinicas5', function () {
            return view('/admin/sub-diretorios/clinicas/detalhes');
        });

Route::get('/admin/usuarios', function () {
    return view('/admin/sub-diretorios/usuarios');
});

Route::get('/admin/especialidades', function () {
    return view('/admin/sub-diretorios/especialidades');
});

    Route::get('/admin/especialidades2', function () {
        return view('/admin/sub-diretorios/especialidades-add');
    });

Route::get('/admin/classes', function () {
    return view('/admin/sub-diretorios/classes');
});

    Route::get('/admin/classes2', function () {
        return view('/admin/sub-diretorios/classes-add');
    });


Route::get('/admin/procedimentos', function () {
    return view('/admin/sub-diretorios/procedimentos');
});

    Route::get('/admin/procedimentos2', function () {
        return view('/admin/sub-diretorios/procedimentos-add');
    });


Route::get('/admin/relatorios', function () {
    return view('/admin/sub-diretorios/relatorios');
});

Route::get('/admin/contatos', function () {
    return view('/admin/sub-diretorios/contatos');
});

Route::get('/admin/homepage', function () {
    return view('admin/sub-diretorios/homepage');
});

Route::get('/admin/mensagens', function () {
    return view('/admin/sub-diretorios/inbox');
});

Route::get('/admin/lucro', function () {
    return view('/admin/sub-diretorios/lucro');
});

Route::get('/admin/servicos-diferenciados1', function () {
    return view('/admin/sub-diretorios/servicos-diferenciados/visualizar');
});

    Route::get('/admin/servicos-diferenciados2', function () {
        return view('/admin/sub-diretorios/servicos-diferenciados/adicionar');
    });

// ADMIN DA CLINICA
Route::get('/admin-clinica', function () {
    return view('/Clinica/Adminclinica');
});

// BUSCA
Route::get('/busca', function () {
    return view('/busca/busca');
});

Route::get('/em-construcao', function () {
    return view('em-construcao');
});


//pagina do usuario
Route::get('/pagusuario', function () {
    return view('/Home/paginadousuario');
});
