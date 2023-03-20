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

Route::get('alas','AlaController@index');
Route::resource('ala','AlaController');

Route::get('blocos','BlocoController@listar');
Route::get('bloco/novo','BlocoController@novo');
Route::post('bloco/salvar','BlocoController@salvar');
Route::match(['GET', 'POST'],'bloco/{bloco}/editar','BlocoController@editar');
Route::get('blocos/setor/{setor}','BlocoController@buscarBlocosPorSetor');

Route::get('eventos','EventoController@index');
Route::get('eventos/listar','EventoController@listar');
Route::get('evento/locais','EventoController@locais');
Route::get('evento/setores','EventoController@setores');
Route::get('evento/local/{id}/adicionar','EventoController@adicionarLocal');
Route::get('evento/local/{id}/remover','EventoController@removerLocal');
Route::get('evento/locais','EventoController@locais');
Route::post('evento/alterar','EventoController@alterar');
Route::resource('evento','EventoController');

Route::get('grupos','GrupoController@index');
Route::resource('grupo','GrupoController');

Route::get('locais','LocalController@listar');
Route::get('local/novo','LocalController@novo');
Route::get('local/{id}/editar','LocalController@editar');
Route::get('local/{id}/excluir','LocalController@destroy');
Route::get('local/evento','LocalController@localEvento');
Route::resource('local','LocalController');

Route::get('setores','SetorController@listar');
Route::get('setor/novo','SetorController@novo');
Route::get('setor/evento','SetorController@setorEvento');
Route::post('setor/salvar','SetorController@salvar');
Route::match(['GET', 'POST'],'setor/{setor}/editar','SetorController@editar');

Route::get('pavimentos','PavimentoController@listar');
Route::get('pavimento/novo','PavimentoController@novo');
Route::post('pavimento/salvar','PavimentoController@salvar');
Route::match(['GET', 'POST'],'pavimento/{pavimento}/editar','PavimentoController@editar');
Route::get('pavimentos/bloco/{bloco}','PavimentoController@buscarPavimentosPorBloco');

Route::get('salas','SalaController@listar');
Route::get('sala/novo','SalaController@novo');
Route::post('sala/salvar','SalaController@salvar');
Route::match(['GET', 'POST'],'sala/{sala}/editar','SalaController@editar');
