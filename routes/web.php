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



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/faq', function () {
    return view('noauth.faq');
})->name('faq');

Route::get('/choose-regis', function () {
    return view('noauth.daftarsebagai');
})->name('reg.as');

Route::get('/login-choose', function () {
    return view('noauth.loginsebagai');
})->name('log.as');

Route::get('/testimoni', function () {
    return view('noauth.testimoni');
})->name('testi');

Route::get('/kontakkami', function () {
    return view('noauth.kontakkami');
})->name('kontak');

Auth::routes();

 

//edit user
Route::get('edit','UserController@showEditUserForm')->name('user.edit');
Route::patch('{user}/update','UserController@update')->name('user.update');

//pesan tukang
Route::get('{id}/pesan', 'PesanController@showKonfirmasiForm')->name('pesan.tukang');
Route::post('pesan', 'PesanController@pesan')->name('pesan.tukang.submit');

//daftar pesanan
Route::get('daftar/pesanan/aktif', 'PesanController@showListPesananAktif')->name('list.pesanan.aktif');
Route::get('daftar/pesanan/aktif/{id}/detail', 'PesanController@showDetailPesananAktif')->name('list.pesanan.aktif.detail');
Route::get('daftar/pesanan/selesai', 'PesanController@showListPesananSelesai')->name('list.pesanan.selesai');
Route::get('daftar/pesanan/selesai/{id}/detail', 'PesanController@showDetailPesananSelesai')->name('list.pesanan.selesai.detail');

//Rating
Route::post('daftar/pesanan/selesai/{id}/rate', 'PesanController@rate')->name('rate');

//terima pesanan
Route::get('/tukang/pesanan', 'TerimaPesananController@showDaftarPesanan')->name('daftar.pesanan');
Route::post('/tukang/{id}/status', 'TerimaPesananController@status')->name('status');

//pembayaran
Route::get('/tukang/biaya', 'TerimaPesananController@showTambahPembayaran')->name('biaya');
Route::post('/tukang/biaya/tambah', 'TerimaPesananController@tambahKekurangan')->name('tambah.kekurangan');
Route::delete('/tukang/biaya/{id}/hapus', 'TerimaPesananController@hapusKekurangan')->name('hapus.kekurangan');

//tukang
Route::group(['middleware' => ['web']], function () {
    //Login Routes...
    Route::get('/tukang/login','TukangAuth\TukangLoginController@showLoginForm')->name('tukang.login');
    Route::post('/tukang/login','TukangAuth\TukangLoginController@login')->name('tukang.login.submit');
    Route::post('/tukang/logout','TukangAuth\TukangLoginController@logout')->name('tukang.logout');

    //Registration Routes...
    Route::get('tukang/register', 'TukangAuth\TukangRegisterController@showRegistrationForm')->name('tukang.register');
    Route::post('tukang/register', 'TukangAuth\TukangRegisterController@register')->name('tukang.register.submit');;

    //Password Reset Routes...
    Route::post('tukang/password/email', 'TukangAuth\TukangForgotPasswordController@sendResetLinkEmail')->name('tukang.password.email');
    Route::get('tukang/password/reset', 'TukangAuth\TukangForgotPasswordController@showLinkRequestForm')->name('tukang.password.request');
    Route::post('tukang/password/reset', 'TukangAuth\TukangResetPasswordController@reset');
    Route::get('tukang/password/reset/{token}', 'TukangAuth\TukangResetPasswordController@showResetForm')->name('tukang.password.reset');

    //main page tukang
    Route::get('/tukang', 'TukangController@index')->name('tukang.home');

}); 
