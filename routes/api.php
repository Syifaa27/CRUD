<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::get('/', function(){
    return Auth::user()->alamat;
})->middleware('jwt.verify');

Route::post('buku', 'BukuController@store')->middleware('jwt.verify');
Route::put('buku_edit/{id}', 'BukuController@update')->middleware('jwt.verify');
Route::get('tampil_buku', 'BukuController@tampil')->middleware('jwt.verify');
Route::delete('hapus_buku/{id}', 'BukuController@destroy')->middleware('jwt.verify');

Route::post('anggota', 'AnggotaController@store')->middleware('jwt.verify');
Route::put('anggota_edit/{id}', 'AnggotaController@update')->middleware('jwt.verify');
Route::get('tampil_anggota', 'AnggotaController@tampil')->middleware('jwt.verify');
Route::delete('hapus_anggota/{id}', 'AnggotaController@destroy')->middleware('jwt.verify');

Route::post('peminjaman', 'PeminjamanController@store')->middleware('jwt.verify');
Route::put('peminjaman_edit/{id}', 'PeminjamanController@update')->middleware('jwt.verify');
Route::delete('hapus_peminjaman/{id}', 'PeminjamanController@destroy')->middleware('jwt.verify');


Route::post('tambah_detail', 'PeminjamanController@insert')->middleware('jwt.verify');
Route::get('tampil/{id}', 'PeminjamanController@index')->middleware('jwt.verify');