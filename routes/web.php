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

//Route::get('/welcome', function () {
//    return view('welcome');
//});

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'LiveSearch@index');
Route::get('/live_search', 'LiveSearch@index');
Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');
Route::get('/live_search/fetch_data', 'LiveSearch@fetch_data');
Route::post('/live_search/add_data', 'LiveSearch@add_data')->name('LiveSearch.add_data');
Route::post('/live_search/update_data', 'LiveSearch@update_data')->name('LiveSearch.update_data');
Route::post('/live_search/delete_data', 'LiveSearch@delete_data')->name('LiveSearch.delete_data');

