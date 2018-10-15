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

//图形验证码
Route::get('/verifyCode', 'VerifyCodeController@create');
Route::post('/checkVerifyCode', 'VerifyCodeController@check');
//图片上传
Route::post('/uploadImg', 'UploadController@uploadImg');

//后台
Route::group(['namespace'=>'Admin', 'prefix'=>'admin'],function() {
    Route::get('/', 'LoginController@loginForm');
    Route::get('/login', 'LoginController@loginForm')->name('admin_login');
    Route::post('/login', 'LoginController@login');

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/logout', 'LoginController@logout');
        Route::get('/index', 'IndexController@index');
        Route::get('/home', 'IndexController@home');
        Route::get('/clear', 'IndexController@clear');

        Route::get('/adminuser/list','AdminUserController@list');//管理员列表
        Route::get('/adminuser/addForm','AdminUserController@addForm');//添加
        Route::get('/adminuser/editForm','AdminUserController@editForm');//编辑
        Route::post('/adminuser/save','AdminUserController@save');//保存
        Route::get('/adminuser/log','AdminUserController@log');//日志
        Route::get('/adminuser/detail','AdminUserController@detail');//详情
        Route::get('/adminuser/delete','AdminUserController@delete');//删除
        Route::post('/adminuser/change/isFreeze','AdminUserController@isFreeze');//修改状态

        Route::any('/user/list', 'UserController@list');//用户列表
        Route::post('/user/change/active', 'UserController@modifyFreeze');//修改用户冻结状态
        Route::get('/user/log', 'UserController@log');//查看用户日志信息
        Route::get('/user/detail', 'UserController@detail');//查看用户详情信息
        Route::get('/user/verifyForm', 'UserController@verifyForm');//用户审核
        Route::post('/user/verify', 'UserController@verify');//用户审核
        Route::get('/user/export', 'UserController@export');//用户导出excel
        Route::get('/user/userRealForm', 'UserController@userRealForm');//实名认证
        Route::post('/user/userReal', 'UserController@userReal');//实名认证审核
        Route::get('/user/points', 'UserController@points');//查看积分

        Route::any('/blacklist/list', 'FirmBlacklistController@list');//黑名单企业
        Route::get('/blacklist/addForm', 'FirmBlacklistController@addForm');//黑名单添加（表单）
        Route::post('/blacklist/save', 'FirmBlacklistController@save');//黑名单添加
        Route::get('/blacklist/delete', 'FirmBlacklistController@delete');//黑名单删除
        Route::post('/blacklist/deleteall', 'FirmBlacklistController@deleteAll');//黑名单批量删除
        Route::get('/blacklist/export', 'FirmBlacklistController@export');//黑名单导出excel

        Route::get('/region/list', 'RegionController@list');//地区列表
        Route::post('/region/save', 'RegionController@save');//地区添加
        Route::get('/region/delete', 'RegionController@delete');//地区删除
        Route::post('/region/linkage', 'RegionController@linkage');//地区删除
        Route::post('/region/modify', 'RegionController@modify');//地区修改

        Route::get('/goodscategory/list', 'GoodsCategoryController@list');//产品分类列表
        Route::get('/goodscategory/addForm', 'GoodsCategoryController@addForm');//产品分类添加
        Route::post('/goodscategory/save', 'GoodsCategoryController@save');//产品分类保存
        Route::get('/goodscategory/delete', 'GoodsCategoryController@delete');//产品分类删除
        Route::get('/goodscategory/editForm', 'GoodsCategoryController@editForm');//产品分类编辑
        Route::post('/goodscategory/sort', 'GoodsCategoryController@sort');//产品分类排序
        Route::post('/goodscategory/upload', 'GoodsCategoryController@upload');//上传自定义图标

        Route::get('/sysconfig/index', 'SysConfigController@index');//平台配置首页
        Route::post('/sysconfig/modify', 'SysConfigController@modify');//平台配置修改

        Route::get('/seo/index', 'SeoController@index');//seo配置首页
        Route::post('/seo/modify', 'SeoController@modify');//seo配置修改

        Route::get('/link/list', 'FriendLinkController@list');//友情链接列表
        Route::get('/link/addForm', 'FriendLinkController@addForm');//友情链接添加
        Route::get('/link/editForm', 'FriendLinkController@editForm');//友情链接编辑
        Route::get('/link/delete', 'FriendLinkController@delete');//友情链接删除
        Route::post('/link/save', 'FriendLinkController@save');//友情链接保存
        Route::post('/link/sort', 'FriendLinkController@sort');//友情链接排序ajax

        Route::get('/nav/list', 'NavController@list');//自定义导航栏列表
        Route::post('/nav/change/isShow', 'NavController@isShow');//修改是否显示的状态
        Route::post('/nav/change/openNew', 'NavController@openNew');//修改是否在新窗口显示
        Route::get('/nav/addForm', 'NavController@addForm');//导航栏添加
        Route::get('/nav/editForm', 'NavController@editForm');//导航栏编辑
        Route::get('/nav/delete', 'NavController@delete');//导航栏删除
        Route::post('/nav/add', 'NavController@add');//导航栏保存
        Route::post('/nav/sort', 'NavController@sort');//导航栏排序

        Route::get('/articlecat/list', 'ArticleCatController@list');//文章分类列表
        Route::get('/articlecat/addForm', 'ArticleCatController@addForm');//文章分类添加
        Route::get('/articlecat/editForm', 'ArticleCatController@editForm');//文章分类编辑
        Route::post('/articlecat/save', 'ArticleCatController@save');//文章分类保存
        Route::post('/articlecat/sort', 'ArticleCatController@sort');//文章分类排序（ajax）
        Route::get('/articlecat/delete', 'ArticleCatController@delete');//文章分类删除

        Route::get('/article/list', 'ArticleController@list');//文章列表
        Route::get('/article/addForm', 'ArticleController@addForm');//文章添加
        Route::get('/article/editForm', 'ArticleController@editForm');//文章编辑
        Route::post('/article/save', 'ArticleController@save');//文章保存
        Route::get('/article/detail', 'ArticleController@detail');//文章详情
        Route::post('/article/sort', 'ArticleController@sort');//文章排序（ajax）
        Route::get('/article/delete', 'ArticleController@delete');//文章删除
        Route::post('/article/change/isShow', 'ArticleController@isShow');//ajax修改状态

        Route::get('/brand/list', 'BrandController@list');//品牌列表
        Route::post('/brand/change/isRemmond', 'BrandController@isRemmond');//ajax修改状态
        Route::post('/brand/sort', 'BrandController@sort');//ajax排序
        Route::get('/brand/addForm', 'BrandController@addForm');//添加
        Route::get('/brand/editForm', 'BrandController@editForm');//编辑
        Route::get('/brand/delete', 'BrandController@delete');//删除
        Route::post('/brand/save', 'BrandController@save');//保存

        Route::get('/goods/list', 'GoodsController@list');//产品列表
        Route::get('/goods/addForm', 'GoodsController@addForm');//产品列表
        Route::get('/goods/editForm', 'GoodsController@editForm');//产品列表
        Route::get('/goods/detail', 'GoodsController@detail');//产品详情
        Route::post('/goods/save', 'GoodsController@save');//产品列表
        Route::get('/goods/delete', 'GoodsController@delete');//产品列表
        Route::post('/goods/getAttrs', 'GoodsController@getAttrs');//获取属性名
        Route::post('/goods/getAttrValues', 'GoodsController@getAttrValues');//获取属性值

        Route::get('/unit/list', 'UnitController@list');//单位列表
        Route::get('/unit/addForm', 'UnitController@addForm');//添加单位
        Route::get('/unit/editForm', 'UnitController@editForm');//修改单位
        Route::post('/unit/save', 'UnitController@save');//保存
        Route::post('/unit/sort', 'UnitController@sort');//排序
        Route::get('/unit/delete', 'UnitController@delete');//删除

        Route::get('/shop/list', 'ShopController@list');//入驻店铺列表
        Route::get('/shop/addForm', 'ShopController@addForm');//添加店铺
        Route::get('/shop/editForm', 'ShopController@editForm');//修改店铺
        Route::post('/shop/save', 'ShopController@save');//保存
        Route::post('/brand/change/isFreeze', 'ShopController@isFreeze');//修改状态
        Route::post('/brand/change/isValidated', 'ShopController@isValidated');//修改状态
        Route::get('/shop/detail', 'ShopController@detail');//详情
        Route::get('/shop/logList', 'ShopController@logList');//日志信息
        Route::post('/shop/getUsers', 'ShopController@getUsers');//查询用户

        Route::get('/shopuser/list', 'ShopUserController@list');//店铺职员列表
        Route::get('/shopuser/addForm', 'ShopUserController@addForm');//添加职员
        Route::get('/shopuser/editForm', 'ShopUserController@editForm');//修改职员
        Route::post('/shopuser/save', 'ShopUserController@save');//保存
        Route::get('/shopuser/delete', 'ShopUserController@delete');//删除

        Route::get('/shopgoods/list', 'ShopGoodsController@list');//店铺产品列表
        Route::get('/shopgoods/addForm', 'ShopGoodsController@addForm');//店铺产品添加
        Route::get('/shopgoods/editForm', 'ShopGoodsController@editForm');//店铺产品编辑
        Route::post('/shopgoods/save', 'ShopGoodsController@save');//保存
        Route::post('/shopgoods/getGoods', 'ShopGoodsController@getGoods');//ajax获取产品
        Route::get('/shopgoods/delete', 'ShopGoodsController@delete');//删除


        Route::get('/shopgoodsquote/list', 'ShopGoodsQuoteController@list');//店铺产品报价列表
        Route::get('/shopgoodsquote/addForm', 'ShopGoodsQuoteController@addForm');//添加
        Route::get('/shopgoodsquote/editForm', 'ShopGoodsQuoteController@editForm');//编辑
        Route::post('/shopgoodsquote/save', 'ShopGoodsQuoteController@save');//保存
        Route::get('/shopgoodsquote/delete', 'ShopGoodsQuoteController@delete');//删除

        Route::any('/orderinfo/list', 'OrderInfoController@list');//订单列表
        Route::get('/orderinfo/detail', 'OrderInfoController@detail');//订单详情
        Route::post('/orderinfo/save', 'OrderInfoController@save');//保存
        Route::post('/orderinfo/modify', 'OrderInfoController@modify');//修改
        Route::post('/orderinfo/modify2', 'OrderInfoController@modify2');//修改
        Route::get('/orderinfo/modifyConsignee', 'OrderInfoController@modifyConsignee');//编辑收货人信息
        Route::get('/orderinfo/modifyInvoice', 'OrderInfoController@modifyInvoice');//编辑发票信息
        Route::post('/orderinfo/saveInvoice', 'OrderInfoController@saveInvoice');//保存发票修改信息
        Route::get('/orderinfo/modifyOrderGoods', 'OrderInfoController@modifyOrderGoods');//编辑商品信息
        Route::post('/orderinfo/saveOrderGoods', 'OrderInfoController@saveOrderGoods');//保存商品修改信息

        Route::get('/template/index', 'TemplateController@index');//首页可视化
        Route::get('/template/decorate', 'TemplateController@decorate');//装修模板
        Route::post('/template/saveTemplate', 'TemplateController@saveTemplate');//模板缓存
        Route::post('/template/publish', 'TemplateController@publish');//确认发布
        Route::post('/template/partEdit', 'TemplateController@partEdit');//模板编辑
        Route::get('/template/preview', 'TemplateController@preview');//模板预览
        Route::get('/template/decoratetest', 'TemplateController@decoratetest');//装修模板(测试)
        Route::get('/template/getPics', 'TemplateController@getPics');//测试方法

    });

});

