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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::resource('/kategori', 'KategoriController');
	Route::resource('/subkategori', 'SubKategoriController');
	Route::resource('/sub2kategori', 'Sub2KategoriController');
	Route::resource('/item', 'ItemController');
	Route::resource('/pendapatan', 'PendapatanController');
	Route::resource('/pengeluaran', 'DetailTransaksiController');
	Route::resource('/detailpengeluaran', 'DetailPengeluaranController');
	Route::get('findSubKategori/{id}', 'PendapatanController@findSubKategori');
	Route::get('findSub2Kategori/{id}', 'PendapatanController@findSub2Kategori');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

