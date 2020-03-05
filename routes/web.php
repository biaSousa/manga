<?php

/*
|--------------------------------------------------------------------------
| Rotas do Sistema
|--------------------------------------------------------------------------
|
| 
*/

//Novo Equipamento
Route::get('/equipamento/novo',   'EquipamentoController@novoEquipamento');
Route::get('/equipamento/index2', 'EquipamentoController@index2');
Route::post('/equipamento/store', 'EquipamentoController@createEquipamento');
Route::get('/equipamento/saida',  'EquipamentoController@saida');

//Entrega de Equipamento
Route::get('/equipamento/entrada', 'EquipamentoController@entrada');
Route::get('/evento/salva-evento', 'EquipamentoController@salvaEvento');

//Recebimento de Equipamento
Route::get('/realizadores', 'EquipamentoController@realizadores');