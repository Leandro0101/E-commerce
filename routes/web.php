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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/categoria/{categoria}', 'HomeController@exibirPorCategoria')->name('exibirPorCategoria');
Route::get('produto/{slug}', 'HomeController@produto')->name('produto');
Route::group(['middleware' => 'auth'], function () {
    Route::view('admin', 'layouts.index');
    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
        Route::resource('produto', 'ProdutoController');
        Route::resource('user', 'UserController');
        Route::resource('categoria', 'CategoriaController');
        Route::post('foto/delete', 'ProdutoFotoController@removeFoto')->name('foto.delete');
    });
});

Route::prefix('carrinho')->name('carrinho.')->group(function () {
    Route::post('adicionar', 'CarrinhoController@adicionar')->name('adicionar');
    Route::get('/', 'CarrinhoController@index')->name('carrinho');
    Route::get('remover/{slug}', 'CarrinhoController@remover')->name('remover');
    Route::get('cancelar', 'CarrinhoController@cancelar')->name('cancelar');
});

Route::prefix('comentario')->name('comentario.')->group(function(){
    Route::post('adicionar/{slug}', 'ComentarioController@adicionar')->name('adicionar');
});

Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('criar', 'ClienteController@criar')->name('criar');
    Route::post('store', 'ClienteController@store')->name('store');
    Route::get('login', 'ClienteController@login')->name('login');
    Route::get('autenticacao', 'ClienteController@autenticacao')->name('autenticacao');
    Route::get('sair', 'ClienteController@sair')->name('sair');
    Route::get('edit/{id}', 'ClienteController@edit')->name('edit');
    Route::put('atualizacao/{id}', 'ClienteController@atualizacao')->name('atualizacao');
    Route::get('removerFoto/{cliente}', 'ClienteController@removerFoto')->name('removerFoto');
    Route::get('atualizacaoEspecifica/{cliente}', 'ClienteController@atualizacaoEspecifica')->name('atualizacaoEspecifica');
});


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
