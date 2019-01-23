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
Route::get('closeQuote', 'CommonController@closeQuote');

//后台
Route::group(['namespace'=>'Admin', 'prefix'=>'admin'],function() {
    Route::get('/', 'LoginController@loginForm');
    Route::get('/login', 'LoginController@loginForm')->name('admin_login');
    Route::post('/login', 'LoginController@login');

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/logout', 'LoginController@logout');
        Route::get('/index', 'IndexController@index');
        Route::get('/home', 'IndexController@home');
        Route::post('/home/getMonthlyOrders', 'IndexController@getMonthlyOrders');
        Route::get('/clear', 'IndexController@clear');
        Route::get('/getActivityCount', 'IndexController@getActivityCount');

        Route::get('/adminuser/list','AdminUserController@getList');//管理员列表
        Route::get('/adminuser/addForm','AdminUserController@addForm');//添加
        Route::get('/adminuser/editForm','AdminUserController@editForm');//编辑
        Route::post('/adminuser/save','AdminUserController@save');//保存
        Route::get('/adminuser/log','AdminUserController@log');//日志
        Route::get('/adminuser/detail','AdminUserController@detail');//详情
        Route::get('/adminuser/delete','AdminUserController@delete');//删除
        Route::post('/adminuser/change/isFreeze','AdminUserController@isFreeze');//修改状态
        Route::any('/adminuser/modifyPass','AdminUserController@modifyPass');//修改状态

        Route::any('/user/list', 'UserController@getList');//用户列表
        Route::post('/user/change/active', 'UserController@modifyFreeze');//修改用户冻结状态
        Route::post('/user/change/modifyNeedApproval', 'UserController@modifyNeedApproval');//修改企业用户是否需要审批订单字段
        Route::post('/userreal/change/realname', 'UserController@modifyRealName');//修改实名表的real_name
        Route::get('/user/log', 'UserController@log');//查看用户日志信息
        Route::get('/user/detail', 'UserController@detail');//查看用户详情信息
        Route::get('/user/export', 'UserController@export');//用户导出excel
        Route::get('/user/userRealForm', 'UserController@userRealForm');//实名认证
        Route::post('/user/userReal', 'UserController@userReal');//实名认证审核
        Route::get('/user/points', 'UserController@points');//查看积分
        Route::get('/user/firmStock', 'UserController@firmStock');//查看企业库存
        Route::post('/user/firmStockFlow', 'UserController@firmStockFlow');//查看企业库存流水
        Route::get('/user/addForm', 'UserController@addForm');//添加用户
        Route::post('/user/save', 'UserController@save');//保存
        Route::any('/user/addUserRealForm', 'UserController@addUserRealForm');//添加实名认证
        Route::post('/user/saveUserReal', 'UserController@saveUserReal');//保存
        Route::post('/user/change_userreal', 'UserController@changeUserReal');//修改身份证信息和营业执照信息

        Route::any('/blacklist/list', 'FirmBlackController@getList');//黑名单企业
        Route::get('/blacklist/addForm', 'FirmBlackController@addForm');//黑名单添加（表单）
        Route::post('/blacklist/save', 'FirmBlackController@save');//黑名单添加
        Route::get('/blacklist/delete', 'FirmBlackController@delete');//黑名单删除
        Route::post('/blacklist/deleteall', 'FirmBlackController@deleteAll');//黑名单批量删除
        Route::get('/blacklist/export', 'FirmBlackController@export');//黑名单导出excel

        Route::get('/region/list', 'RegionController@getList');//地区列表
        Route::post('/region/save', 'RegionController@save');//地区添加
        Route::get('/region/delete', 'RegionController@delete');//地区删除
        Route::post('/region/linkage', 'RegionController@linkage');//地区删除
        Route::post('/region/modify', 'RegionController@modify');//地区修改
        Route::any('/region/getRegionTree', 'RegionController@getRegionTree');//地区修改

        Route::get('/goodscategory/list', 'GoodsCategoryController@getList');//商品分类列表
        Route::get('/goodscategory/addForm', 'GoodsCategoryController@addForm');//商品分类添加
        Route::post('/goodscategory/save', 'GoodsCategoryController@save');//商品分类保存
        Route::get('/goodscategory/delete', 'GoodsCategoryController@delete');//商品分类删除
        Route::get('/goodscategory/editForm', 'GoodsCategoryController@editForm');//商品分类编辑
        Route::post('/goodscategory/sort', 'GoodsCategoryController@sort');//商品分类排序
        Route::post('/goodscategory/upload', 'GoodsCategoryController@upload');//上传自定义图标
        Route::any('/goodscategory/getCategoryTree', 'GoodsCategoryController@getCategoryTree');//分类树

        Route::get('/sysconfig/index', 'SysConfigController@index');//平台配置首页
        Route::post('/sysconfig/modify', 'SysConfigController@modify');//平台配置修改

        Route::get('/seo/index', 'SeoController@index');//seo配置首页
        Route::post('/seo/modify', 'SeoController@modify');//seo配置修改

        Route::get('/link/list', 'FriendLinkController@getList');//友情链接列表
        Route::get('/link/addForm', 'FriendLinkController@addForm');//友情链接添加
        Route::get('/link/editForm', 'FriendLinkController@editForm');//友情链接编辑
        Route::get('/link/delete', 'FriendLinkController@delete');//友情链接删除
        Route::post('/link/save', 'FriendLinkController@save');//友情链接保存
        Route::post('/link/sort', 'FriendLinkController@sort');//友情链接排序ajax

        Route::get('/nav/list', 'NavController@getList');//自定义导航栏列表
        Route::post('/nav/change/isShow', 'NavController@isShow');//修改是否显示的状态
        Route::post('/nav/change/openNew', 'NavController@openNew');//修改是否在新窗口显示
        Route::get('/nav/addForm', 'NavController@addForm');//导航栏添加
        Route::get('/nav/editForm', 'NavController@editForm');//导航栏编辑
        Route::get('/nav/delete', 'NavController@delete');//导航栏删除
        Route::post('/nav/add', 'NavController@add');//导航栏保存
        Route::post('/nav/sort', 'NavController@sort');//导航栏排序

        Route::get('/articlecat/list', 'ArticleCatController@getList');//文章分类列表
        Route::get('/articlecat/addForm', 'ArticleCatController@addForm');//文章分类添加
        Route::get('/articlecat/editForm', 'ArticleCatController@editForm');//文章分类编辑
        Route::post('/articlecat/save', 'ArticleCatController@save');//文章分类保存
        Route::post('/articlecat/sort', 'ArticleCatController@sort');//文章分类排序（ajax）
        Route::get('/articlecat/delete', 'ArticleCatController@delete');//文章分类删除

        Route::get('/article/list', 'ArticleController@getList');//文章列表
        Route::get('/article/addForm', 'ArticleController@addForm');//文章添加
        Route::get('/article/editForm', 'ArticleController@editForm');//文章编辑
        Route::post('/article/save', 'ArticleController@save');//文章保存
        Route::get('/article/detail', 'ArticleController@detail');//文章详情
        Route::post('/article/sort', 'ArticleController@sort');//文章排序（ajax）
        Route::get('/article/delete', 'ArticleController@delete');//文章删除
        Route::post('/article/change/isShow', 'ArticleController@isShow');//ajax修改状态

        Route::get('/brand/list', 'BrandController@getList');//品牌列表
        Route::post('/brand/change/isRemmond', 'BrandController@isRemmond');//ajax修改状态
        Route::post('/brand/sort', 'BrandController@sort');//ajax排序
        Route::get('/brand/addForm', 'BrandController@addForm');//添加
        Route::get('/brand/editForm', 'BrandController@editForm');//编辑
        Route::get('/brand/delete', 'BrandController@delete');//删除
        Route::post('/brand/save', 'BrandController@save');//保存

        Route::get('/goods/list', 'GoodsController@getList');//商品列表
        Route::get('/goods/addForm', 'GoodsController@addForm');//商品列表
        Route::get('/goods/editForm', 'GoodsController@editForm');//商品列表
        Route::get('/goods/detail', 'GoodsController@detail');//商品详情
        Route::post('/goods/save', 'GoodsController@save');//商品列表
        Route::get('/goods/delete', 'GoodsController@delete');//商品列表
        Route::post('/goods/getAttrs', 'GoodsController@getAttrs');//获取属性名
        Route::post('/goods/getAttrValues', 'GoodsController@getAttrValues');//获取属性值

        //重新发布报价参数配置 根据商品分类
        Route::get('/goodscategoryquoteconfig/list', 'GoodsCategoryQuoteConfigController@getList');
        Route::get('/goodscategoryquoteconfig/addForm', 'GoodsCategoryQuoteConfigController@addForm');
        Route::get('/goodscategoryquoteconfig/editForm', 'GoodsCategoryQuoteConfigController@editForm');
        Route::post('/goodscategoryquoteconfig/save', 'GoodsCategoryQuoteConfigController@save');
        Route::get('/goodscategoryquoteconfig/delete', 'GoodsCategoryQuoteConfigController@delete');

        Route::get('/unit/list', 'UnitController@getList');//单位列表
        Route::get('/unit/addForm', 'UnitController@addForm');//添加单位
        Route::get('/unit/editForm', 'UnitController@editForm');//修改单位
        Route::post('/unit/save', 'UnitController@save');//保存
        Route::post('/unit/sort', 'UnitController@sort');//排序
        Route::get('/unit/delete', 'UnitController@delete');//删除

        Route::get('/shop/list', 'ShopController@getList');//入驻店铺列表
        Route::get('/shop/addForm', 'ShopController@addForm');//添加店铺
        Route::get('/shop/editForm', 'ShopController@editForm');//修改店铺
        Route::post('/shop/save', 'ShopController@save');//保存
        Route::post('/shop/change/isFreeze', 'ShopController@isFreeze');//修改状态
        Route::post('/shop/change/isValidated', 'ShopController@isValidated');//修改状态
        Route::post('/shop/change/modifyAjax', 'ShopController@modifyAjax');//修改状态
        Route::get('/shop/detail', 'ShopController@detail');//详情
        Route::get('/shop/logList', 'ShopController@logList');//日志信息
        Route::post('/shop/getUsers', 'ShopController@getUsers');//查询用户
        Route::post('/shop/GsSearch', 'ShopController@GsSearch');//企查查验证企业名称是否存在
        Route::post('/shop/ajax_list', 'ShopController@getShopList');//ajax获取商家列表

        Route::get('/shop/store', 'ShopStoreController@getList');//店铺列表
        Route::post('/shop/store/list', 'ShopStoreController@storeList');//ajax获取列表
        Route::get('/shop/store/add', 'ShopStoreController@add');// 添加
        Route::get('/shop/store/edit', 'ShopStoreController@edit');// 修改
        Route::post('/shop/store/save', 'ShopStoreController@save');// 保存
        Route::post('/shop/store/delete', 'ShopStoreController@delete');// 删除

        Route::get('/shopuser/list', 'ShopUserController@getList');//店铺职员列表
        Route::get('/shopuser/addForm', 'ShopUserController@addForm');//添加职员
        Route::get('/shopuser/editForm', 'ShopUserController@editForm');//修改职员
        Route::post('/shopuser/save', 'ShopUserController@save');//保存
        Route::get('/shopuser/delete', 'ShopUserController@delete');//删除


        /*Route::get('/shopgoods/list', 'ShopGoodsController@getList');//店铺商品列表
        Route::get('/shopgoods/addForm', 'ShopGoodsController@addForm');//店铺商品添加
        Route::get('/shopgoods/editForm', 'ShopGoodsController@editForm');//店铺商品编辑
        Route::post('/shopgoods/save', 'ShopGoodsController@save');//保存
        Route::post('/shopgoods/getGoods', 'ShopGoodsController@getGoods');//ajax获取商品
        Route::get('/shopgoods/delete', 'ShopGoodsController@delete');//删除*/

        Route::get('/shopgoodsquote/list', 'ShopGoodsQuoteController@getList');//店铺商品报价列表
        Route::get('/shopgoodsquote/addForm', 'ShopGoodsQuoteController@addForm');//添加
        Route::get('/shopgoodsquote/editForm', 'ShopGoodsQuoteController@editForm');//编辑
        Route::post('/shopgoodsquote/save', 'ShopGoodsQuoteController@save');//保存
        Route::get('/shopgoodsquote/delete', 'ShopGoodsQuoteController@delete');//删除
        Route::post('/shopgoodsquote/getGoods', 'ShopGoodsQuoteController@getGoods');//ajax获取商品
        Route::get('/shopgoodsquote/reRelease', 'ShopGoodsQuoteController@reRelease');//更新发布
        Route::get('/shopgoodsquote/roof', 'ShopGoodsQuoteController@roof');//更新发布

        Route::any('/orderinfo/list', 'OrderInfoController@getList');//订单列表
        Route::get('/orderinfo/detail', 'OrderInfoController@detail');//订单详情
        Route::post('/orderinfo/save', 'OrderInfoController@save');//保存
        Route::post('/orderinfo/modify', 'OrderInfoController@modify');//修改
        Route::post('/orderinfo/modifyAutoDeliveryTime', 'OrderInfoController@modifyAutoDeliveryTime');//修改自动收货时间
        Route::post('/orderinfo/modifyPayStatus', 'OrderInfoController@modifyPayStatus');//修改支付状态
        Route::post('/orderinfo/modifyOrderStatus', 'OrderInfoController@modifyOrderStatus');//修改订单状态
        Route::get('/orderinfo/modifyConsignee', 'OrderInfoController@modifyConsignee');//编辑收货人信息
        Route::post('/orderinfo/saveConsignee', 'OrderInfoController@saveConsignee');//保存发货人信息
        Route::get('/orderinfo/modifyOrderGoods', 'OrderInfoController@modifyOrderGoods');//编辑商品信息
        Route::post('/orderinfo/saveOrderGoods', 'OrderInfoController@saveOrderGoods');//保存商品修改信息
        Route::get('/orderinfo/modifyFee', 'OrderInfoController@modifyFee');//编辑费用信息
        Route::post('/orderinfo/saveFee', 'OrderInfoController@saveFee');//保存费用修改信息
        Route::post('/orderinfo/getOrderLog', 'OrderInfoController@getOrderLog');//操作日志分页
        Route::get('/orderinfo/delivery', 'OrderInfoController@delivery');//发货单
        Route::post('/orderinfo/saveDelivery', 'OrderInfoController@saveDelivery');//保存发货单
        Route::post('/orderinfo/GoodsForm', 'OrderInfoController@GoodsForm');//发货单商品table(渲染表格数据)
        Route::get('/orderinfo/delivery/list', 'OrderInfoController@deliveryList');//发货单列表
        Route::get('/orderinfo/delivery/detail', 'OrderInfoController@deliveryDetail');//发货单详情
        Route::post('/orderinfo/delivery/modifyShippingBillno', 'OrderInfoController@modifyShippingBillno');//修改快递单号
        Route::post('/orderinfo/delivery/modifyDeliveryStatus', 'OrderInfoController@modifyDeliveryStatus');//修改发货状态
        Route::post('/orderinfo/editOrderContract', 'OrderInfoController@editOrderContract');//订单列表
        Route::get('/orderinfo/applyInvoice', 'OrderInfoController@applyInvoice');//订单列表
        Route::post('/orderinfo/saveApplyInvoice', 'OrderInfoController@saveApplyInvoice');//订单列表

        Route::any('/logistics/list', 'LogisticsController@getList');//站内物流信息列表
        Route::get('/logistics/add', 'LogisticsController@addForm');//添加
        Route::get('/logistics/edit', 'LogisticsController@editForm');//编辑
        Route::post('/logistics/save', 'LogisticsController@save');//保存
        Route::get('/logistics/delete', 'LogisticsController@delete');//删除
        Route::post('/logistics/validateShippingNo', 'LogisticsController@validateShippingNo');//验证快递单号是否存在

        Route::any('/seckill/list', 'SeckillController@getList');//秒杀活动列表
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

        Route::any('/promote/list', 'PromoteController@getList');//促销活动申请列表
        Route::get('/promote/detail', 'PromoteController@detail');//促销活动申请详情
        Route::get('/promote/addForm', 'PromoteController@addForm');//添加促销活动
        Route::get('/promote/editForm', 'PromoteController@editForm');//编辑促销活动
        Route::post('/promote/save', 'PromoteController@save');//保存促销活动
        Route::post('/promote/verify', 'PromoteController@verify');//审核促销活动
        Route::get('/promote/delete', 'PromoteController@delete');//删除促销活动
        Route::post('/promote/getGoodsCat', 'PromoteController@getGoodsCat');//ajax获取商品分类
        Route::post('/promote/getGood', 'PromoteController@getGood');//ajax获取商品
        Route::post('/promote/getShopList', 'PromoteController@getShopList');//ajax获取商家

        Route::get('/activity/wholesale', 'ActivityWholesaleController@index');//集采火拼申请列表
        Route::get('/activity/wholesale/add', 'ActivityWholesaleController@add');//添加
        Route::post('/activity/wholesale/save', 'ActivityWholesaleController@save');//保存
        Route::get('/activity/wholesale/delete', 'ActivityWholesaleController@delete');//删除
        Route::get('/activity/wholesale/detail', 'ActivityWholesaleController@detail');//详情
        Route::post('/activity/wholesale/modifyStatus', 'ActivityWholesaleController@modifyStatus');//审核

        Route::get('/activity/consign', 'ActivityConsignController@index');//清仓特卖申请列表
        Route::get('/activity/consign/add', 'ActivityConsignController@add');//添加
        Route::get('/activity/consign/edit', 'ActivityConsignController@edit');//编辑
        Route::post('/activity/consign/save', 'ActivityConsignController@save');//保存
        Route::post('/activity/consign/delete', 'ActivityConsignController@delete');//删除
        Route::get('/activity/consign/detail', 'ActivityConsignController@detail');//详情
        Route::post('/activity/consign/modifyStatus', 'ActivityConsignController@modifyStatus');//审核

        Route::any('/demand/list', 'DemandController@getList');//需求提交列表
        Route::get('/demand/detail', 'DemandController@detail');//查看审核需求
        Route::post('/demand/save', 'DemandController@save');//保存

        Route::get('/demand/userSale', 'DemandController@userSale');//会员卖货需求
        Route::get('/demand/setRead', 'DemandController@setRead');//会员卖货需求 设为已读

        Route::any('/demand/userWholeSingle', 'DemandController@userWholeSingle');//整单采购需求
        Route::get('/demand/setSingleRead', 'DemandController@setSingleRead');//整单采购需求 设为已读

        Route::get('/ad/position/list', 'AdPositionController@getList');//广告位置列表
        Route::get('/ad/position/addForm', 'AdPositionController@addForm');//广告位置添加
        Route::get('/ad/position/editForm', 'AdPositionController@editForm');//广告位置编辑
        Route::post('/ad/position/save', 'AdPositionController@save');//广告位置保存
        Route::get('/ad/position/delete', 'AdPositionController@delete');//广告位置删除

        Route::get('/ad/list', 'AdController@getList');//广告图片列表
        Route::get('/ad/addForm', 'AdController@addForm');//广告图片添加
        Route::get('/ad/editForm', 'AdController@editForm');//广告图片编辑
        Route::post('/ad/save', 'AdController@save');//广告图片保存
        Route::post('/ad/change/enabled', 'AdController@enabled');//广告图片状态修改
        Route::get('/ad/delete', 'AdController@delete');//广告图片删除

        Route::any('/invoice/list', 'InvoiceController@getList');//发票申请列表
        Route::get('/invoice/goods/list', 'InvoiceController@goodsList');//开票商品
        Route::get('/invoice/detail', 'InvoiceController@detail');//查看发票详情
        Route::post('/invoice/save', 'InvoiceController@save');//保存

        Route::get('/hotsearch', 'HotSearchController@index');//搜索列表
        Route::post('/hotsearch/setShow', 'HotSearchController@setShow');//设置显示状态
        Route::get('/hotsearch/delete', 'HotSearchController@delete');//设置显示状态

        Route::get('/shipping', 'ShippingController@index');// 物流公司列表
        Route::get('/shipping/add', 'ShippingController@add');// 添加
        Route::get('/shipping/edit', 'ShippingController@edit');// 编辑
        Route::post('/shipping/save', 'ShippingController@save');// 保存
        Route::post('/shipping/setStatus', 'ShippingController@setStatus');// 保存

        Route::get('/salesman/list', 'SalesmanController@index');// 业务员
        Route::get('/salesman/add', 'SalesmanController@edit');// 添加
        Route::get('/salesman/edit', 'SalesmanController@edit');// 编辑
        Route::post('/salesman/save', 'SalesmanController@save');// 保存
        Route::post('/salesman/getSalemanByShopId', 'SalesmanController@getSalemanByShopId');// ajax根据shop_id获取数据

        Route::any('/inquire/index', 'InquireController@index');//求购列表
        Route::get('/inquire/add', 'InquireController@add');// 添加
        Route::get('/inquire/edit', 'InquireController@edit');// 编辑
        Route::post('/inquire/save', 'InquireController@save');// 保存
        Route::get('/inquire/delete', 'InquireController@delete');// 删除
        Route::post('/inquire/modifyShowStatus', 'InquireController@modifyShowStatus');// ajax修改是否显示

        Route::any('/inquireQuote/index', 'InquireQuoteController@index');// 求购报价列表
        Route::get('/inquireQuote/delete', 'InquireQuoteController@delete');// 求购报价删除

        Route::get('/recruit/list','RecruitController@index');//招聘信息列表
        Route::get('/recruit/add','RecruitController@add');//添加
        Route::get('/recruit/edit','RecruitController@edit');//编辑
        Route::post('/recruit/save','RecruitController@save');//保存
        Route::get('/recruit/delete','RecruitController@delete');//删除
        Route::post('/recruit/change/isShow','RecruitController@isShow');//是否显示

        Route::get('/resume/list','RecruitController@resumeList');//招聘简历列表
        Route::get('/resume/delete','RecruitController@deleteResume');//删除

    });
});
Route::get('/payment/orderPay','PayController@orderPay');//去付款


