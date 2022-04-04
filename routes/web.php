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

//マイページ：ログイン必須
Route::prefix('mypage')->middleware('login_check')->group(function () {
	Route::get('/','Mypage\ThemesController@index')->name('mypage.top');
	Route::get('/menu', function() { return view('mypage/menu',['title' => 'マイページ']); })->name('menu');
	Route::match(['get', 'post', 'put'], '/users/edit','Mypage\UsersController@edit')->name('Users.edit');
	///投票関連
	Route::prefix('themes')->group(function () {
		Route::get('/graph/{id?}','Mypage\ThemesController@graph')->name('graph');
		Route::get('/vote-item/{id?}','Mypage\ThemesController@voteItem')->name('voteItem');
		Route::get('/vote/{id?}','Mypage\ThemesController@vote')->name('vote');
		Route::match(['get', 'post', 'put'], '/edit/{id?}','Mypage\ThemesController@edit')->name('Themes.edit');
	});
});