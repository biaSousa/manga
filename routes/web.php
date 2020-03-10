<?php

/*
|--------------------------------------------------------------------------
| Rotas do Sistema
|--------------------------------------------------------------------------
|
| 
*/

//Novo Equipamento
Route::get('/equipamento/index',  'EquipamentoController@index');
Route::get('/equipamento/novo',   'EquipamentoController@novoEquipamento');
Route::post('/equipamento/store', 'EquipamentoController@createNovoEquipamento');

//Entrada de Equipamento
Route::get('/equipamento/entrada', 'EquipamentoController@equipamentoEntrada');
Route::post('/equipamento/storeEntrada', 'EquipamentoController@createEquipamentoEntrada');
Route::get('/equipamento/grid',   'EquipamentoController@gridEquipamentoEntrada');

//Saida de Equipamento
// Route::get('/equipamento/saida',  'EquipamentoController@equipamentoSaida');