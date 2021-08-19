<?php

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


Route::name('Master.')->namespace('Master')->prefix('Master')->group(function () {

	/*Pengguna*/
	Route::name('Pengguna.')->namespace('Pengguna')->prefix('Pengguna')->group(function () {
		Route::get('/', 'PenggunaController@index')->name('index');
		Route::get('/getdata', 'PenggunaController@getdata')->name('getdata');
		Route::get('/destroy/{id}', 'PenggunaController@destroy')->name('destroy');
		Route::get('/edit/{id}', 'PenggunaController@edit')->name('edit');
		Route::post('store', 'PenggunaController@store')->name('store');
	});

    /*Barang*/
	Route::name('Barang.')->namespace('Barang')->prefix('Barang')->group(function () {
		Route::get('/', 'BarangController@index')->name('index');
		Route::get('/getdata', 'BarangController@getdata')->name('getdata');
		Route::get('/destroy/{id}', 'BarangController@destroy')->name('destroy');
		Route::get('/edit/{id}', 'BarangController@edit')->name('edit');
		Route::post('store', 'BarangController@store')->name('store');
	});

});


Route::name('Permintaan.')->namespace('Permintaan')->prefix('Permintaan')->group(function () {

    Route::get('/', 'PermintaanController@index')->name('index');
    Route::get('/getdata', 'PermintaanController@getdata')->name('getdata');
    Route::get('/destroy/{id}', 'PermintaanController@destroy')->name('destroy');
    Route::get('/edit/{id}', 'PermintaanController@edit')->name('edit');
    Route::post('store', 'PermintaanController@store')->name('store');

    Route::post('simpanbarang', 'PermintaanController@simpanbarang')->name('simpanbarang');
    Route::get('/getbarang/{id}', 'PermintaanController@getbarang')->name('getbarang');
    Route::get('/hapusbarang/{id}', 'PermintaanController@hapusbarang')->name('hapusbarang');


    Route::get('/ListPermintaan', 'ListPermintaanController@index')->name('index');
    Route::get('/getdataListPermintaan', 'ListPermintaanController@getdata')->name('getdataListPermintaan');
    Route::get('/view/{id}', 'ListPermintaanController@view')->name('view');
    Route::get('/getview/{id}', 'ListPermintaanController@getview')->name('getview');
    Route::post('pengadaan', 'ListPermintaanController@pengadaan')->name('pengadaan');

});

Route::name('Pengadaan.')->namespace('Pengadaan')->prefix('Pengadaan')->group(function () {

    Route::get('/', 'PengadaanController@index')->name('index');
    Route::get('/getdata', 'PengadaanController@getdata')->name('getdata');
    Route::get('/getvendor', 'PengadaanController@getvendor')->name('getvendor');
    Route::get('/view/{id}', 'PengadaanController@view')->name('getview');
    Route::get('/getview/{id}', 'PengadaanController@getview')->name('getview');
    Route::get('/detailview/{id}', 'PengadaanController@detailview')->name('detailview');

});