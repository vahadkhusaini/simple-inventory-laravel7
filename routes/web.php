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
    Route::resource('pelanggan', 'PelangganController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('barang', 'BarangController');
    Route::resource('pesanan', 'PesananController');
    Route::post('/supplier/insert','SupplierController@insert');
    Route::post('/barang/getSupplier','BarangController@getSupplier');
    Route::post('/barang/getBarang','BarangController@getBarang');
});
