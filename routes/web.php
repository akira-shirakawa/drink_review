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
Auth::routes();
Route::get('/', function () {
    return view('index');
});
Route::get('/user/{id}','UserController@show');
Route::post('/change_user','UserController@edit')->middleware('auth');
Route::get('/post','PostController@create')->middleware('auth');
Route::post('/post','PostController@store')->middleware('auth');