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

Route::prefix('carrinho')->name('carrinho.')->group(function(){
    Route::post('adicionar', 'CarrinhoController@adicionar')->name('adicionar');
    Route::get('/', 'CarrinhoController@index')->name('carrinho');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
