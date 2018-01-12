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

Route::get('/user/view', 'UserController@index')->middleware('auth');
Route::get('/user/search', 'UserController@search')->middleware('auth');
Route::get('/user/{id}/konfirmasi', 'UserController@konfirmasiUser')->middleware('auth');
Route::resource('user','UserController')->middleware('auth');

Route::get('/mobil/view', 'MobilController@index')->middleware('auth');
Route::get('/mobil/search', 'MobilController@search')->middleware('auth');
Route::resource('mobil','SupplierController')->middleware('auth');

Route::get('/supplier/view', 'SupplierController@index')->middleware('auth');
Route::get('/supplier/search', 'SupplierController@search')->middleware('auth');
Route::resource('supplier','SupplierController')->middleware('auth');


Route::get('/driver/view', 'DriverController@index')->middleware('auth');
Route::get('/driver/search', 'DriverController@search')->middleware('auth');
Route::resource('driver','DriverController')->middleware('auth');

Route::get('/gudang/view', 'GudangController@index')->middleware('auth');
Route::get('/gudang/search', 'GudangController@search')->middleware('auth');
Route::resource('gudang','GudangController')->middleware('auth');
