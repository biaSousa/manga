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
// Route::get('/equipamento/grid_equipamento_entrada',   'EquipamentoController@gridEquipamentoEntrada');
// Route::post('/equipamento/store_equipamento_entrada', 'EquipamentoController@createEquipamentoEntrada');

//Saida de Equipamento
// Route::get('/equipamento/saida',  'EquipamentoController@equipamentoSaida');