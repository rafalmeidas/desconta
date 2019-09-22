<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::any('historic-search', 'BalanceController@searchHistoric')->name('historic.search');
    Route::get('historic', 'BalanceController@historic')->name('admin.historic');

    Route::get('balance', 'BalanceController@index')->name('admin.balance');

    Route::get('deposit', 'BalanceController@deposit')->name('balance.deposit');
    Route::post('deposit', 'BalanceController@depositStore')->name('deposit.store');


    Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');
    Route::post('transfer', 'BalanceController@transferStore')->name('transfer.store');
    Route::post('confirm-transfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');

    Route::get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');
    Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');

    Route::get('/', 'AdminController@index')->name('admin.home');
});

Route::group(['middleware' => ['auth'], 'namespace' => 'Painel', 'prefix' => 'painel'], function () {
    Route::resource('estado','EstadoController');
    Route::resource('cidade','CidadeController');
    Route::resource('pessoa','PessoaController');
    Route::resource('empresa','EmpresaController');
    Route::resource('usuario','UsuarioController');
    Route::resource('compra','CompraController');
});

//Rota de envio do xml
Route::group(['middleware' => ['auth'], 'namespace' => 'Painel'], function () {
    Route::any('painel/compra/create', 'CompraController@xml')->name('compra.xml');
});

//Rotas API
Route::group(['namespace' => 'Api'], function(){
    Route::get('get_compra', 'ApiController@getCompra');
    Route::get('get_estado', 'ApiController@getEstado');
});

Route::post('atualizar_perfil', 'Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');
Route::get('meu_perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();
