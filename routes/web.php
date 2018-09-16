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
Route::get('/admin', 'Admin\LoginController@loginForm');
Route::get('/admin/login', 'Admin\LoginController@loginForm')->name('admin_login');
Route::post('/admin/login', 'Admin\LoginController@login');
Route::group(['middleware'=>'admin.auth'],function(){
    Route::get('/admin/logout', 'Admin\LoginController@logout');
    Route::get('/admin/index', 'Admin\IndexController@index');
    Route::get('/admin/home', 'Admin\IndexController@home');//用户首页

    Route::any('/admin/user/list', 'Admin\UserController@list');//用户列表
    Route::post('/admin/user/modify', 'Admin\UserController@modify');//修改用户状态
    Route::get('/admin/user/log', 'Admin\UserController@log');//查看用户日志信息
    Route::get('/admin/user/detail', 'Admin\UserController@detail');//查看用户详情信息
    Route::get('/admin/user/verifyForm', 'Admin\UserController@verifyForm');//用户审核
    Route::post('/admin/user/verify', 'Admin\UserController@verify');//用户审核
    Route::get('/admin/user/export', 'Admin\UserController@export');//用户导出excel
    Route::get('/admin/user/userRealForm', 'Admin\UserController@userRealForm');//实名认证
    Route::post('/admin/user/userReal', 'Admin\UserController@userReal');//实名认证审核
    Route::get('/admin/user/points', 'Admin\UserController@points');//查看积分



/*    Route::any('/firm/list', 'Admin\FirmController@list');//企业列表
    Route::get('/firm/log', 'Admin\FirmController@log');//查看企业日志信息
    Route::get('/firm/detail', 'Admin\FirmController@detail');//查看企业详情信息
    Route::get('/firm/verifyForm', 'Admin\FirmController@verifyForm');//企业审核
    Route::post('/firm/verify', 'Admin\FirmController@verify');//企业审核
    Route::get('/firm/export', 'Admin\FirmController@export');//企业导出excel
    Route::get('/firm/userRealForm', 'Admin\FirmController@userRealForm');//实名认证
    Route::post('/firm/userReal', 'Admin\FirmController@userReal');//实名认证审核

    Route::get('/firm/firmuser', 'Admin\FirmController@firmuser');//企业列表
    Route::get('/firm/pointflow', 'Admin\FirmController@pointflow');//查看企业积分信息
    Route::post('/firm/modify', 'Admin\FirmController@modify');//修改企业状态
    Route::get('/firm/export', 'Admin\FirmController@export');//企业导出excel*/

    Route::any('/admin/blacklist/list', 'Admin\FirmBlacklistController@list');//黑名单企业
    Route::get('/admin/blacklist/addForm', 'Admin\FirmBlacklistController@addForm');//黑名单添加（表单）
    Route::post('/admin/blacklist/add', 'Admin\FirmBlacklistController@add');//黑名单添加
    Route::get('/admin/blacklist/delete', 'Admin\FirmBlacklistController@delete');//黑名单删除
    Route::post('/admin/blacklist/deleteall', 'Admin\FirmBlacklistController@deleteAll');//黑名单批量删除
    Route::get('/admin/blacklist/export', 'Admin\FirmBlacklistController@export');//黑名单导出excel

    Route::get('/admin/region/list', 'Admin\RegionController@list');//地区列表
    Route::post('/admin/region/add', 'Admin\RegionController@add');//地区添加
    Route::get('/admin/region/delete', 'Admin\RegionController@delete');//地区删除
    Route::post('/admin/region/modify', 'Admin\RegionController@modify');//地区修改

    Route::get('/admin/goodscategory/list', 'Admin\GoodsCategoryController@list');//商品分类列表
    Route::get('/admin/goodscategory/addForm', 'Admin\GoodsCategoryController@addForm');//商品分类添加
    Route::post('/admin/goodscategory/save', 'Admin\GoodsCategoryController@save');//商品分类保存
    Route::get('/admin/goodscategory/delete', 'Admin\GoodsCategoryController@delete');//商品分类删除
    Route::get('/admin/goodscategory/editForm', 'Admin\GoodsCategoryController@editForm');//商品分类编辑
    Route::post('/admin/goodscategory/sort', 'Admin\GoodsCategoryController@sort');//商品分类排序
    Route::post('/admin/goodscategory/upload', 'Admin\GoodsCategoryController@upload');//上传自定义图标


    Route::get('/admin/sysconfig/index', 'Admin\SysConfigController@index');//平台配置首页
    Route::post('/admin/sysconfig/modify', 'Admin\SysConfigController@modify');//平台配置修改

    Route::get('/admin/seo/index', 'Admin\SeoController@index');//seo配置首页
    Route::post('/admin/seo/modify', 'Admin\SeoController@modify');//seo配置修改

    Route::get('/admin/link/list', 'Admin\FriendLinkController@list');//友情链接列表
    Route::get('/admin/link/addForm', 'Admin\FriendLinkController@addForm');//友情链接添加
    Route::get('/admin/link/editForm', 'Admin\FriendLinkController@editForm');//友情链接编辑
    Route::get('/admin/link/delete', 'Admin\FriendLinkController@delete');//友情链接删除
    Route::post('/admin/link/add', 'Admin\FriendLinkController@add');//友情链接保存
    Route::post('/admin/link/sort', 'Admin\FriendLinkController@sort');//友情链接排序ajax

    Route::get('/admin/nav/list', 'Admin\NavController@list');//自定义导航栏列表
    Route::post('/admin/nav/status', 'Admin\NavController@status');//ajax修改状态
    Route::get('/admin/nav/addForm', 'Admin\NavController@addForm');//导航栏添加
    Route::get('/admin/nav/editForm', 'Admin\NavController@editForm');//导航栏编辑
    Route::get('/admin/nav/delete', 'Admin\NavController@delete');//导航栏删除
    Route::post('/admin/nav/add', 'Admin\NavController@add');//导航栏保存
    Route::post('/admin/nav/sort', 'Admin\NavController@sort');//导航栏排序


    Route::get('/admin/articlecat/list', 'Admin\ArticleCatController@list');//文章分类列表
    Route::get('/admin/articlecat/addForm', 'Admin\ArticleCatController@addForm');//文章分类添加
    Route::get('/admin/articlecat/editForm', 'Admin\ArticleCatController@editForm');//文章分类编辑
    Route::post('/admin/articlecat/save', 'Admin\ArticleCatController@save');//文章分类保存
    Route::post('/admin/articlecat/sort', 'Admin\ArticleCatController@sort');//文章分类排序（ajax）
    Route::get('/admin/articlecat/delete', 'Admin\ArticleCatController@delete');//文章分类删除

    Route::get('/admin/article/list', 'Admin\ArticleController@list');//文章列表
    Route::get('/admin/article/addForm', 'Admin\ArticleController@addForm');//文章添加
    Route::get('/admin/article/editForm', 'Admin\ArticleController@editForm');//文章编辑
    Route::post('/admin/article/save', 'Admin\ArticleController@save');//文章保存
    Route::get('/admin/article/detail', 'Admin\ArticleController@detail');//文章详情
    Route::post('/admin/article/sort', 'Admin\ArticleController@sort');//文章排序（ajax）
    Route::get('/admin/article/delete', 'Admin\ArticleController@delete');//文章删除
    Route::post('/admin/article/status', 'Admin\ArticleController@status');//ajax修改状态

    Route::get('/template/index', 'Admin\TemplateController@index');//首页可视化
    Route::get('/template/decorate', 'Admin\TemplateController@decorate');//装修模板
    Route::post('/template/saveTemplate', 'Admin\TemplateController@saveTemplate');//模板缓存
    Route::post('/template/publish', 'Admin\TemplateController@publish');//确认发布
    Route::post('/template/partEdit', 'Admin\TemplateController@partEdit');//模板编辑
    Route::get('/template/preview', 'Admin\TemplateController@preview');//模板预览
    Route::get('/template/decoratetest', 'Admin\TemplateController@decoratetest');//装修模板(测试)
    Route::get('/template/getPics', 'Admin\TemplateController@getPics');//测试方法

});



