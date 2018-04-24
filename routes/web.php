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

Route::get('/faq', function () {
    return view('noauth.faq');
})->name('faq');

Route::get('/dftsebagai', function () {
    return view('noauth.daftarsebagai');
})->name('dftsebagai');

Route::get('/testimoni', function () {
    return view('noauth.testimoni');
})->name('testi');

Route::get('/kontakkami', function () {
    return view('noauth.kontakkami');
})->name('kontak');



//tukang
Route::group(['middleware' => ['web']], function () {
    //Login Routes...
    Route::get('/tukang/login','TukangAuth\TukangLoginController@showLoginForm')->name('tukang.login');
    Route::post('/tukang/login','TukangAuth\TukangLoginController@login')->name('tukang.registering');
    Route::get('/tukang/logout','TukangAuth\TukangLoginController@logout')->name('tukang.logout');

    // Registration Routes...
    Route::get('tukang/register', 'TukangAuth\TukangRegisterController@showRegistrationForm')->name('tukang.register');
    Route::post('tukang/register', 'TukangAuth\TukangRegisterController@register');

    

});  

Route::get('/tukang', 'TukangController@index');