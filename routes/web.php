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


//后台
Route::get('/admin/login', 'Admin\LoginController@loginForm')->name('admin_login');
Route::post('/admin/login', 'Admin\LoginController@login');
Route::get('/admin/logout', 'Admin\LoginController@logout');
Route::group(['middleware'=>'admin.auth'],function(){
    Route::get('/admin/index', 'Admin\IndexController@index');
    Route::get('/user/list', 'Admin\UserController@list');
});

//用户
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