Route::get('/SysCacheSet', 'Web\SysConfigController@sysCacheSet');//系统配置信息
Route::get('/SysCacheClean', 'Web\SysConfigController@sysCacheClean');

Route::post('/uploadImg', 'UploadController@uploadImg');//图片上传


Route::get('/userRegister','Web\UserLoginController@userRegister');//注册
Route::post('/userRegister','Web\UserLoginController@userRegister');
Route::get('/userLogin','Web\UserLoginController@showLoginForm')->name('login');//登陆
Route::post('/userLogin','Web\UserLoginController@login');
Route::post('/messageCode','Web\UserLoginController@getMessageCode');//注册验证码

//公司注册
Route::get('/firmRegister','Web\FirmLoginController@firmRegister');
Route::post('/firmRegister','Web\FirmLoginController@firmRegister');

//用户信息完善
Route::group(['middleware'=>'web.auth','namespace'=>'Web'],function(){
    Route::get('/updateUserInfo','UserController@userUpdate');//用户信息编辑
    Route::post('/updateUserInfo','UserController@userUpdate');//用户信息保存

    Route::get('/createFirmUser','FirmUserController@createFirmUser');//企业会员绑定
    Route::post('/createFirmUser','FirmUserController@createFirmUser');//企业会员绑定
    Route::post('/addFirmUser','FirmUserController@addFirmUser');//企业会员绑定权限

    Route::get('/updatePwd','UserController@userUpdatePwd');//修改密码
    Route::post('/updatePwd','UserController@userUpdatePwd');
    Route::get('/forgotPwd','UserController@userForgotPwd');//忘记密码
    Route::post('/forgotPwd','UserController@userForgotPwd');
    Route::post('/getCode','UserController@userForgotCode');//获取验证码

    Route::resource('goodsCate','GoodsCategoryController');//产品信息

    Route::get('/','IndexController@index');
    Route::get('/logout','UserLoginController@logout');//登出

});









