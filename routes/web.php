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
Route::group( ['middleware' => 'user' ], function()
{
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
    
    Route::get('/home', 'HomeController@index')->name('home');
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

    //cari keahlian
    Route::get('/carikeahlian', 'KeahlianController@showSearchKeahlianForm')->name('cari.keahlian');
    Route::get('/carikeahlian/get', 'KeahlianController@cariKeahlian')->name('cari.keahlian.get');

    Route::post('selesai/{id}', 'PesanController@selesai')->name('selesai');
});


//contact admin
Route::get('/kontakkami', 'ContactController@show')->name('kontak');
Route::post('/contact',  'ContactController@mailToAdmin')->name('kontak.submit'); 

//verify user
Route::get('/verify/token/{token}', 'Auth\VerificationUserController@verify')->name('auth.verify');
Route::get('/verify/resend', 'Auth\VerificationUserController@resend')->name('auth.verify.resend');

//verify tukang
Route::get('/tukang/verify/token/{token}', 'TukangAuth\VerificationTukangController@verify')->name('tukang.auth.verify');
Route::get('/tukang/verify/resend', 'TukangAuth\VerificationTukangController@resend')->name('tukang.auth.verify.resend');



Route::get('/faq', function () {
    return view('noauth.faq');
})->name('faq');

Route::get('/choose-regis', function () {
    return view('noauth.daftarsebagai');
})->name('reg.as');

Route::get('/login-choose', function () {
    return view('noauth.loginsebagai');
})->name('log.as');

Route::get('/testimoni', 'TestimoniController@showTestimoni')->name('testi');
Route::get('/testimoni/urutkan', 'TestimoniController@urutkan')->name('urutkan');

//tukang
Route::group(['middleware' => ['tukang']], function () {
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





    //terima pesanan
    Route::get('/tukang/pesanan', 'TerimaPesananController@showDaftarPesanan')->name('daftar.pesanan');
    Route::post('/tukang/{id}/status', 'TerimaPesananController@status')->name('status');
    Route::get('/tukang/daftar/pesanan/aktif/{id}/detail', 'TerimaPesananController@showDetailPesananAktif')->name('daftar.pesanan.aktif.detail');
    Route::get('/tukang/daftar/pesanan/selesai', 'TerimaPesananController@showDaftarPesananSelesai')->name('daftar.pesanan.selesai');
    Route::get('/tukang/daftar/pesanan/selesai/{id}/detail', 'TerimaPesananController@showDetailPesananSelesai')->name('daftar.pesanan.selesai.detail');

    //pembayaran
    Route::get('/tukang/biaya', 'TerimaPesananController@showTambahPembayaran')->name('biaya');
    Route::post('/tukang/biaya/tambah', 'TerimaPesananController@tambahKekurangan')->name('tambah.kekurangan');
    Route::delete('/tukang/biaya/{id}/hapus', 'TerimaPesananController@hapusKekurangan')->name('hapus.kekurangan');

    //main page tukang
    Route::get('/tukang', 'TukangController@index')->name('tukang.home');

});

    Route::get('/admin/login','AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/admin/login','AdminAuth\LoginController@login')->name('admin.login.submit');
    Route::post('/admin/logout','AdminAuth\LoginController@logout')->name('admin.logout'); 
    Route::post('/admin/aktifkan/{id}', 'AdminController@aktifkanTukang')->name('admin.aktifkan');
    Route::get('/admin', 'AdminController@index')->name('admin.home');
