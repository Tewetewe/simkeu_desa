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
	Route::resource('/pengeluaran', 'PengeluaranController');

	Route::get('/detailpendapatan/create/{id}', 'PendapatanController@createDetail')->name('createDetailPendapatan');
	Route::post('/detailpendapatan/create/{id}', 'PendapatanController@storeDetail');
	Route::get('/detailpendapatan/edit/{id}', 'PendapatanController@editDetail');
	Route::put('/detailpendapatan/edit/{id}', 'PendapatanController@updateDetail');
	Route::delete('/detailpendapatan/delete/{id}', 'PendapatanController@destroyDetail');

	Route::get('/detailpengeluaran/create/{id}', 'PengeluaranController@createDetail')->name('createDetailPengeluaran');
	Route::post('/detailpengeluaran/create/{id}', 'PengeluaranController@storeDetail');
	Route::get('/detailpengeluaran/edit/{id}', 'PengeluaranController@editDetail');
	Route::put('/detailpengeluaran/edit/{id}', 'PengeluaranController@updateDetail');
	Route::delete('/detailpengeluaran/delete/{id}', 'PengeluaranController@destroyDetail');

	Route::get('findSubKategori/{id}', 'PendapatanController@findSubKategori');
	Route::get('findSub2Kategori/{id}', 'PendapatanController@findSub2Kategori');

	Route::get('/reportPendapatan/filter', 'ReportController@reportPendapatanFilter');
	Route::get('/reportPendapatan', 'ReportController@reportPendapatan');

	Route::get('/reportPengeluaran/filter', 'ReportController@reportPengeluaranFilter');
	Route::get('/reportPengeluaran', 'ReportController@reportPengeluaran');

	Route::get('/reportTransaksi/filter', 'ReportController@reportTransaksiFilter');
	Route::get('/reportTransaksi', 'ReportController@reportTransaksi');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

