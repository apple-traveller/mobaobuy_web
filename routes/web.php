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

//用户
Route::get('/userRegister','UserLoginController@userRegister');
Route::post('/userRegister','UserLoginController@userRegister');
Route::get('/userLogin','UserLoginController@showLoginForm');
Route::post('/userLogin','UserLoginController@login');

//公司
Route::get('/firmRegister','FirmLoginController@firmRegister');
Route::post('/firmRegister','FirmLoginController@firmRegister');
Route::get('/firmLogin','FirmLoginController@showLoginForm');
Route::post('/firmLogin','FirmLoginController@login');

