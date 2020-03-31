<?php

/*
|--------------------------------------------------------------------------
| Rotas do Sistema
|--------------------------------------------------------------------------
|
| 
*/
//Pesquisa Esquipamento
Route::get('/equipamento/index', 'EquipamentoController@index');
// Route::get('/equipamento/gridPesquisa', 'EquipamentoController@gridPesquisa'); 
Route::post('/equipamento/gridPesquisaa',   'EquipamentoController@gridPesquisaa');

//Novo Equipamento 
Route::get('/equipamento/novo', 'EquipamentoController@novoEquipamento');
Route::post('/equipamento/gridPesquisa', 'EquipamentoController@gridPesquisa');
Route::post('/equipamento/store', 'EquipamentoController@createNovoEquipamento');

//Entrada de Equipamento
Route::get('/equipamento/entrada', 'EquipamentoController@equipamentoEntrada');
Route::post('/equipamento/gridEntrada', 'EquipamentoController@gridEntrada');
Route::post('/equipamento/storeEntrada', 'EquipamentoController@createEquipamentoEntrada');

//Pesquisa Servidor
Route::get('/servidor/index', 'ServidorController@servidor');
//Novo Servidor
Route::get('/servidor/novo', 'ServidorController@novoServidor');
Route::post('/servidor/store', 'ServidorController@createServidor');
Route::post('/servidor/edit', 'ServidorController@editaServidor');

//Abertura de Ordem de Serviço 
Route::get('/servidor/ordem_servico', 'ServidorController@aberturaDeordemServico');

//Saida de Equipamento
Route::get('/equipamento/saida', 'EquipamentoController@equipamentoSaida');