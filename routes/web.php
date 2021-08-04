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

Route::get('/','AuthController@getLogin')->name('login');
Route::get('/login','AuthController@getLogin')->name('login');
Route::post('/login','AuthController@postLogin')->name('post.login');
Route::get('/register','AuthController@getRegister')->name('register');
Route::post('/register','AuthController@postRegister')->name('post.register');

Route::group(['middleware' => 'auth'], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::get('logout','AuthController@logout')->name('logout');
    Route::post('editProfile','AuthController@editProfile');
    Route::post('changePassword','AuthController@changePassword');


    Route::resource('pelanggan', 'PelangganController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('barang', 'BarangController');

    Route::resource('pesanan', 'PesananController');
    Route::post('/pesanan/getById','PesananController@getOrdersById')->name('barang.byId');
    Route::get('/cetak_pdf/{tgl1}/{tgl2}/{supplier_id}','PesananController@cetak_laporan_pdf');
    Route::get('/cetak_invoice_pdf/{id}','PesananController@cetak_invoice_pdf');

    Route::resource('pembelian', 'PembelianController');
    Route::get('/cetak_invoice_pdf/{id}','PembelianController@cetak_invoice_pdf');
    Route::get('/cetak_laporan_pembelian/{tgl1}/{tgl2}/{supplier_id}','PembelianController@cetak_laporan_pdf');

    Route::resource('penjualan', 'PenjualanController');
    Route::get('/cetak_invoice_pdf/{id}','PenjualanController@cetak_invoice_pdf');
    Route::post('/penjualan/getPelanggan','PenjualanController@getPelanggan');
    
    Route::get('/stok','KartuStokController@index')->name('stok');

    Route::post('/supplier/insert','SupplierController@insert');
    Route::post('/barang/getSupplier','BarangController@getSupplier');
    
    Route::post('/barang/getBarang','BarangController@getBarang');
    Route::post('/barang/getBarangById','BarangController@getBarangById')->name('barang.byId');
    Route::get('/cart/index','CartController@index')->name('cart.index');
    Route::post('/cart/add','CartController@add')->name('cart.add');
    Route::post('/cart/remove','CartController@remove')->name('cart.remove');
    Route::post('/cart/{id}/update','CartController@update');
});
