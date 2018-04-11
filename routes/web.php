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


Route::namespace('Home')->group(function(){
    Route::get('/', 'IndexController@index');
    Route::get('/login', 'LoginController@index');
    Route::get('/ad/post', 'AdvertisementController@post');
    Route::get('/ad/detail/{id}', 'AdvertisementController@detail');
    Route::get('/user', 'UserController@index');
});

Route::namespace('Admin')->prefix('admin')->group(function(){
    Route::get('/', 'IndexController@index');
    Route::get('/login', 'LoginController@index');
    Route::get('/user', 'UserController@index');
    Route::get('/region', 'RegionController@index');
});

Route::get('/welcome', function (){
    return view('welcome');
});

