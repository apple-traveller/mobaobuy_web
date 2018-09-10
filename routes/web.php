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
Route::get('/', function(){
    return '111';
});

//后台
Route::get('/admin/login', 'Admin\LoginController@loginForm')->name('admin_login');
Route::post('/admin/login', 'Admin\LoginController@login');
Route::group(['middleware'=>'admin.auth'],function(){
    Route::get('/admin/logout', 'Admin\LoginController@logout');
    Route::get('/admin/index', 'Admin\IndexController@index');
    Route::get('/admin/home', 'Admin\IndexController@home');//用户首页

    Route::any('/user/list', 'Admin\UserController@list');//用户列表
    Route::post('/user/modify', 'Admin\UserController@modify');//修改用户状态
    Route::get('/user/log', 'Admin\UserController@log');//查看用户日志信息
    Route::get('/user/detail', 'Admin\UserController@detail');//查看用户详情信息
    Route::get('/user/addForm', 'Admin\UserController@addForm');//用户添加（表单）
    Route::post('/user/add', 'Admin\UserController@add');//用户添加
    Route::get('/user/export', 'Admin\UserController@export');//用户导出excel

    Route::any('/firm/list', 'Admin\FirmController@list');//企业列表
    Route::get('/firm/log', 'Admin\FirmController@log');//查看企业日志信息
    Route::get('/firm/detail', 'Admin\FirmController@detail');//查看企业详情信息
    Route::post('/firm/modify', 'Admin\FirmController@modify');//修改企业状态
    Route::get('/firm/export', 'Admin\FirmController@export');//企业导出excel

    Route::any('/blacklist/list', 'Admin\FirmBlacklistController@list');//黑名单企业
    Route::get('/blacklist/addForm', 'Admin\FirmBlacklistController@addForm');//黑名单添加（表单）
    Route::post('/blacklist/add', 'Admin\FirmBlacklistController@add');//黑名单添加
    Route::get('/blacklist/delete', 'Admin\FirmBlacklistController@delete');//黑名单删除
    Route::post('/blacklist/deleteall', 'Admin\FirmBlacklistController@deleteAll');//黑名单批量删除
    Route::get('/blacklist/export', 'Admin\FirmBlacklistController@export');//黑名单导出excel

    Route::get('/region/list', 'Admin\RegionController@list');//地区列表
    Route::post('/region/add', 'Admin\RegionController@add');//地区添加
    Route::get('/region/delete', 'Admin\RegionController@delete');//地区删除
    Route::post('/region/modify', 'Admin\RegionController@modify');//地区修改

    Route::get('/goodscategory/list', 'Admin\GoodsCategoryController@list');//商品分类列表
    Route::get('/goodscategory/addForm', 'Admin\GoodsCategoryController@addForm');//商品分类添加
    Route::post('/goodscategory/save', 'Admin\GoodsCategoryController@save');//商品分类保存
    Route::get('/goodscategory/delete', 'Admin\GoodsCategoryController@delete');//商品分类删除
    Route::get('/goodscategory/editForm', 'Admin\GoodsCategoryController@editForm');//商品分类编辑
    Route::post('/goodscategory/sort', 'Admin\GoodsCategoryController@sort');//商品分类排序
    Route::post('/goodscategory/upload', 'Admin\GoodsCategoryController@upload');//上传自定义图标


    Route::get('/sysconfig/index', 'Admin\SysConfigController@index');//平台配置首页
    Route::post('/sysconfig/modify', 'Admin\SysConfigController@modify');//平台配置修改

    Route::get('/seo/index', 'Admin\SeoController@index');//seo配置首页
    Route::post('/seo/modify', 'Admin\SeoController@modify');//seo配置修改

    Route::get('/link/list', 'Admin\FriendLinkController@list');//友情链接列表
    Route::get('/link/addForm', 'Admin\FriendLinkController@addForm');//友情链接添加
    Route::get('/link/editForm', 'Admin\FriendLinkController@editForm');//友情链接编辑
    Route::get('/link/delete', 'Admin\FriendLinkController@delete');//友情链接删除
    Route::post('/link/add', 'Admin\FriendLinkController@add');//友情链接保存
    Route::post('/link/sort', 'Admin\FriendLinkController@sort');//友情链接排序ajax

    Route::get('/nav/list', 'Admin\NavController@list');//自定义导航栏列表
    Route::post('/nav/status', 'Admin\NavController@status');//ajax修改状态
    Route::get('/nav/addForm', 'Admin\NavController@addForm');//导航栏添加
    Route::get('/nav/editForm', 'Admin\NavController@editForm');//导航栏编辑
    Route::get('/nav/delete', 'Admin\NavController@delete');//导航栏删除
    Route::post('/nav/add', 'Admin\NavController@add');//导航栏保存
    Route::post('/nav/sort', 'Admin\NavController@sort');//导航栏排序


    Route::get('/articlecat/list', 'Admin\ArticleCatController@list');//文章分类列表
    Route::get('/articlecat/addForm', 'Admin\ArticleCatController@addForm');//文章分类添加
    Route::get('/articlecat/editForm', 'Admin\ArticleCatController@editForm');//文章分类编辑
    Route::post('/articlecat/save', 'Admin\ArticleCatController@save');//文章分类保存
    Route::post('/articlecat/sort', 'Admin\ArticleCatController@sort');//文章分类排序（ajax）
    Route::get('/articlecat/delete', 'Admin\ArticleCatController@delete');//文章分类删除

    Route::get('/article/list', 'Admin\ArticleController@list');//文章列表
    Route::get('/article/addForm', 'Admin\ArticleController@addForm');//文章添加
    Route::get('/article/editForm', 'Admin\ArticleController@editForm');//文章编辑
    Route::post('/article/save', 'Admin\ArticleController@save');//文章保存
    Route::get('/article/detail', 'Admin\ArticleController@detail');//文章详情
    Route::post('/article/sort', 'Admin\ArticleController@sort');//文章排序（ajax）
    Route::get('/article/delete', 'Admin\ArticleController@delete');//文章删除
    Route::post('/article/status', 'Admin\ArticleController@status');//ajax修改状态
});

Route::post('/uploadImg', 'UploadController@uploadImg');//图片上传

//用户
Route::get('/userRegister','Web\UserLoginController@userRegister');
Route::post('/userRegister','Web\UserLoginController@userRegister');


//公司注册
Route::get('/firmRegister','Web\FirmLoginController@firmRegister');
Route::post('/firmRegister','Web\FirmLoginController@firmRegister');

//验证码
Route::post('/messageCode','Web\UserLoginController@getMessageCode');
//登陆
Route::get('/webLogin','Web\UserLoginController@showLoginForm')->name('login');
Route::post('/webLogin','Web\UserLoginController@login');
Route::get('/logout','Web\UserLoginController@logout');

//产品分类
Route::resource('goodsCate','Web\GoodsCategoryController');
Route::group(['middleware'=>'web.auth','namespace'=>'Web'],function(){
    Route::get('/updateUserInfo','UserLoginController@userUpdate');
    Route::post('/updateUserInfo','UserLoginController@userUpdate');
});






