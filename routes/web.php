<?php

/*
|--------------------------------------------------------------------------
| Rotas do Sistema
|--------------------------------------------------------------------------
|
| 
*/
//Pesquisa Esquipamento (index.blade.php)
Route::get('/equipamento/index',           'EquipamentoController@index');
// Route::get('/equipamento/gridPesquisa', 'EquipamentoController@gridPesquisa'); 
Route::get('/equipamento/gridPesquisaa',   'EquipamentoController@gridPesquisaa');

//Novo Equipamento (novo.blade.php)
Route::get('/equipamento/novo',      'EquipamentoController@novoEquipamento');
Route::post('/equipamento/store',    'EquipamentoController@createNovoEquipamento');
// Route::post('/equipamento/edita', 'EquipamentoController@editaNovoEquipamento');

//Entrada de Equipamento (entrada.blade.php)
Route::get('/equipamento/entrada',       'EquipamentoController@equipamentoEntrada');
Route::get('/equipamento/gridEntrada',   'EquipamentoController@gridEntrada');
Route::post('/equipamento/storeEntrada', 'EquipamentoController@createEquipamentoEntrada');

//Saida de Equipamento (saida.blade.php)
// Route::get('/equipamento/saida',  'EquipamentoController@equipamentoSaida');