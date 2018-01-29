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
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/view', 'UserController@index')->middleware('auth');
Route::get('/user/search', 'UserController@search')->middleware('auth');
Route::get('/user/{id}/konfirmasi', 'UserController@konfirmasiUser')->middleware('auth');
Route::resource('user','UserController')->middleware('auth');

Route::get('/mobil/view', 'MobilController@index')->middleware('auth');
Route::get('/mobil/all', 'MobilController@all')->middleware('auth');
Route::get('/mobil/search', 'MobilController@search')->middleware('auth');
Route::resource('mobil','SupplierController')->middleware('auth');

Route::get('/supplier/view', 'SupplierController@index')->middleware('auth');
Route::get('/supplier/all', 'SupplierController@all')->middleware('auth');
Route::get('/supplier/search', 'SupplierController@search')->middleware('auth');
Route::resource('supplier','SupplierController')->middleware('auth');


Route::get('/driver/view', 'DriverController@index')->middleware('auth');
Route::get('/driver/all', 'DriverController@all')->middleware('auth');
Route::get('/driver/search', 'DriverController@search')->middleware('auth');
Route::resource('driver','DriverController')->middleware('auth');

Route::get('/gudang/view', 'GudangController@index')->middleware('auth');
Route::get('/gudang/all', 'GudangController@all')->middleware('auth');
Route::get('/gudang/search', 'GudangController@search')->middleware('auth');
Route::resource('gudang','GudangController')->middleware('auth');

Route::get('/pelanggan/view', 'PelangganController@index')->middleware('auth');
Route::get('/pelanggan/all', 'PelangganController@all')->middleware('auth');
Route::get('/pelanggan/search', 'PelangganController@search')->middleware('auth');
Route::resource('pelanggan','PelangganController')->middleware('auth');

Route::get('/kas/view', 'KasController@index')->middleware('auth');
Route::get('/kas/search', 'KasController@search')->middleware('auth');
Route::resource('/kas','KasController')->middleware('auth');

Route::get('/jurnal-manual/view', 'JurnalManualController@index')->middleware('auth');
Route::get('/jurnal-manual/search', 'JurnalManualController@search')->middleware('auth');
Route::resource('/jurnal-manual','JurnalManualController')->middleware('auth');

Route::get('/produk/view', 'ProdukController@index')->middleware('auth');
Route::get('/produk/all', 'ProdukController@all')->middleware('auth');
Route::get('/produk/search', 'ProdukController@search')->middleware('auth');
Route::resource('/produk','ProdukController')->middleware('auth');

Route::get('/akun/view', 'AkunController@index')->middleware('auth');
Route::get('/akun/all', 'AkunController@all')->middleware('auth');
Route::get('/akun/search', 'AkunController@search')->middleware('auth');
Route::resource('/akun','AkunController')->middleware('auth');

//Transaksi Kas
Route::get('/transaksi-kas/view', 'TransaksiKasController@index')->middleware('auth');
Route::get('/transaksi-kas/laporan', 'TransaksiKasController@laporanKas')->middleware('auth');
Route::post('/transaksi-kas/kas-masuk', 'TransaksiKasController@storeKasMasuk')->middleware('auth');
Route::post('/transaksi-kas/kas-keluar', 'TransaksiKasController@storeKasKeluar')->middleware('auth');
Route::post('/transaksi-kas/kas-mutasi', 'TransaksiKasController@storeKasMutasi')->middleware('auth');
Route::get('/transaksi-kas/search', 'TransaksiKasController@search')->middleware('auth');
Route::get('/transaksi-kas/posisi-kas', 'TransaksiKasController@posisiKas')->middleware('auth');
Route::resource('/transaksi-kas','TransaksiKasController')->middleware('auth');
Route::patch('/transaksi-kas/{id}/kas-masuk','TransaksiKasController@updateKasMasuk')
        ->middleware('auth');
Route::patch('/transaksi-kas/{id}/kas-keluar','TransaksiKasController@updateKasKeluar')
        ->middleware('auth');
// Laporan Akuntansi
Route::get('/akuntansi/jurnal-umum','AkuntansiController@jurnalUmum')->middleware('auth');
Route::get('/akuntansi/neraca','AkuntansiController@neraca')->middleware('auth');
Route::get('/akuntansi/laba-rugi','AkuntansiController@labaRugi')->middleware('auth');

//Transaksi Gas
Route::get('/transaksi-gas/view', 'TransaksiGasController@index')->middleware('auth');
Route::get('/transaksi-gas/{id}/edit-gas', 'TransaksiGasController@editGas')->middleware('auth');
Route::get('/transaksi-gas/laporan', 'TransaksiGasController@laporanGas')->middleware('auth');
Route::post('/transaksi-gas/gas-masuk', 'TransaksiGasController@storeGasMasuk')->middleware('auth');
Route::post('/transaksi-gas/gas-keluar', 'TransaksiGasController@storeGasKeluar')->middleware('auth');
Route::get('/transaksi-gas/search', 'TransaksiGasController@search')->middleware('auth');
Route::resource('/transaksi-gas','TransaksiGasController')->middleware('auth');
Route::patch('/transaksi-gas/{id}/gas-masuk','TransaksiGasController@updateGasMasuk')
        ->middleware('auth');
Route::patch('/transaksi-gas/{id}/gas-keluar','TransaksiGasController@updateGasKeluar')
        ->middleware('auth');
