<?php
/*
 * Páginas de acesso público
 */
Route::group(['middleware' => ['web']], function () {
    //    Route::get('/', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@index');
    Route::get('seguranca/usuario', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@index');
    Route::get('seguranca/usuario/logout', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@logout');
    Route::post('seguranca/usuario/login', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@login');

    //só pra aproveitar o middleware nativo de athentication do laravel
    Route::get('/login', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@index');
});

/*
 * Telas protegidas pelo segurança que precisam carregar o menu
 */
Route::group(['middleware' => ['seguranca', 'tela-seguranca']], function () {

    Route::get('seguranca/usuario/home', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@home');

    //menu
    Route::get('seguranca/menu', 'PoliciaCivil\Seguranca\App\Http\Controllers\MenuController@index');
    Route::get('seguranca/menu/novo', 'PoliciaCivil\Seguranca\App\Http\Controllers\MenuController@novo');
    Route::get('seguranca/menu/editar/{id}', 'PoliciaCivil\Seguranca\App\Http\Controllers\MenuController@editar');

    //acao
    Route::get('seguranca/acao', 'PoliciaCivil\Seguranca\App\Http\Controllers\AcaoController@index');
    Route::get('seguranca/acao/novo', 'PoliciaCivil\Seguranca\App\Http\Controllers\AcaoController@novo');
    Route::get('seguranca/acao/editar/{id}', 'PoliciaCivil\Seguranca\App\Http\Controllers\AcaoController@editar');

    //usuario
    Route::get('seguranca/usuario/admin', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@admin');
    Route::get('seguranca/usuario/novo', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@novo');
    Route::get('seguranca/usuario/editar/{id}', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@editar');
    Route::get('seguranca/usuario/alterar-senha','PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@alterarSenha');
    Route::get('seguranca/usuario/verifica-diretor-na-unidade','PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@VerificaDiretorNaUnidade');

    //perfil
    Route::get('seguranca/perfil', 'PoliciaCivil\Seguranca\App\Http\Controllers\PerfilController@index');
    Route::get('seguranca/perfil/novo', 'PoliciaCivil\Seguranca\App\Http\Controllers\PerfilController@novo');
    Route::get('seguranca/perfil/editar/{id}', 'PoliciaCivil\Seguranca\App\Http\Controllers\PerfilController@editar');
});

/*
 * Ações protegidas pelo segurança que não precisam de menu (ajax, pdfs, imagens ...)
 */
Route::group(['middleware' => ['seguranca']], function () {

    //menu
    Route::get('seguranca/menu/grid', 'PoliciaCivil\Seguranca\App\Http\Controllers\MenuController@grid');
    Route::post('seguranca/menu/store', 'PoliciaCivil\Seguranca\App\Http\Controllers\MenuController@store');
    Route::post('seguranca/menu/update', 'PoliciaCivil\Seguranca\App\Http\Controllers\MenuController@update');
    Route::post('seguranca/menu/excluir', 'PoliciaCivil\Seguranca\App\Http\Controllers\MenuController@excluir');

    //acao
    Route::get('seguranca/acao/grid', 'PoliciaCivil\Seguranca\App\Http\Controllers\AcaoController@grid');
    Route::post('seguranca/acao/store', 'PoliciaCivil\Seguranca\App\Http\Controllers\AcaoController@store');
    Route::post('seguranca/acao/update', 'PoliciaCivil\Seguranca\App\Http\Controllers\AcaoController@update');
    Route::post('seguranca/acao/excluir', 'PoliciaCivil\Seguranca\App\Http\Controllers\AcaoController@excluir');

    //usuario
    Route::get('seguranca/usuario/grid', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@grid');
    Route::post('seguranca/usuario/store', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@store');
    Route::post('seguranca/usuario/update', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@update');
    Route::post('seguranca/usuario/excluir', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@excluir');
    Route::post('seguranca/usuario/atualizar-senha', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@atualizarSenha'
    );
    Route::post('seguranca/usuario/atualizar-dados', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@atualizarDados'
    );

    //usuario-ajuda
    Route::get('seguranca/usuario/editar-ajuda', 'PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioController@editarAjuda'
    );

    //perfil
    Route::get('seguranca/perfil/grid', 'PoliciaCivil\Seguranca\App\Http\Controllers\PerfilController@grid');
    Route::post('seguranca/perfil/store', 'PoliciaCivil\Seguranca\App\Http\Controllers\PerfilController@store');
    Route::post('seguranca/perfil/update', 'PoliciaCivil\Seguranca\App\Http\Controllers\PerfilController@update');
    Route::post('seguranca/perfil/excluir', 'PoliciaCivil\Seguranca\App\Http\Controllers\PerfilController@excluir');
});
