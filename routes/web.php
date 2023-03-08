<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('locais','LocalController@listar');
Route::get('local/novo','LocalController@novo');
Route::get('local/{id}/excluir','LocalController@destroy');

Route::get('setores','SetorController@listar');
Route::get('setor/novo','SetorController@novo');
Route::post('setor/salvar','SetorController@salvar');
Route::match(['GET', 'POST'],'setor/{setor}/editar','SetorController@editar');

Route::get('blocos','BlocoController@listar');
Route::get('bloco/novo','BlocoController@novo');
Route::post('bloco/salvar','BlocoController@salvar');
Route::match(['GET', 'POST'],'bloco/{bloco}/editar','BlocoController@editar');
