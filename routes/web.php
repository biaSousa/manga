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
Route::post('/equipamento/gridPesquisaa',   'EquipamentoController@gridPesquisaa');

//Novo Equipamento (novo.blade.php)
Route::get('/equipamento/novo',   'EquipamentoController@novoEquipamento');
Route::post('/equipamento/gridPesquisa', 'EquipamentoController@gridPesquisa');
Route::post('/equipamento/store', 'EquipamentoController@createNovoEquipamento');
// Route::post('/equipamento/edita', 'EquipamentoController@editaNovoEquipamento');

//Entrada de Equipamento (entrada.blade.php)
Route::get('/equipamento/entrada', 'EquipamentoController@equipamentoEntrada');
Route::post('/equipamento/gridEntrada',  'EquipamentoController@gridEntrada');
Route::post('/equipamento/storeEntrada', 'EquipamentoController@createEquipamentoEntrada');

//Abertura de Ordem de Serviço (ordem_servico.blade.php)
Route::get('/servidor/ordem_servico',  'ServidorController@AberturaDeordemServico');
// Route::get('/servidor/servidor_novo',  'ServidorController@Servidor');
// Route::post('/servidor/store_os',      'ServidorController@createOrdemServico');

//Saida de Equipamento (saida.blade.php)
Route::get('/equipamento/saida',  'EquipamentoController@equipamentoSaida');