Route::get('/logistics/detail','KuaidiController@searchWaybill');//查运单
Route::get('/logistics/instation','KuaidiController@searchInstation');//查站内运单

Route::group(['namespace'=>'Web','middleware' => 'web.closed'],function() {
    Route::get('/', 'IndexController@index'); //首页
    Route::post('/user/checkNameExists', 'UserController@checkNameExists');//验证用户名是否存在
    Route::post('/user/checkCanRegister', 'UserController@checkCompanyNameCanAdd');//验证公司是否存在
    Route::get('/register/sendSms', 'UserController@sendRegisterSms');//发送注册短信

    Route::get('/userRegister', 'UserController@userRegister')->name('register');//个人注册
    Route::post('/userRegister', 'UserController@userRegister');
    Route::get('/firmRegister', 'UserController@firmRegister')->name('firmRegister');//企业注册
    Route::post('/firmRegister', 'UserController@firmRegister');

    Route::get('/login', 'LoginController@index')->name('login');//登陆
    Route::post('/login', 'LoginController@login');

    Route::get('/login/qqLogin', 'LoginController@qqLogin');//点击qq登录
    Route::get('/login/qqCallBack', 'LoginController@qqCallBack');//点击微信登录
    Route::get('/login/wxLogin', 'LoginController@wxLogin');//点击微信登录
    Route::get('/login/wxCallBack', 'LoginController@wxCallBack');//点击微信登录
    Route::post('/login/createThird', 'LoginController@createThird');//有账号输入密码登录
    Route::post('/login/createNewUser', 'LoginController@createNewUser');//没有账号先注册在登录

    Route::get('/findPwd','UserController@userFindPwd');//忘记密码
    Route::post('/findPwd','UserController@userFindPwd');
    Route::get('/findPwd/sendSms','UserController@sendFindPwdSms');//忘记密码获取验证码
    Route::get('/verifyReg','UserController@verifyReg');//注册等待审核

    Route::get('/sendMessLoginSms','UserController@sendMessLoginSms');//短信验证码登陆

    Route::get('/cart/num','UserController@getCartNum');//获取用户购物车数量
    Route::post('/demand/add','DemandController@addDemand');//获取用户需求信息

    Route::get('/article/{id}','IndexController@article');//资讯
    Route::get('/news.html', 'NewsController@index'); // 新闻中心
    Route::get('/news/{cat_id}/{page}.html', 'NewsController@index'); // 新闻中心
    Route::get('/detail/{id}.html', 'NewsController@detail'); // 详情
    Route::post('/side_bar', 'NewsController@side_bar'); // 详情侧边栏
    Route::get('/{id}/helpCenter.html','HelpCenterController@helpController');// 帮助中心首页
    Route::get('/helpCenter.html','HelpCenterController@helpController');// 帮助中心首页
    Route::post('/helpCenter/sidebar','HelpCenterController@getSidebar');// 帮助中心侧边栏

    /********************************报价信息*****************************/
    Route::any('/goodsList/{t?}', 'QuoteController@goodsList');//商品列表
    Route::get('/condition/goodsList', 'QuoteController@goodsListByCondition');//商品列表
    Route::get('/goodsDetail/{id}/{shop_id}', 'QuoteController@goodsDetail');//商品详情
    /********************************************************************/

    Route::get('/buyLimit', 'ActivityPromoteController@buyLimit');//限时抢购
    Route::get('/buyLimitDetails/{id?}', 'ActivityPromoteController@buyLimitDetails');//限时抢购详情

    Route::get('/consign', 'ActivityConsignController@index');//寄售
    Route::get('/consign/detail/{id?}', 'ActivityConsignController@detail');//寄售抢购详情

    Route::get('/goodsAttribute', 'GoodsController@goodsAttribute');//物性表
    Route::post('/goodsAttribute', 'GoodsController@goodsAttribute');//物性表
    Route::get('/goodsAttributeDetails/{id?}', 'GoodsController@goodsAttributeDetails');//物性表详情

    Route::get('/wholesale', 'ActivityWholesaleController@index');//集采火拼
    Route::get('/wholesale/detail/{id?}', 'ActivityWholesaleController@detail');//集采火拼详情

    Route::get('/price/ajaxcharts', 'GoodsController@productTrend');//商品走势图价格

    Route::get('/wholeSingle', 'ActivityWholesaleController@wholeSingle');//整单采购 // 未登录可以访问
    Route::get('/wantBuy', 'WantBuyController@wantBuyList');//求购列表 // 未登录可以访问
    Route::get('/condition/toBuyList', 'WantBuyController@wantBuyListBycondition');//求购列表条件查询

    Route::get('/recruit/page', 'RecruitController@recruitPage');//招聘列表
    Route::get('/recruit/list/{id}', 'RecruitController@recruitList');//招聘详情
    Route::post('/resumeSave', 'RecruitController@resumeSave');//简历保存
    Route::post('/recruit/recruitByCondition', 'RecruitController@recruitByCondition');//招聘列表条件查询


    Route::get('/goods/special/detail/{id}', 'GoodsController@specialDetail');//招聘列表条件查询


    Route::group(['middleware' => 'web.auth'], function () {
        Route::get('/logout', 'UserController@logout');//登出

//        Route::get('/logistics/detail','KuaidiController@searchWaybill');//查运单

        Route::post('/changeDeputy','IndexController@changeDeputy');//选择公司

        Route::post('/buy/asingle', 'WantBuyController@asingle');//求购列表 我要供货弹层
        Route::post('/buy/savebuy', 'WantBuyController@savebuy'); //求购列表  保存报价

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
        Route::post('/checkRealNameBool', 'UserController@checkRealNameBool');//验证用户是否已实名
        /*******************************用户信息*************************************/
        Route::get('/account/userInfo', 'UserController@userInfo');//用户信息编辑
        Route::post('/account/saveUser', 'UserController@saveUser');//保存用户信息
        Route::get('/account/viewPoints', 'UserController@viewPoints');//查看积分
        Route::get('/account/userRealInfo', 'UserController@userRealInfo');//实名认证
        Route::post('/account/saveUserReal', 'UserController@saveUserReal');//保存实名
        Route::any('/account/editPayPassword', 'UserController@editPayPassword');//修改支付密码
        Route::any('/account/editPayPassword/sendSms', 'UserController@sendPayPwdSms');//发送支付密码短信
        Route::post('/isReal', 'UserController@isReal');//根据用户id检测用户是否实名
        Route::get('/account/accountLogout', 'UserController@accountLogout');//注销账号
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

        Route::get('/cart','CartController@cart');//购物车列表
        Route::post('/cart','CartController@cart');//加入购物车
        Route::post('/checkListen','CartController@checkListen');//购物车多选框
        Route::post('/toBalance','CartController@toBalance');//购物车去结算
        Route::post('/clearCart','CartController@clearCart');//清空购物车
        Route::post('/editCartNum','CartController@editCartNum');//修改购物车数量
        Route::post('/delCart','CartController@delCart');//删除购物车数量
        Route::post('/addCartGoodsNum','CartController@addCartGoodsNum');//增加购物车数量
        Route::post('/checkListenCartInput','CartController@checkListenCartInput');//购物车判断数量
        Route::post('/reduceGoodsNum','CartController@reduceGoodsNum');//减少购物车数量
        Route::post('/reduceCartGoodsNum','CartController@reduceCartGoodsNum');//减少购物车数量
        Route::post('/editOrderAddress','CartController@editOrderAddress');//选择订单地址

        Route::post('/buyLimitToBalance', 'ActivityPromoteController@buyLimitToBalance');//限时抢购 立即下单
        Route::post('/buyLimitMaxLimit','ActivityPromoteController@buyLimitMaxLimit'); //抢购最大限购数量

        Route::post('/wholesale/toBalance', 'ActivityWholesaleController@toBalance');//集采火拼 立即下单
        Route::post('/buyLimitMaxLimit','ActivityWholesaleController@buyLimitMaxLimit'); //集采火拼最大限购数量

        Route::post('/consign/toBalance', 'ActivityConsignController@toBalance');//清仓特卖 立即下单

        Route::post('/wholeSingle/DemandSubmission', 'ActivityWholesaleController@DemandSubmission');//整单采购 需求提交

        Route::group(['middleware'=>'web.firmUserAuth'],function(){
            Route::get('/confirmOrder/{id?}','OrderController@confirmOrder');//确认订单页面
            Route::post('/createOrder','OrderController@createOrder');//提交订单
        });

        Route::get('/toPay','FlowController@toPay');//去付款
        Route::get('/toPayDeposit','FlowController@toPayDeposit');//去付订金
        Route::post('/payVoucherSave','FlowController@payVoucherSave');//付款凭证提交
        Route::get('/orderSubmission.html','OrderController@orderSubmission');// 订单提交成功页面

        Route::get('/order/list','OrderController@orderList');//我的订单
        Route::post('/order/list','OrderController@orderList');//我的订单
        Route::post('/order/status','OrderController@orderStatusCount');//我的订单
        Route::post('/orderDel','OrderController@orderDel');//订单删除
        Route::get('/invoice/myInvoice',  'InvoiceController@myInvoice'); // 我的开票
        Route::post('/invoice/myInvoice',  'InvoiceController@myInvoice'); // 我的开票列表接口
        Route::post('/invoice/getStatusCount',  'InvoiceController@getStatusCount'); // 各状态数量
        Route::get('/invoice',  'InvoiceController@invoiceList'); // 待开票列表
        Route::post('/invoice/confirm',  'InvoiceController@confirm'); // 开票确认页面
        Route::post('/invoice/apply',  'InvoiceController@applyInvoice'); // 开票确认保存
        Route::post('/invoice/editInvoiceAddress',  'InvoiceController@editInvoiceAddress'); // 选择收票地址
        Route::post('/invoice/editInvoiceType',  'InvoiceController@editInvoiceType'); // 选择开票类型
        Route::get('/invoice/waitFor.html',  'InvoiceController@waitFor'); // 选择开票类型
        Route::get('/invoiceDetail/{invoice_id}',  'InvoiceController@invoiceDetail'); // 选择开票类型
        Route::post('/checkOrderContract',  'OrderContractController@checkOrderContract');

        Route::post('/egis','OrderController@egis');//订单审核通过
        Route::post('/orderCancel','OrderController@orderCancel');//订单取消
        Route::get('/orderDetails/{id}','OrderController@orderDetails');//订单详情
        Route::get('/pay','OrderController@pay');//支付界面
        Route::get('/waitConfirm','OrderController@waitConfirm');//等待审核界面
        Route::post('/orderConfirmTake','OrderController@orderConfirmTake');//确认收货

        Route::get('/collectGoodsList','UserController@userCollectGoodsList');//商品收藏列表
        Route::post('/collectGoodsList','UserController@userCollectGoodsList');//商品收藏列表
        Route::post('/addCollectGoods','UserController@addCollectGoods');//收藏商品
        Route::post('/delCollectGoods','UserController@delCollectGoods');//删除收藏商品

        Route::get('/sale','UserController@sale');// 我要卖货
        Route::post('/sale','UserController@sale');// 我要卖货
    });
});