Route::group(['namespace'=>'Web','middleware' => 'web.closed'],function() {
    Route::post('/user/checkNameExists', 'UserController@checkNameExists');//验证用户名是否存在
    Route::post('/user/checkCanRegister', 'UserController@checkCompanyNameCanAdd');//验证用户名是否存在
    Route::get('/register/sendSms', 'UserController@sendSms');//发送注册短信

    Route::get('/userRegister', 'UserController@userRegister')->name('register');//个人注册
    Route::post('/userRegister', 'UserController@userRegister');
    Route::get('/firmRegister', 'UserController@firmRegister')->name('firmRegister');//企业注册
    Route::post('/firmRegister', 'UserController@firmRegister');

    Route::get('/login', 'UserController@showLoginForm')->name('login');//登陆
    Route::post('/login', 'UserController@login');

    Route::group(['middleware' => 'web.auth'], function () {

        Route::get('/middle','UserController@middlePage');//中间页
        Route::post('/selectCompany','IndexController@selectCompany');//选择公司
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
        Route::post('/clearCart','GoodsController@clearCart');//清空购物车
        Route::post('/editCartNum','GoodsController@editCartNum');//修改购物车数量

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
Route::group(['namespace' => 'seller','prefix' => 'seller'], function () {
    Route::get('/login.html', 'LoginController@login')->name('seller_login');
    Route::post('/login', 'LoginController@login');
    Route::get('/register.html', 'LoginController@register');
    Route::post('/register', 'LoginController@register');
    Route::post('/getSmsCode', 'LoginController@getSmsCode');
    Route::get('/checkShopName', 'LoginController@checkShopName');
    Route::get('/checkCompany', 'LoginController@checkCompany');
    Route::group(['middleware' => 'seller.auth'], function () {

        Route::get('/login.html', 'ShopLoginController@login');
//        Route::post('/login', 'ShopLoginController@login');
        Route::get('/register.html', 'ShopLoginController@register');
        Route::post('/register', 'ShopLoginController@register');
        Route::post('/getSmsCode', 'ShopLoginController@getSmsCode');

        Route::get('/', 'IndexController@index');
        Route::get('/home', 'IndexController@home');
        Route::get('/logout', 'LoginController@logout');
        Route::get('/detail', 'indexController@detail');

        Route::get('/shopUser', 'ShopUserController@list');// 商户职员管理
        Route::get('/shopUser/add', 'ShopUserController@add');
        Route::get('/shopUser/edit', 'ShopUserController@edit');
        Route::post('/shopUser/save', 'ShopUserController@save');
        Route::post('/shopUser/delete', 'ShopUserController@delete');

        Route::get('/goods/list', 'ShopGoodsController@list');// 商户商品操作
        Route::get('/goods/add', 'ShopGoodsController@add');
        Route::get('/goods/edit', 'ShopGoodsController@edit');
        Route::post('/goods/save', 'ShopGoodsController@save');
        Route::post('/goods/delete', 'ShopGoodsController@delete');

        Route::post('/goods/getGoods', 'ShopGoodsController@getGoods');

        Route::get('/quote/list', 'ShopGoodsQuoteController@list');// 商户商品报价
        Route::get('/quote/add', 'ShopGoodsQuoteController@add');
        Route::get('/quote/edit', 'ShopGoodsQuoteController@edit');
        Route::post('/quote/save', 'ShopGoodsQuoteController@save');
        Route::post('/quote/delete', 'ShopGoodsQuoteController@delete');

        Route::get('/order/list', 'ShopOrderController@list');// 商铺订单
        Route::get('/order/detail', 'ShopOrderController@detail');
        Route::post('/order/updateOrderStatus', 'ShopOrderController@updateOrderStatus');

    });
});

Route::pattern('path','.+');
Route::any('{path}', 'CommonController@route');






