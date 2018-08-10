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

//用户注册
Route::get('/userRegister','UserLoginController@userRegister');
Route::post('/userRegister','UserLoginController@userRegister');

//公司注册
Route::get('/firmRegister','FirmLoginController@firmRegister');
Route::post('/firmRegister','FirmLoginController@firmRegister');

//登陆
Route::get('/webLogin','UserLoginController@showLoginForm')->name('login');
Route::post('/webLogin','UserLoginController@login');

Route::group(['middleware'=>'web.auth'],function(){

});





