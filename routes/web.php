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
	Route::resource('/kategori', 'KategoriController')->middleware('admin');
	Route::resource('/subkategori', 'SubKategoriController')->middleware('admin');
	Route::resource('/sub2kategori', 'Sub2KategoriController')->middleware('admin');
	Route::resource('/item', 'ItemController')->middleware('admin');
	Route::resource('/pendapatan', 'PendapatanController')->middleware('admin');
	Route::resource('/pengeluaran', 'PengeluaranController')->middleware('admin');

	Route::get('/detailpendapatan/create/{id}', 'PendapatanController@createDetail')->name('createDetailPendapatan')->middleware('admin');
	Route::post('/detailpendapatan/create/{id}', 'PendapatanController@storeDetail')->middleware('admin');
	Route::get('/detailpendapatan/edit/{id}', 'PendapatanController@editDetail')->middleware('admin');
	Route::put('/detailpendapatan/edit/{id}', 'PendapatanController@updateDetail')->middleware('admin');
	Route::delete('/detailpendapatan/delete/{id}', 'PendapatanController@destroyDetail')->middleware('admin');

	Route::get('/detailpengeluaran/create/{id}', 'PengeluaranController@createDetail')->name('createDetailPengeluaran')->middleware('admin');
	Route::post('/detailpengeluaran/create/{id}', 'PengeluaranController@storeDetail')->middleware('admin');
	Route::get('/detailpengeluaran/edit/{id}', 'PengeluaranController@editDetail')->middleware('admin');
	Route::put('/detailpengeluaran/edit/{id}', 'PengeluaranController@updateDetail')->middleware('admin');
	Route::delete('/detailpengeluaran/delete/{id}', 'PengeluaranController@destroyDetail')->middleware('admin');

	Route::get('findSubKategori/{id}', 'PendapatanController@findSubKategori');
	Route::get('findSub2Kategori/{id}', 'PendapatanController@findSub2Kategori');

	Route::get('/reportPendapatan/filter', 'ReportController@reportPendapatanFilter');
	Route::get('/reportPendapatan', 'ReportController@reportPendapatan');
	Route::get('/reportPendapatan/pdf', 'ReportController@reportPendapatanPDF');


	Route::get('/reportPengeluaran/filter', 'ReportController@reportPengeluaranFilter');
	Route::get('/reportPengeluaran', 'ReportController@reportPengeluaran');
	Route::get('/reportPengeluaran/pdf', 'ReportController@reportPengeluaranPDF');


	Route::get('/reportTransaksi/filter', 'ReportController@reportTransaksiFilter');
	Route::get('/reportTransaksi', 'ReportController@reportTransaksi');
	Route::get('/reportTransaksi/pdf', 'ReportController@reportTransaksiPDF');


	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

