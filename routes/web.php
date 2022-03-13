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

Route::get('/','ThemesController@index')->name('Top');
Route::match(['get', 'post'], '/themes/edit/{id?}','ThemesController@edit')->name('Themes.edit');
Route::get('/themes/graph/{id?}','ThemesController@graph')->name('Graph');