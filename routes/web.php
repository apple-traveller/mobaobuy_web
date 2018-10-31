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
//省市县
Route::post('/region/level', 'RegionController@regionLevelList');

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
        Route::get('/user/export', 'UserController@export');//用户导出excel
        Route::get('/user/userRealForm', 'UserController@userRealForm');//实名认证
        Route::post('/user/userReal', 'UserController@userReal');//实名认证审核
        Route::get('/user/points', 'UserController@points');//查看积分
        Route::get('/user/firmStock', 'UserController@firmStock');//查看企业库存
        Route::post('/user/firmStockFlow', 'UserController@firmStockFlow');//查看企业库存流水

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

        Route::get('/goodscategory/list', 'GoodsCategoryController@list');//商品分类列表
        Route::get('/goodscategory/addForm', 'GoodsCategoryController@addForm');//商品分类添加
        Route::post('/goodscategory/save', 'GoodsCategoryController@save');//商品分类保存
        Route::get('/goodscategory/delete', 'GoodsCategoryController@delete');//商品分类删除
        Route::get('/goodscategory/editForm', 'GoodsCategoryController@editForm');//商品分类编辑
        Route::post('/goodscategory/sort', 'GoodsCategoryController@sort');//商品分类排序
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

        Route::get('/goods/list', 'GoodsController@list');//商品列表
        Route::get('/goods/addForm', 'GoodsController@addForm');//商品列表
        Route::get('/goods/editForm', 'GoodsController@editForm');//商品列表
        Route::get('/goods/detail', 'GoodsController@detail');//商品详情
        Route::post('/goods/save', 'GoodsController@save');//商品列表
        Route::get('/goods/delete', 'GoodsController@delete');//商品列表
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

        Route::get('/shopgoods/list', 'ShopGoodsController@list');//店铺商品列表
        Route::get('/shopgoods/addForm', 'ShopGoodsController@addForm');//店铺商品添加
        Route::get('/shopgoods/editForm', 'ShopGoodsController@editForm');//店铺商品编辑
        Route::post('/shopgoods/save', 'ShopGoodsController@save');//保存
        Route::post('/shopgoods/getGoods', 'ShopGoodsController@getGoods');//ajax获取商品
        Route::get('/shopgoods/delete', 'ShopGoodsController@delete');//删除


        Route::get('/shopgoodsquote/list', 'ShopGoodsQuoteController@list');//店铺商品报价列表
        Route::get('/shopgoodsquote/addForm', 'ShopGoodsQuoteController@addForm');//添加
        Route::get('/shopgoodsquote/editForm', 'ShopGoodsQuoteController@editForm');//编辑
        Route::post('/shopgoodsquote/save', 'ShopGoodsQuoteController@save');//保存
        Route::get('/shopgoodsquote/delete', 'ShopGoodsQuoteController@delete');//删除

        Route::any('/orderinfo/list', 'OrderInfoController@list');//订单列表
        Route::get('/orderinfo/detail', 'OrderInfoController@detail');//订单详情
        Route::post('/orderinfo/save', 'OrderInfoController@save');//保存
        Route::post('/orderinfo/modify', 'OrderInfoController@modify');//修改
        Route::post('/orderinfo/modify2', 'OrderInfoController@modify2');//修改自动收货时间
        Route::post('/orderinfo/modifyStatus', 'OrderInfoController@modifyStatus');//修改订单状态
        Route::get('/orderinfo/modifyConsignee', 'OrderInfoController@modifyConsignee');//编辑收货人信息
        Route::get('/orderinfo/modifyInvoice', 'OrderInfoController@modifyInvoice');//编辑发票信息
        Route::post('/orderinfo/saveInvoice', 'OrderInfoController@saveInvoice');//保存发票修改信息
        Route::get('/orderinfo/modifyOrderGoods', 'OrderInfoController@modifyOrderGoods');//编辑商品信息
        Route::post('/orderinfo/saveOrderGoods', 'OrderInfoController@saveOrderGoods');//保存商品修改信息
        Route::get('/orderinfo/modifyFee', 'OrderInfoController@modifyFee');//编辑费用信息
        Route::post('/orderinfo/saveFee', 'OrderInfoController@saveFee');//保存费用修改信息
        Route::get('/orderinfo/delivery', 'OrderInfoController@delivery');//发货单
        Route::post('/orderinfo/saveDelivery', 'OrderInfoController@saveDelivery');//保存发货单
        Route::post('/orderinfo/GoodsForm', 'OrderInfoController@GoodsForm');//发货单商品table(渲染表格数据)
        Route::get('/orderinfo/delivery/list', 'OrderInfoController@deliveryList');//发货单列表
        Route::get('/orderinfo/delivery/detail', 'OrderInfoController@deliveryDetail');//发货单详情
        Route::post('/orderinfo/delivery/modifyShippingBillno', 'OrderInfoController@modifyShippingBillno');//修改快递单号
        Route::post('/orderinfo/delivery/modifyDeliveryStatus', 'OrderInfoController@modifyDeliveryStatus');//修改发货状态

        Route::any('/seckill/list', 'SeckillController@list');//秒杀活动列表
        Route::post('/seckill/change/status', 'SeckillController@status');//修改秒杀活动启用状态
        Route::get('/seckill/detail', 'SeckillController@detail');//秒杀活动商品详情
        Route::get('/seckill/delete', 'SeckillController@delete');//秒杀删除
        Route::get('/seckill/addForm', 'SeckillController@addForm');//添加秒杀
        Route::post('/seckill/save', 'SeckillController@save');//保存秒杀
        Route::post('/seckill/getGoodsCat', 'SeckillController@getGoodsCat');//ajax获取商品分类
        Route::post('/seckill/getGood', 'SeckillController@getGood');//ajax获取商品
        Route::get('/seckill/verify', 'SeckillController@verify');//审核
        Route::get('/seckill/time/list', 'SeckillController@timeList');//秒杀时间段列表
        Route::get('/seckill/time/add', 'SeckillController@addTime');//添加秒杀时间段
        Route::get('/seckill/time/edit', 'SeckillController@editTime');//编辑秒杀时间段
        Route::post('/seckill/time/save', 'SeckillController@saveTime');//保存秒杀时间段
        Route::get('/seckill/time/delete', 'SeckillController@deleteTime');//删除秒杀时间段

        Route::get('/ad/position/list', 'AdPositionController@list');//广告位置列表
        Route::get('/ad/position/addForm', 'AdPositionController@addForm');//广告位置添加
        Route::get('/ad/position/editForm', 'AdPositionController@editForm');//广告位置编辑
        Route::post('/ad/position/save', 'AdPositionController@save');//广告位置保存
        Route::get('/ad/position/delete', 'AdPositionController@delete');//广告位置删除

        Route::get('/ad/list', 'AdController@list');//广告图片列表
        Route::get('/ad/addForm', 'AdController@addForm');//广告图片添加
        Route::get('/ad/editForm', 'AdController@editForm');//广告图片编辑
        Route::post('/ad/save', 'AdController@save');//广告图片保存
        Route::post('/ad/change/enabled', 'AdController@enabled');//广告图片状态修改
        Route::get('/ad/delete', 'AdController@delete');//广告图片删除


    });

});

