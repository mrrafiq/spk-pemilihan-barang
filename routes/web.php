<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function() {
    return view('auth.login');

});

Route::post('/login', 'App\Http\Controllers\UserController@login')->name('login');

Route::get('/register', function() {
    return view('auth.register');

});
Route::post('/register', 'App\Http\Controllers\UserController@register')->name('register');

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    });

    Route::get('/barang', 'App\Http\Controllers\BarangController@index')->name('barang.index');
    Route::get('/barang/create', 'App\Http\Controllers\BarangController@create')->name('barang.create');
    Route::post('/barang/store', 'App\Http\Controllers\BarangController@store')->name('barang.store');
    Route::get('/barang/edit/{id}', 'App\Http\Controllers\BarangController@edit')->name('barang.edit');
    Route::post('/barang/update/{id}', 'App\Http\Controllers\BarangController@update')->name('barang.update');
    Route::get('/barang/destroy/{id}', 'App\Http\Controllers\BarangController@destroy')->name('barang.destroy');

    // Route::resource('perhitungan','PerhitunganController');
    Route::get('/perhitungan/create', 'App\Http\Controllers\PerhitunganController@create')->name('perhitungan.create');
    Route::post('/perhitungan/store', 'App\Http\Controllers\PerhitunganController@store')->name('perhitungan.store');
    Route::get('/perhitungan', 'App\Http\Controllers\PerhitunganController@index')->name('perhitungan.index');
    Route::get('/perhitungan/detail/{id}', 'App\Http\Controllers\PerhitunganController@show')->name('perhitungan.detail');

    Route::get('/perhitungan/aras/create/{id}', 'App\Http\Controllers\ArasController@create')->name('aras.create');
    Route::post('/perhitungan/aras/store/{id}', 'App\Http\Controllers\ArasController@store')->name('aras.store');
});