// 商户
Route::group(['namespace' => 'Seller','prefix' => 'seller'], function () {
    Route::get('/login.html', 'LoginController@login')->name('seller_login');
    Route::post('/login', 'LoginController@login');
    Route::get('/register.html', 'LoginController@register');
    Route::post('/register', 'LoginController@register');
    Route::get('/waitForExamine.html', 'LoginController@waitForExamine');
    Route::post('/getSmsCode', 'LoginController@getSmsCode');
    Route::post('/SmsCodeLogin', 'LoginController@SmsCodeLogin');
    Route::post('/checkShopName', 'LoginController@checkShopName');
    Route::get('/checkCompany', 'LoginController@checkCompany');
    Route::post('checkSession', 'LoginController@checkSession');
    Route::group(['middleware' => 'seller.auth'], function () {

        Route::get('/', 'IndexController@index');
        Route::get('/logout', 'LoginController@logout');
        Route::get('/detail', 'IndexController@detail');
        Route::post('/updateCash', 'IndexController@updateCash');
        Route::post('/chars', 'IndexController@chars');

        Route::get('/store', 'ShopStoreController@getList');//店铺列表
        Route::post('/store/list', 'ShopStoreController@storeList');//ajax获取列表
        Route::get('/store/add', 'ShopStoreController@add');// 添加
        Route::get('/store/edit', 'ShopStoreController@edit');// 修改
        Route::post('/store/save', 'ShopStoreController@save');// 保存
        Route::post('/store/delete', 'ShopStoreController@delete');// 删除

        /************************职员维护********************************/
//        Route::get('/shopUser', 'ShopUserController@getList');// 商户职员管理
//        Route::get('/shopUser/add', 'ShopUserController@add');// 添加
//        Route::get('/shopUser/edit', 'ShopUserController@edit');// 修改
//        Route::post('/shopUser/save', 'ShopUserController@save');// 保存
//        Route::post('/shopUser/delete', 'ShopUserController@delete');// 删除

        Route::get('/goods/list', 'ShopGoodsController@getList');// 商户商品操作
//        Route::get('/goods/add', 'ShopGoodsController@add');
//        Route::get('/goods/edit', 'ShopGoodsController@edit');
//        Route::post('/goods/save', 'ShopGoodsController@save');
//        Route::post('/goods/delete', 'ShopGoodsController@delete');
        Route::get('/goods/GoodsForm', 'ShopGoodsController@GoodsForm');//

        /************************业务员********************************/
        Route::get('/salesman/list', 'ShopSalesmanController@listView');// 业务员
        Route::get('/salesman/add', 'ShopSalesmanController@edit');// 添加
        Route::get('/salesman/edit', 'ShopSalesmanController@edit');// 编辑
        Route::post('/salesman/save', 'ShopSalesmanController@save');// 保存

        Route::any('/goods/getGoodsCat', 'ShopGoodsController@getGoodsCat');// 获取商品分类
        Route::post('/goods/getGood', 'ShopGoodsController@getGood');// 获取商品

        Route::get('/quote/list', 'ShopGoodsQuoteController@getList');// 商户商品报价
        Route::any('/quote/getAddressTree', 'ShopGoodsQuoteController@getAddressTree');// 商户商品报价地址接口
        Route::get('/quote/add', 'ShopGoodsQuoteController@add');//  添加
        Route::get('/quote/edit', 'ShopGoodsQuoteController@edit');// 编辑
        Route::post('/quote/save', 'ShopGoodsQuoteController@save');// 保存
        Route::get('/quote/delete', 'ShopGoodsQuoteController@delete');// 删除
        Route::get('/quote/reRelease', 'ShopGoodsQuoteController@reRelease');//更新报价
        Route::get('/quote/roof', 'ShopGoodsQuoteController@roof');//置顶

        Route::get('/order/list', 'ShopOrderController@getList');// 商铺订单
        Route::get('/order/detail', 'ShopOrderController@detail');  // 订单详情
        Route::post('/order/updateOrderStatus', 'ShopOrderController@updateOrderStatus'); // 更新订单状态
        Route::post('/order/updatePayType', 'ShopOrderController@updatePayType'); // 更改付款方式
        Route::post('/order/getStatusCount', 'ShopOrderController@getStatusCount'); // 订单各状态数量
        Route::post('/order/toBuyerModify', 'ShopOrderController@toBuyerModify'); // 修改商家留言
        Route::post('/order/updateDeliveryPeriod', 'ShopOrderController@updateDeliveryPeriod'); // 修改商家留言
        Route::post('/order/editContract', 'ShopOrderController@editContract'); // 商家重新上传合同
        Route::get('/order/modifyGoodsInfo', 'ShopOrderController@modifyGoodsInfo'); // 修改订单中商品信息-页面
        Route::post('/order/modifyReceiveDate', 'ShopOrderController@modifyReceiveDate'); // 修改自动确认收获的天数
        Route::post('/order/saveGoods', 'ShopOrderController@saveGoods'); // 修改订单商品信息-动作
        Route::get('/order/modifyFree', 'ShopOrderController@modifyFree'); // 维护运费 & 折扣
        Route::post('/order/saveFree', 'ShopOrderController@saveFree'); // 维护运费 & 折扣- 保存
        Route::get('/order/delivery', 'ShopOrderController@delivery'); // 发货订单
        Route::post('/order/orderGoods', 'ShopOrderController@orderGoods');  //  为发货订单提供商品接口
        Route::post('/order/saveDelivery', 'ShopOrderController@saveDelivery'); //  生成发货单 订单商品数量在此处修改

        Route::get('/delivery/list', 'ShopDeliveryController@getList');// 发货订单
        Route::get('/delivery/detail', 'ShopDeliveryController@detail');// 发货订单详情
        Route::post('/delivery/updateStatus', 'ShopDeliveryController@updateStatus');  // 更改订单状态
        Route::post('/delivery/modifyShippingBillno', 'ShopDeliveryController@modifyShippingBillno'); // 修改订单号

        /************************秒杀********************************/
//        Route::get('/seckill/list', 'SeckillController@seckill');// 秒杀
//        Route::get('/seckill/add', 'SeckillController@addForm'); // 添加
//        Route::post('/seckill/save', 'SeckillController@save'); //  保存
//        Route::post('/seckill/delete', 'SeckillController@delete'); // 删除
//        Route::get('/seckill/goods_list', 'SeckillController@goods_list'); // 为添加秒杀商品提供页面
//        Route::get('/seckill/list_detail', 'SeckillController@list_detail'); // 列表详情
        /*****************************结尾**********************************/

        Route::get('/activity/promoter', 'ActivityController@promoter'); // 优惠活动
        Route::get('/activity/addPromoter', 'ActivityController@addPromoter'); // 添加 编辑 页面
        Route::post('/activity/savePromoter', 'ActivityController@savePromoter'); // 添加 编辑 保存
        Route::post('/activity/deletePromoter', 'ActivityController@delete'); // 删除

        Route::get('/activity/wholesale', 'ActivityWholesaleController@index'); // 集采火拼
        Route::get('/activity/wholesale/add', 'ActivityWholesaleController@add'); //集采火拼 添加 编辑 页面
        Route::post('/activity/wholesale/save', 'ActivityWholesaleController@save'); //集采火拼 添加 编辑 保存
        Route::post('/activity/wholesale/delete', 'ActivityWholesaleController@delete'); //集采火拼 删除

        Route::get('/activity/consign', 'ActivityConsignController@index'); // 委托寄售
        Route::get('/activity/consign/add', 'ActivityConsignController@add'); //委托寄售 添加 编辑 页面
        Route::get('/activity/consign/edit', 'ActivityConsignController@edit'); //委托寄售 添加 编辑 保存
        Route::post('/activity/consign/delete', 'ActivityConsignController@delete'); //委托寄售 删除

        Route::get('/invoice/list', 'InvoiceController@getList'); // 客户开票申请列表
        Route::get('/invoice/detail', 'InvoiceController@detail'); // 详情页
        Route::get('/invoice/choseExpress', 'InvoiceController@choseExpress'); // 审核选择快递
        Route::post('/invoice/verifyInvoice', 'InvoiceController@verifyInvoice'); // 审核 - 动作
        Route::post('/invoice/cancelInvoice', 'InvoiceController@cancelInvoice'); // 作废 - 动作
    });
});
//小程序接口
Route::group(['namespace' => 'Api','prefix' => 'api','middleware' => 'api.closed'],function() {
    Route::post('/getOpenId', 'LoginController@getOpenId');
    Route::post('/getNewOpenId', 'LoginController@getNewOpenId');

    Route::post('/register', 'LoginController@register');//注册
    Route::post('/send_register_sms', 'LoginController@sendRegisterSms');//注册新用户获取手机验证码
    Route::post('/login', 'LoginController@login');//登录
    Route::post('/updatePass', 'LoginController@updatePass');//忘记密码
    Route::post('/send_findpass_sms', 'LoginController@sendFindPwdSms');//忘记密码获取手机验证码
    Route::post('/bind_third', 'LoginController@bindThird');//有账号直接和微信绑定
    Route::post('/create_third', 'LoginController@createThird');//没有账号和微信先绑定再注册

    Route::post('/uploadImg', 'UploadController@uploadImg');//文件上传

    Route::get('/index/banner', 'IndexController@getBannerAd');//首页轮播
    Route::get('/index/tran_list', 'IndexController@getTransList');//首页成交动态
    Route::get('/index/promote_list', 'IndexController@getPromoteList');//首页优惠活动
    Route::get('/index/goods_quote_list', 'IndexController@getGoodsQuoteList');//首页自营报价
    Route::get('/index/good_list', 'IndexController@getGoodsList');//首页商品列表
    Route::get('/index/article_list', 'IndexController@getArticleList');//首页商品列表
    Route::get('/index/shop_list', 'IndexController@getShopsList');//首页供应商列表
    Route::post('/index/demand_add','IndexController@addDemand');//获取用户需求信息

    Route::get('/goods/cates', 'GoodsController@getCates');//获取分类信息
    Route::post('/goods/list', 'GoodsController@getList');//商品报价列表
    Route::post('/goods/detail', 'GoodsController@detail');//商品详情
    Route::post('/goods/search', 'GoodsController@search');//商品名称模糊查询报价信息
    Route::post('/goods/search_goodsname', 'GoodsController@searchGoodsname');//商品名称模糊查询报价信息
    Route::post('/goods/ajaxcharts','GoodsController@productTrend');//价格走势图
    Route::post('/article/hot_keywords', 'GoodsController@saveHotKeyWords');//保存关键词

    Route::get('/buyLimit/list', 'ActivityPromoteController@buyLimit');//限时抢购
    Route::post('/buyLimit/detail', 'ActivityPromoteController@buyLimitDetail');//限时抢购详情
    Route::post('/goods/goods_attribute', 'GoodsController@goodsAttribute');//物性表
    Route::post('/goods/goods_attribute_details', 'GoodsController@goodsAttributeDetails');//物性表详情
    Route::post('/goods/goods_supply_list', 'GoodsController@goodSupplyList');//物性表供应商

    Route::get('/wholesale/list', 'ActivityWholesaleController@index');//集采火拼
    Route::post('/wholesale/detail', 'ActivityWholesaleController@detail');//集采火拼详情
    Route::get('/wantBuy', 'WantBuyController@wantBuyList');//求购列表 // 未登录可以访问
    Route::post('/condition/toBuyList', 'WantBuyController@wantBuyListBycondition');//求购列表条件查询

    Route::get('/consign/list', 'ActivityConsignController@index');//寄售
    Route::post('/consign/detail', 'ActivityConsignController@detail');//寄售抢购详情

    Route::post('/article/list', 'ArticleController@getList');//获取咨询列表
    Route::post('/article/detail', 'ArticleController@getDetail');//获取咨询详情

    Route::group(['middleware' => 'api.auth'], function () {
        Route::post('/buy/asingle', 'WantBuyController@asingle');//求购列表 我要供货弹层
        Route::post('/buy/savebuy', 'WantBuyController@savebuy'); //求购列表  保存报价

        Route::post('/user/get_deputy_user', 'UserController@getDeputyUser'); //获取代理信息的接口

        Route::post('/user/detail', 'UserController@detail');//用户个人信息
        Route::post('/user/add_address','UserController@addAddress');//添加收货地址
        Route::post('/user/list_address','UserController@addressList');//收货地址列表
        Route::post('/user/detail_address','UserController@detailAddress');//收货地址详情
        Route::post('/user/delete_address','UserController@deleteAddress');//删除收货地址
        Route::post('/user/edit_default_address','UserController@updateDefaultAddress');//修改默认收货地址
        Route::post('/user/edit_nickname','UserController@editNickname');//修改昵称
        Route::post('/user/collection','UserController@myCollection');//个人收藏列表
        Route::post('/user/add_collection','UserController@addCollection');//修改昵称
        Route::post('/user/del_collection','UserController@delCollection');//删除收藏
        Route::post('/user/account_logout','UserController@accountLogout');//注销账号
        Route::post('/user/view_point','UserController@viewPoint');//查看积分
        Route::post('/user/view_real_info','UserController@viewRealInfo');//查看实名信息
        Route::post('/user/save_real_info','UserController@saveUserReal');//保存实名信息
        Route::post('/user/logout','LoginController@logout');//退出登录
        Route::post('/user/sale','UserController@sale');// 我要卖货
        Route::post('/user/untying','LoginController@untying');// 解绑微信
        Route::post('/user/needApproval','UserController@needApproval');//订单是否需要审核

        Route::post('/reset_pass', 'LoginController@resetPass');//重置密码

        Route::post('/logistics/detail','KuaidiController@searchWaybill');//查运单
        Route::post('/logistics/instation','KuaidiController@searchInstation');//查站内运单

        Route::post('/firmuser/list','FirmUserController@getList');//企业用户列表
        Route::post('/firmuser/detail','FirmUserController@getDetail');//企业用户详情
        Route::post('/firmuser/add','FirmUserController@addFirmUser');//添加企业用户
        Route::post('/firmuser/check','FirmUserController@checkRealNameBool');//添加企业用户前验证
        Route::post('/firmuser/delete', 'FirmUserController@delFirmUser');//企业会员删除

        Route::post('/cart/add', 'GoodsController@addCart');//加入购物车
        Route::post('/cart/list', 'GoodsController@getCartList');//加入购物车
        Route::post('/cart/delete', 'GoodsController@delCart');//删除购物车
        Route::post('/cart/clear_cart','GoodsController@clearCart');//清空购物车
        Route::post('/cart/add_goods_num','GoodsController@addCartGoodsNum');//购物车商品数量递增
        Route::post('/cart/reduce_goods_num','GoodsController@reduceCartGoodsNum');//购物车商品数量递减
        Route::post('/cart/edit_cart_num','GoodsController@editCartNum');//修改购物车数量
        Route::post('/cart/get_num','GoodsController@getCartNum');//获取用户购物车数量
        Route::post('/cart/check_listen_cart_input','GoodsController@checkListenCartInput');//购物车判断数量
        Route::post('/cart/to_balance','GoodsController@toBalance');//购物车去结算
        Route::post('/cart/edit_order_address','GoodsController@editOrderAddress');//修改收货地址

        Route::post('/buyLimit/to_balance', 'ActivityPromoteController@buyLimitToBalance');//限时抢购 立即下单
        Route::post('/wholesale/to_balance', 'ActivityWholesaleController@toBalance');//集采火拼 立即下单
        Route::post('/consign/to_balance', 'ActivityConsignController@toBalance');//清仓特卖 立即下单

        Route::post('/order/change_deputy','OrderController@changeDeputy');//切换代理
        Route::post('/order/user_firm_list','OrderController@getUserFirmList');//切换代理
        Route::post('/order/list','OrderController@orderList');//我的订单
        Route::post('/order/detail','OrderController@orderDetails');//订单详情
        Route::post('/order/order_status','OrderController@getOrderStatus');//获取订单的各个状态
        Route::post('/order/status','OrderController@orderStatusCount');//各个状态的订单数量
        Route::post('/order/del','OrderController@orderDel');//删除订单
        Route::post('/order/order_cancel','OrderController@orderCancel');//订单取消
        Route::post('/order/orderConfirmTake','OrderController@orderConfirmTake');//确认收货
        Route::post('/order/egis','OrderController@egis');//企业用户审核订单
        Route::post('/order/wait_confirm','OrderController@waitConfirm');//企业用户审核订单

        Route::post('/order/to_pay','FlowController@toPay');//去下单
        Route::post('/order/to_pay_deposit','FlowController@toPayDeposit');//去支付定金
        Route::post('/order/pay_voucher_save','FlowController@payVoucherSave');//上传凭证

        Route::post('/invoice/my_invoice',  'InvoiceController@myInvoice'); // 我的开票列表接口
        Route::post('/invoice/get_status_count',  'InvoiceController@getStatusCount'); // 各状态数量
        Route::post('/invoice/detail',  'InvoiceController@invoiceDetail'); // 开票详情
        Route::post('/invoice/list',  'InvoiceController@invoiceList'); // 待开票列表
        Route::post('/invoice/confirm',  'InvoiceController@confirm'); // 开票确认页面
        Route::post('/invoice/edit_invoice_address',  'InvoiceController@editInvoiceAddress'); // 选择收票地址
        Route::post('/invoice/edit_invoice_type',  'InvoiceController@editInvoiceType'); // 选择开票类型
        Route::post('/invoice/apply',  'InvoiceController@applyInvoice'); // 申请开票

        /*************************************企业库存*****************************************************/

        Route::post('/firmstock/stock_in','FirmStockController@firmStockIn');//入库记录列表
        Route::post('/firmstock/add_stock_in','FirmStockController@addFirmStock');//新增入库记录
        Route::post('/firmstock/search_goods_name','FirmStockController@searchGoodsName');//入库检索商品名称
        Route::post('/firmstock/search_partner_name','FirmStockController@searchPartnerName');//入库检索供应商名称

        Route::post('/firmstock/stock_out','FirmStockController@firmStockOut');   //出库记录列表
        Route::post('/firmstock/add_stock_out','FirmStockController@addFirmSotckOut');//新增出库记录
        Route::post('/firmstock/info','FirmStockController@stockInfo');//获取单条可出库数据
        Route::post('/firmstock/can_stock_out','FirmStockController@canStockOut');//可出库库存
        Route::post('/firmstock/cur_stock_save','FirmStockController@curStockSave');//出库更新保存

        Route::post('/stock/list','FirmStockController@stockList');//实时库存
        Route::post('/stock/flow','FirmStockController@stockFlowList');//企业库存流水

        /********************************************************************************************/

        Route::group(['middleware'=>'api.firmUserAuth'],function(){
            Route::post('/order/confirmOrder','OrderController@confirmOrder');//确认订单页面
            Route::post('/order/createOrder','OrderController@createOrder');//提交订单
        });

        Route::post('/toPay','OrderController@toPay');//去付款
        Route::post('/getConfigs','IndexController@getConfigs');//返回配置信息
        Route::post('/checkOrderContract',  'OrderContractController@checkOrderContract');
    });

});

Route::pattern('path','.+');
//Route::any('{path}', 'CommonController@route');









