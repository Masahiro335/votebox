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

Route::get('/','TopController@index')->name('top');
Route::match(['get', 'post'], '/register','LoginController@register')->name('register');
Route::match(['get', 'post'], '/login','LoginController@login')->name('login');
Route::get('/logout','LoginController@logout')->name('logout');

//マイページ：ログイン必須
Route::prefix('mypage')->middleware('login_check')->group(function () {
	Route::get('/','Mypage\ThemesController@top')->name('mypage.top');
	Route::get('/menu', function() { return view('mypage/menu',['title' => 'マイページ']); })->name('menu');
	//投票関連
	Route::prefix('themes')->group(function () {
		Route::get('/graph/{id}','Mypage\ThemesController@graph')->name('graph');
		Route::get('/vote-name/{id}','Mypage\ThemesController@voteName')->name('voteName');
		Route::get('/vote/{id}','Mypage\ThemesController@vote')->name('vote');
		Route::match(['get', 'post', 'put'], '/edit/{id?}','Mypage\ThemesController@edit')->name('Themes.edit');
		Route::get('/invalid/{id}','Mypage\ThemesController@invalid')->name('Themes.invalid');
	});
	//ユーザー関連
	Route::prefix('users')->group(function () {
		Route::match(['get', 'post'], '/edit','Mypage\UsersController@edit')->name('Users.edit');
		Route::match(['get', 'post'], '/password','Mypage\UsersController@password')->name('Users.password');
		Route::match(['get', 'post'], '/password-edit','Mypage\UsersController@passwordEdit')->name('Users.passwordEdit');
	});
});