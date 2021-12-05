<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::resource('usuarios', 'UsuariosController');
    Route::resource('clientes', 'ClientesController');
    Route::resource('fluxos', 'FluxosController');
    Route::resource('recorrencias', 'RecorrenciasController');
    Route::get('/categorias/{tipo_categoria}', 'CategoriasController@getCategorias');
});
