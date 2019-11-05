<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/show/empresa', 'AdminController@showEmpresa')->name('admin.empresa');
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
    Route::post('painel/compra/create', 'CompraController@createCrompra')->name('compra.create-compra');
    Route::post('painel/compra/xml', 'CompraController@xml')->name('compra.xml');
});

//Rota de relatórios
Route::group(['middleware' => ['auth'], 'namespace' => 'Painel'], function () {
    

    Route::any('painel/relatorio/gerarFinaceiro', 'RelatorioFinanceiroController@selecionaRelatorio')->name('relatorioF.gerar');
    Route::any('painel/relatorio/financeiro', 'RelatorioFinanceiroController@index')->name('index.financeiro');

    Route::any('painel/relatorio', 'RelatorioCompraController@relatorioCompra')->name('relatorio.compra');
    Route::any('painel/relatorio/gerarCompra', 'RelatorioCompraController@selecionaRelatorio')->name('relatorio.gerar');
    Route::any('painel/relatorio/compra', 'RelatorioCompraController@index')->name('index.compra');
    
});

Route::post('atualizar_perfil', 'Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');
Route::get('meu_perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();
