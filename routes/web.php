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
//后台
Route::get('/admin/login', 'Admin\LoginController@loginForm')->name('admin_login');
Route::post('/admin/login', 'Admin\LoginController@login');

Route::group(['middleware'=>'admin.auth'],function(){
    Route::get('/admin/index', 'Admin\IndexController@index');
});
