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

Route::get('/verifyCode', 'VerifyCodeController@create');
Route::post('/checkVerifyCode', 'VerifyCodeController@check');


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

    Route::get('/admin/goodscategory/list', 'Admin\GoodsCategoryController@list');//产品分类列表
    Route::get('/admin/goodscategory/addForm', 'Admin\GoodsCategoryController@addForm');//产品分类添加
    Route::post('/admin/goodscategory/save', 'Admin\GoodsCategoryController@save');//产品分类保存
    Route::get('/admin/goodscategory/delete', 'Admin\GoodsCategoryController@delete');//产品分类删除
    Route::get('/admin/goodscategory/editForm', 'Admin\GoodsCategoryController@editForm');//产品分类编辑
    Route::post('/admin/goodscategory/sort', 'Admin\GoodsCategoryController@sort');//产品分类排序
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

    Route::get('/admin/brand/list', 'Admin\BrandController@list');//品牌列表
    Route::post('/admin/brand/status', 'Admin\BrandController@status');//ajax修改状态
    Route::post('/admin/brand/sort', 'Admin\BrandController@sort');//ajax排序
    Route::get('/admin/brand/addForm', 'Admin\BrandController@addForm');//添加
    Route::get('/admin/brand/editForm', 'Admin\BrandController@editForm');//编辑
    Route::post('/admin/brand/save', 'Admin\BrandController@save');//保存

    Route::get('/admin/goods/list', 'Admin\GoodsController@list');//产品列表
    Route::get('/admin/goods/addForm', 'Admin\GoodsController@addForm');//产品列表
    Route::get('/admin/goods/editForm', 'Admin\GoodsController@editForm');//产品列表
    Route::get('/admin/goods/detail', 'Admin\GoodsController@detail');//产品详情
    Route::post('/admin/goods/save', 'Admin\GoodsController@save');//产品列表
    Route::get('/admin/goods/delete', 'Admin\GoodsController@delete');//产品列表
    Route::post('/admin/goods/getAttrs', 'Admin\GoodsController@getAttrs');//获取属性名
    Route::post('/admin/goods/getAttrValues', 'Admin\GoodsController@getAttrValues');//获取属性值

    Route::get('/admin/unit/list', 'Admin\UnitController@list');//单位列表
    Route::get('/admin/unit/addForm', 'Admin\UnitController@addForm');//添加单位
    Route::get('/admin/unit/editForm', 'Admin\UnitController@editForm');//修改单位
    Route::post('/admin/unit/save', 'Admin\UnitController@save');//保存
    Route::post('/admin/unit/sort', 'Admin\UnitController@sort');//排序
    Route::get('/admin/unit/delete', 'Admin\UnitController@delete');//删除

    Route::get('/admin/shop/list', 'Admin\ShopController@list');//入驻店铺列表
    Route::get('/admin/shop/addForm', 'Admin\ShopController@addForm');//添加店铺
    Route::get('/admin/shop/editForm', 'Admin\ShopController@editForm');//修改店铺
    Route::post('/admin/shop/save', 'Admin\ShopController@save');//保存
    Route::post('/admin/shop/sort', 'Admin\ShopController@sort');//排序
    Route::get('/admin/shop/delete', 'Admin\ShopController@delete');//删除

    Route::get('/template/index', 'Admin\TemplateController@index');//首页可视化
    Route::get('/template/decorate', 'Admin\TemplateController@decorate');//装修模板
    Route::post('/template/saveTemplate', 'Admin\TemplateController@saveTemplate');//模板缓存
    Route::post('/template/publish', 'Admin\TemplateController@publish');//确认发布
    Route::post('/template/partEdit', 'Admin\TemplateController@partEdit');//模板编辑
    Route::get('/template/preview', 'Admin\TemplateController@preview');//模板预览
    Route::get('/template/decoratetest', 'Admin\TemplateController@decoratetest');//装修模板(测试)
    Route::get('/template/getPics', 'Admin\TemplateController@getPics');//测试方法

});


Route::post('/uploadImg', 'UploadController@uploadImg');//图片上传

