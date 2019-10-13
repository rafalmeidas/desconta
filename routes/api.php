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

    Route::get('get_usuarioComUid/{uid}', 'ApiController@getUsuarioComUid');
    Route::get('get_usuarioComCpf/{cpf}', 'ApiController@getUsuarioComCpf');
    Route::post('set_usuario', 'ApiController@setUsuario');
});