Route::group(['namespace'=>'Web','middleware' => 'web.closed'],function() {
    Route::get('/', 'IndexController@index'); //首页
    Route::post('/user/checkNameExists', 'UserController@checkNameExists');//验证用户名是否存在
    Route::post('/user/checkCanRegister', 'UserController@checkCompanyNameCanAdd');//验证公司是否存在
    Route::get('/register/sendSms', 'UserController@sendRegisterSms');//发送注册短信

    Route::get('/userRegister', 'UserController@userRegister')->name('register');//个人注册
    Route::post('/userRegister', 'UserController@userRegister');
    Route::get('/firmRegister', 'UserController@firmRegister')->name('firmRegister');//企业注册
    Route::post('/firmRegister', 'UserController@firmRegister');

    Route::get('/login', 'UserController@showLoginForm')->name('login');//登陆
    Route::post('/login', 'UserController@login');

    Route::get('/findPwd','UserController@userFindPwd');//忘记密码
    Route::post('/findPwd','UserController@userFindPwd');
    Route::get('/findPwd/sendSms','UserController@sendFindPwdSms');//忘记密码获取验证码
    Route::get('/verifyReg','UserController@verifyReg');//注册等待审核


    Route::get('/cart/num','UserController@getCartNum');//获取用户购物车数量
    Route::post('/demand/add','DemandController@addDemand');//获取用户需求信息

    Route::get('/article/{id}','IndexController@article');//资讯
    Route::get('/news.html', 'NewsController@index'); // 新闻中心
    Route::get('/detail.html', 'NewsController@detail'); // 详情
    Route::post('/side_bar', 'NewsController@side_bar'); // 详情侧边栏

    /********************************产品信息************************************/
    Route::any('/goodsList', 'GoodsController@goodsList');//产品列表
    Route::post('/condition/goodsList', 'GoodsController@goodsListByCondition');//产品列表
    Route::get('/goodsDetail', 'GoodsController@goodsDetail');//产品详情
    /********************************************************************/

    Route::get('/buyLimit', 'ActivityPromoteController@buyLimit');//限时抢购
    Route::get('/buyLimitDetails/{id?}', 'ActivityPromoteController@buyLimitDetails');//限时抢购详情
    Route::get('/goodsAttribute', 'GoodsController@goodsAttribute');//物性表
    Route::post('/goodsAttribute', 'GoodsController@goodsAttribute');//物性表
    Route::get('/goodsAttributeDetails/{id?}', 'GoodsController@goodsAttributeDetails');//物性表详情

    Route::group(['middleware' => 'web.auth'], function () {


        Route::get('/logout', 'UserController@logout');//登出
        Route::get('/payment/orderPay','PayController@orderPay');//去付款
        Route::get('/logistics/detail','KuaidiController@searchWaybill');//查运单

        Route::post('/changeDeputy','IndexController@changeDeputy');//选择公司

        Route::get('/member', 'UserController@index'); //会员中心
        Route::get('/member/emp', 'UserController@empList'); //会员中心
        Route::get('/createFirmUser', 'FirmUserController@createFirmUser');//企业会员绑定
        Route::post('/createFirmUser', 'FirmUserController@createFirmUser');//企业会员绑定
        Route::post('/addFirmUser', 'FirmUserController@addFirmUser');//企业会员绑定权限
        Route::get('/firmUserAuthList', 'FirmUserController@Approval');//企业会员审核属性
        Route::post('/editFirmUser', 'FirmUserController@editFirmUser');//企业会员编辑弹层数据
        Route::post('/OrderNeedApproval', 'FirmUserController@OrderNeedApproval');//订单是否需要审批
        Route::get('/updateUserInfo', 'UserController@userUpdate');//用户信息编辑
        Route::post('/updateUserInfo', 'UserController@userUpdate');//用户信息保存
        Route::post('/delFirmUser', 'FirmUserController@delFirmUser');//企业会员删除

        /*******************************用户信息*************************************/
        Route::get('/account/userInfo', 'UserController@userInfo');//用户信息编辑
        Route::post('/account/saveUser', 'UserController@saveUser');//保存用户信息
        Route::get('/account/viewPoints', 'UserController@viewPoints');//查看积分
        Route::get('/account/userRealInfo', 'UserController@userRealInfo');//实名认证
        Route::post('/account/saveUserReal', 'UserController@saveUserReal');//保存实名
        Route::any('/account/editPayPassword', 'UserController@editPayPassword');//修改支付密码
        Route::any('/account/editPayPassword/sendSms', 'UserController@sendPayPwdSms');//发送支付密码短信
        /********************************************************************/


        /************************发票维护********************************/
//        Route::get('/invoices','UserController@invoicesList');//会员发票
//        Route::get('/createInvoices','UserController@createInvoices');//新增会员发票
//        Route::post('/createInvoices','UserController@createInvoices');//新增会员发票
//        Route::get('/editInvoices','UserController@editInvoices');//编辑会员发票
//        Route::post('/editInvoices','UserController@editInvoices');//编辑会员发票
//        Route::post('/deleteInvoices','UserController@deleteInvoices');//编辑会员发票
//        Route::post('/updateDefaultInvoice','UserController@updateDefaultInvoice');//修改会员默认发票
        /********************************************************************/
        Route::get('/addressList','UserController@shopAddressList');//收货地址列表
        Route::get('/createAddressList','UserController@addShopAddress');//新增收获地
        Route::post('/createAddressList','UserController@addShopAddress');
        Route::post('/getCity','UserController@getCity');//通过省获取市
        Route::post('/getCounty','UserController@getCounty');//通过省获取市
        Route::get('/editAddressList','UserController@updateShopAddress');//编辑收获地
        Route::post('/editAddressList','UserController@updateShopAddress');
        Route::post('/deleteAddress','UserController@deleteAddress'); // 删除地址
        Route::post('/updateDefaultAddress','UserController@updateDefaultAddress'); // 修改默认地址


        Route::get('/updatePwd','UserController@userUpdatePwd');//忘记密码界面
        Route::post('/updatePwd','UserController@userUpdatePwd');
        Route::get('/updatePwd/sendSms', 'UserController@sendUpdatePwdSms');//修改密码发送验证码


        Route::get('/paypwd', 'UserController@setPayPwd');//设置支付密码
        Route::post('/paypwd', 'UserController@setPayPwd');
        Route::post('/paypwdByCode', 'UserController@sendCodeByPay');//支付密码获取验证码


//        Route::get('/stockNum','FirmStockController@stockList');//企业库存
        Route::get('/canStockOut','FirmStockController@canStockOut');//可出库库存
        Route::post('/canStockOut','FirmStockController@canStockOut');//可出库库存

        Route::get('/stockIn','FirmStockController@FirmStockIn');//入库记录列表
        Route::post('/stockIn','FirmStockController@FirmStockIn');//入库记录列表
        Route::get('/addStockIn','FirmStockController@addFirmStock');//新增入库记录
        Route::post('/addStockIn','FirmStockController@addFirmStock');
        Route::post('/searchGoodsName','FirmStockController@searchGoodsName');//入库检索商品名称
        Route::post('/searchPartnerName','FirmStockController@searchPartnerName');//入库检索供应商名称
        Route::post('/searchStockIn','FirmStockController@searchStockIn');//入库查询

        Route::get('/stockOut/{goodsName?}/{begin_time?}/{end_time?}','FirmStockController@firmStockOut');   //出库记录列表
        Route::post('/stockOut','FirmStockController@firmStockOut');//出库记录列表
        Route::get('/addStockOut','FirmStockController@addFirmSotckOut');//新增出库记录
        Route::post('/addStockOut','FirmStockController@addFirmSotckOut');
        Route::post('/stock/info','FirmStockController@stockInfo');//可出库单条记录
        Route::post('/curStockSave','FirmStockController@curStockSave');//出库更新保存

        Route::get('/stock/list','FirmStockController@stockList');//实时库存
        Route::post('/stock/list','FirmStockController@stockList');//实时库存
        Route::get('/stock/flow','FirmStockController@stockFlowList');//企业库存详细
        Route::post('/stock/flow','FirmStockController@stockFlowList');//企业库存详细

        Route::get('/goodsQuote','ShopGoodsQuoteController@goodsQuoteList');//报价列表
        Route::get('/cart','GoodsController@cart');//购物车列表
        Route::post('/cart','GoodsController@cart');//加入购物车
        Route::post('/checkListen','GoodsController@checkListen');//购物车多选框
        Route::post('/toBalance','GoodsController@toBalance');//购物车去结算
        Route::get('/confirmOrder','GoodsController@confirmOrder');//确认订单页面
        Route::post('/createOrder','GoodsController@createOrder');//提交订单
        Route::post('/clearCart','GoodsController@clearCart');//清空购物车
        Route::post('/editCartNum','GoodsController@editCartNum');//修改购物车数量
        Route::post('/delCart','GoodsController@delCart');//删除购物车数量
        Route::post('/addCartGoodsNum','GoodsController@addCartGoodsNum');//增加购物车数量

        Route::post('/reduceGoodsNum','GoodsController@reduceGoodsNum');//减少购物车数量
        Route::get('/orderSubmission.html','GoodsController@orderSubmission');// 订单确认页面
        Route::post('/reduceCartGoodsNum','GoodsController@reduceCartGoodsNum');//减少购物车数量


        Route::get('/order/list','OrderController@orderList');//我的订单
        Route::post('/order/list','OrderController@orderList');//我的订单
        Route::post('/order/status','OrderController@orderStatusCount');//我的订单
        Route::post('/orderDel','OrderController@orderDel');//订单删除
        Route::get('/invoice',  'InvoiceController@invoiceList'); // 开票列表
        Route::post('/invoice/confirm',  'InvoiceController@confirm'); // 开票确认页面
        Route::post('/invoice/apply',  'InvoiceController@applyInvoice'); // 开票确认页面


        Route::post('/egis','OrderController@egis');//订单审核通过
        Route::post('/orderCancel','OrderController@orderCancel');//订单取消
        Route::get('/orderDetails/{id}','OrderController@orderDetails');//订单详情
        Route::get('/pay','GoodsController@pay');//支付界面
        Route::get('/waitConfirm','GoodsController@waitConfirm');//等待审核界面
        Route::post('/orderConfirmTake','OrderController@orderConfirmTake');//确认收货

        Route::get('/collectGoodsList','UserController@userCollectGoodsList');//商品收藏列表
        Route::post('/collectGoodsList','UserController@userCollectGoodsList');//商品收藏列表
        Route::post('/addCollectGoods','UserController@addCollectGoods');//收藏商品
        Route::post('/delCollectGoods','UserController@delCollectGoods');//硬删除收藏商品


    });
});


