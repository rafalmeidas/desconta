<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function(){

    Route::get('get_compras/{idUsuario}/{idEmpresa}', 'ApiController@GetCompras');
    Route::get('get_parcelas/{idCompra}/', 'ApiController@GetParcelas');
    Route::get('get_usuarioComUid/{uid}', 'ApiController@getUsuarioComUid');
    Route::get('get_usuarioComCpf/{cpf}', 'ApiController@getUsuarioComCpf');
    Route::get('get_empresas/{id}', 'ApiController@GetEmpresas');
    Route::get('get_cidade/{id}', 'ApiController@GetCidade');
    Route::get('get_cidadeEstado/{idPessoa}', 'ApiController@GetCidadeEstado');
    Route::get('get_cidades/{idEstado}', 'ApiController@GetCidades');
    Route::post('set_usuario/{email}/{uid}', 'ApiController@setUsuario');
    Route::patch('update_usuario/{id}/{email}/{uid}', 'ApiController@UpUsuario');
    Route::patch('pagar_parcela/{idParcela}', 'ApiController@PagarParcela');
    Route::patch('up_pessoa/{idPessoa}', 'ApiController@AtualizarPessoa');
    Route::patch('up_endereco/{idPessoa}', 'ApiController@AtualizarEndereco');
});
