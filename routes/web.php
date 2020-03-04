<?php

/*
|--------------------------------------------------------------------------
| Rotas do Sistema
|--------------------------------------------------------------------------
|
| 
*/

//Novo Equipamento
Route::get('/', 'EquipamentoController@index');
Route::get('/equipamento/saida',   'EquipamentoController@saida');
Route::get('/equipamento/entrada', 'EquipamentoController@entrada');
Route::get('/participante/create', 'EquipamentoController@create');
Route::post('/participante/store', 'EquipamentoController@store');

//Entrega de Equipamento
Route::get('/evento', 'EquipamentoController@evento');
Route::get('/evento/salva-evento', 'EquipamentoController@salvaEvento');

//Recebimento de Equipamento
Route::get('/realizadores', 'EquipamentoController@realizadores');