Route::group(['namespace'=>'Web'],function() {
    Route::post('/user/checkNameExists', 'UserController@checkNameExists');//验证用户名是否存在
    Route::get('/register/sendSms', 'UserController@sendSms');//发送注册短信

    Route::get('/userRegister', 'UserController@userRegister')->name('register');//个人注册
    Route::post('/userRegister', 'UserController@userRegister');
    Route::get('/firmRegister', 'UserController@firmRegister')->name('firmRegister');//企业注册
    Route::post('/firmRegister', 'UserController@firmRegister');

    Route::get('/login', 'UserController@showLoginForm')->name('login');//登陆
    Route::post('/login', 'UserController@login');

    Route::group(['middleware' => 'web.auth'], function () {
        Route::get('/', 'IndexController@index'); //首页

        Route::get('/updateUserInfo', 'UserController@userUpdate');//用户信息编辑
        Route::post('/updateUserInfo', 'UserController@userUpdate');//用户信息保存

        Route::get('/createFirmUser', 'FirmUserController@createFirmUser');//企业会员绑定
        Route::post('/createFirmUser', 'FirmUserController@createFirmUser');//企业会员绑定
        Route::post('/addFirmUser', 'FirmUserController@addFirmUser');//企业会员绑定权限
        Route::get('/firmUserAuthList', 'FirmUserController@firmUserAuthList');//企业会员权限列表

        Route::get('/invoices','UserController@invoicesList');//会员发票
        Route::get('/createInvoices','UserController@createInvoices');//新增会员发票
        Route::post('/createInvoices','UserController@createInvoices');//新增会员发票
        Route::get('/editInvoices','UserController@editInvoices');//编辑会员发票
        Route::post('/editInvoices','UserController@editInvoices');//编辑会员发票

        Route::get('/addressList','UserController@shopAddressList');//收货地址列表
        Route::get('/createAddressList','UserController@addShopAddress');//新增收获地
        Route::post('/createAddressList','UserController@addShopAddress');
        Route::post('/getCity','UserController@getCity');//通过省获取市
        Route::post('/getCounty','UserController@getCounty');//通过省获取市
        Route::get('/editAddressList','UserController@updateShopAddress');//编辑收获地
        Route::post('/editAddressList','UserController@updateShopAddress');

        Route::get('/updatePwd','UserController@userUpdatePwd');//修改密码
        Route::post('/updatePwd','UserController@userUpdatePwd');
        Route::get('/forgotPwd','UserController@userForgotPwd');//忘记密码
        Route::post('/forgotPwd','UserController@userForgotPwd');
        Route::post('/getCode','UserController@userForgotCode');//重置密码获取验证码

        Route::get('/paypwd', 'UserController@setPayPwd');//设置支付密码
        Route::post('/paypwd', 'UserController@setPayPwd');
        Route::post('/paypwdByCode', 'UserController@sendCodeByPay');//支付密码获取验证码

        Route::resource('goodsCate', 'GoodsCategoryController');//产品信息
        Route::get('goodsList', 'GoodsController@goodsList');//产品列表

        Route::get('/stockIn','FirmStockController@createFirmStock');//入库记录列表
        Route::get('/addStockIn','FirmStockController@addFirmStock');//新增入库记录
        Route::post('/addStockIn','FirmStockController@addFirmStock');

        Route::get('/stockOut','FirmStockController@firmStockOut');//出库记录列表
        Route::get('/addStockOut','FirmStockController@addFirmSotckOut');//新增出库记录
        Route::post('/addStockOut','FirmStockController@addFirmSotckOut');

        Route::get('/goodsQuote','ShopGoodsQuoteController@goodsQuoteList');//报价列表
        Route::get('/cart','GoodsController@cart');//购物车列表
        Route::post('/cart','GoodsController@cart');//加入购物车
        Route::post('/checkListen','GoodsController@checkListen');//购物车多选框
        Route::post('/toBalance','GoodsController@toBalance');//购物车去结算
        Route::get('/confirmOrder','GoodsController@confirmOrder');//确认订单页面
        Route::post('/createOrder','GoodsController@createOrder');//提交订单
        Route::get('/clearCart','GoodsController@clearCart');//清空购物车

        Route::get('/order','GoodsController@orderList');//我的订单
        Route::post('/egis','GoodsController@egis');//订单审核通过
        Route::post('/cancel','GoodsController@cancel');//订单审核通过
        Route::get('/orderDetails/{id}','GoodsController@orderDetails');//订单详情
        Route::get('/pay','GoodsController@pay');//支付界面
        Route::get('/waitConfirm','GoodsController@waitConfirm');//等待审核界面

        Route::get('/collectGoodsList','UserController@userCollectGoodsList');//产品收藏列表
        Route::post('/addCollectGoods','UserController@addCollectGoods');//收藏商品

        Route::get('/article/{id}','IndexController@article');//资讯

        Route::get('/logout', 'UserController@logout');//登出
    });
});


//商户
Route::group(['namespace' => 'seller'], function () {
    Route::group(['middleware' => 'seller.auth'], function () {
        Route::get('/login.html', 'ShopLoginController@login');
//        Route::post('/login', 'ShopLoginController@login');
        Route::get('/register.html', 'ShopLoginController@register');
        Route::post('/register', 'ShopLoginController@register');
        Route::post('/getSmsCode', 'ShopLoginController@getSmsCode');
    });
});

Route::pattern('path','.+');
Route::any('{path}', 'CommonController@route');






