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

//LOGIN
Route::get('login','Auth\LoginController@index')->name('index');
Route::post('storelogin','Auth\LoginController@storeLogin');
//LOGOUT
Route::get('logout','Auth\LoginController@logoutUser');

//Dashboard
Route::get('showdashboard','dashboardController@dashboard')->name('showdashboard');

//User
Route::get('showdatauser','userController@showdatauser')->name('datauser');
Route::get('hapususer/{id}','userController@hapusUser');
Route::get('resetpass/{id}','userController@resetPass');

Route::get('showtambahuser','userController@tambahUser');
Route::post('storeuser','userController@storeUser');

//Barang
Route::get('showtambahbarang','barangController@tambahBarang');
Route::post('storebarang','barangController@storeBarang');
Route::get('hapusbarang/{id}','barangController@hapusBarang');
Route::get('showdatabarang','barangController@dataBarang')->name('databarang');