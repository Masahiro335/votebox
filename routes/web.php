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

Route::get('/','ThemesController@index')->name('top');
Route::match(['get', 'post'], '/register','LoginController@register')->name('register');
Route::match(['get', 'post'], '/login','LoginController@login')->name('login');
Route::get('/logout','LoginController@logout')->name('logout');
Route::get('/themes/graph/{id?}','ThemesController@graph')->name('graph');

//マイページ：ログイン必須
Route::prefix('mypage')->middleware('login_check')->group(function () {
    Route::match(['get', 'post', 'put'], '/themes/edit/{id?}','Mypage\ThemesController@edit')->name('Themes.edit');
    Route::match(['get', 'post', 'put'], '/users/edit/{id?}','Mypage\UsersController@edit')->name('Users.edit');
});