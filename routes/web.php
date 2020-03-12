<?php

/*
|--------------------------------------------------------------------------
| Rotas do Sistema
|--------------------------------------------------------------------------
|
| 
*/
//Pesquisa Esquipamento (index.blade.php)
Route::get('/equipamento/index',  'EquipamentoController@index');

//Novo Equipamento (novo.blade.php)
Route::get('/equipamento/novo',   'EquipamentoController@novoEquipamento');
Route::get('/equipamento/gridPesquisa', 'EquipamentoController@gridPesquisa');
Route::post('/equipamento/store', 'EquipamentoController@createNovoEquipamento');

//Entrada de Equipamento (entrada.blade.php)
Route::get('/equipamento/entrada', 'EquipamentoController@equipamentoEntrada');
Route::get('/equipamento/grid',   'EquipamentoController@gridEquipamentoEntrada');
Route::post('/equipamento/storeEntrada', 'EquipamentoController@createEquipamentoEntrada');

//Saida de Equipamento (saida.blade.php)
// Route::get('/equipamento/saida',  'EquipamentoController@equipamentoSaida');