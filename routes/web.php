<?php
use App\Http\Controllers\ProfileController;
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


// Rota do usuario
Route::get('/Pagina-usuario', function () {
    return view('/Home/paginadousuario');
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
})->middleware(['auth:clinic'])->name('admin-clinica');

//CLINICA INDEX
Route::get('/clinica', function () {
    return view('/Clinica/Paginaclinica');
});


// BUSCA
Route::get('/busca', function () {
    return view('/busca/busca');
});

Route::get('/em-construcao', function () {
    return view('em-construcao');
});


////////////////////////////////////////////////////


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


////////////////////////////////////////////2
use App\Http\Controllers\ProfileController2;


/*
Route::get('/dashboard2', function () {
    return view('dashboard2');
})->middleware(['auth:clinic', 'verified'])->name('dashboard2');
*/

Route::middleware('auth:clinic')->group(function () {
    Route::get('/profile2', [ProfileController2::class, 'edit'])->name('profile.edit2');
    Route::patch('/profile2', [ProfileController2::class, 'update'])->name('profile.update2');
    Route::delete('/profile2', [ProfileController2::class, 'destroy'])->name('profile.destroy2');
});

require __DIR__.'/auth2.php';