// 商户
Route::group(['namespace' => 'Seller','prefix' => 'seller'], function () {
    Route::get('/login.html', 'LoginController@login')->name('seller_login');
    Route::post('/login', 'LoginController@login');
    Route::get('/register.html', 'LoginController@register');
    Route::post('/register', 'LoginController@register');
    Route::post('/getSmsCode', 'LoginController@getSmsCode');
    Route::post('/checkShopName', 'LoginController@checkShopName');
    Route::get('/checkCompany', 'LoginController@checkCompany');
    Route::group(['middleware' => 'seller.auth'], function () {

        Route::get('/', 'IndexController@index');
        Route::get('/home', 'IndexController@home');
        Route::get('/logout', 'LoginController@logout');
        Route::get('/detail', 'indexController@detail');

        Route::get('/shopUser', 'ShopUserController@list');// 商户职员管理
        Route::get('/shopUser/add', 'ShopUserController@add');// 添加
        Route::get('/shopUser/edit', 'ShopUserController@edit');// 修改
        Route::post('/shopUser/save', 'ShopUserController@save');// 保存
        Route::post('/shopUser/delete', 'ShopUserController@delete');// 删除

        Route::get('/goods/list', 'ShopGoodsController@list');// 商户商品操作
//        Route::get('/goods/add', 'ShopGoodsController@add');
//        Route::get('/goods/edit', 'ShopGoodsController@edit');
//        Route::post('/goods/save', 'ShopGoodsController@save');
//        Route::post('/goods/delete', 'ShopGoodsController@delete');
        Route::get('/goods/GoodsForm', 'ShopGoodsController@GoodsForm');//

        Route::post('/goods/getGoods', 'ShopGoodsController@getGoods');

        Route::get('/quote/list', 'ShopGoodsQuoteController@list');// 商户商品报价
        Route::get('/quote/add', 'ShopGoodsQuoteController@add');//  添加
        Route::get('/quote/edit', 'ShopGoodsQuoteController@edit');// 编辑
        Route::post('/quote/save', 'ShopGoodsQuoteController@save');// 保存
        Route::post('/quote/delete', 'ShopGoodsQuoteController@delete');// 删除

        Route::get('/order/list', 'ShopOrderController@list');// 商铺订单
        Route::get('/order/detail', 'ShopOrderController@detail');  // 订单详情
        Route::post('/order/updateOrderStatus', 'ShopOrderController@updateOrderStatus'); // 更新订单状态
        Route::post('/order/toBuyerModify', 'ShopOrderController@toBuyerModify'); // 修改商家留言
        Route::get('/order/modifyGoodsInfo', 'ShopOrderController@modifyGoodsInfo'); // 修改订单中商品信息-页面
        Route::post('/order/modifyReceiveDate', 'ShopOrderController@modifyReceiveDate'); // 修改自动确认收获的天数
        Route::post('/order/saveGoods', 'ShopOrderController@saveGoods'); // 修改订单商品信息-动作
        Route::get('/order/modifyFree', 'ShopOrderController@modifyFree'); // 维护运费 & 折扣
        Route::post('/order/saveFree', 'ShopOrderController@saveFree'); // 维护运费 & 折扣- 保存
        Route::get('/order/delivery', 'ShopOrderController@delivery'); // 发货订单
        Route::post('/order/orderGoods', 'ShopOrderController@orderGoods');  //  为发货订单提供商品接口
        Route::post('/order/saveDelivery', 'ShopOrderController@saveDelivery'); //  生成发货单 订单商品数量在此处修改

        Route::get('/delivery/list', 'ShopDeliveryController@list');// 发货订单
        Route::get('/delivery/detail', 'ShopDeliveryController@detail');// 发货订单详情
        Route::post('/delivery/updateStatus', 'ShopDeliveryController@updateStatus');  // 更改订单状态
        Route::post('/delivery/modifyShippingBillno', 'ShopDeliveryController@modifyShippingBillno'); // 修改订单号

        Route::get('/seckill/list', 'SeckillController@seckill');// 秒杀 //
        Route::get('/seckill/add', 'SeckillController@addForm'); // 添加
        Route::post('/seckill/save', 'SeckillController@save'); //  保存
        Route::post('/seckill/delete', 'SeckillController@delete'); // 删除
        Route::get('/seckill/goods_list', 'SeckillController@goods_list'); // 为添加秒杀商品提供页面
        Route::get('/seckill/list_detail', 'SeckillController@list_detail'); // 列表详情

        Route::get('/activity/promoter', 'ActivityController@promoter'); // 优惠活动
        Route::get('/activity/addPromoter', 'ActivityController@addPromoter'); // 添加 编辑 页面
        Route::post('/activity/savePromoter', 'ActivityController@savePromoter'); // 添加 编辑 保存
        Route::post('/activity/deletePromoter', 'ActivityController@delete'); // 删除

        Route::get('/invoice/list', 'InvoiceController@list'); // 客户开票申请列表
        Route::get('/invoice/detail', 'InvoiceController@detail'); // 详情页
        Route::get('/invoice/choseExpress', 'InvoiceController@choseExpress'); // 审核选择地址
        Route::post('/invoice/verifyInvoice', 'InvoiceController@verifyInvoice'); // 审核 - 动作
        Route::post('/invoice/cancelInvoice', 'InvoiceController@cancelInvoice'); // 作废 - 动作
    });
});

Route::pattern('path','.+');
Route::any('{path}', 'CommonController@route');








