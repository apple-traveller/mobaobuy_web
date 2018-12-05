<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\ShopService;
use App\Services\OrderInfoService;
use App\Services\ShopGoodsQuoteService;
use App\Services\ActivityPromoteService;
use App\Services\ActivityWholesaleService;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Services\UserRealService;
class IndexController extends Controller
{
    public function index(Request $request)
    {

        return $this->display('admin.index');
    }

    public function home()
    {
        //mysql版本
        $version = DB::select('SELECT VERSION() AS ver');
        //查询店铺总数量
        $shopCount = ShopService::getShopsCount(['is_freeze'=>0,'is_validated'=>1]);
        //查询今日订单总数量
        $orderCount = OrderInfoService::getOrdersCount();
        //查询今日销售总额
        $totalAccount = OrderInfoService::gettotalAccount();
        //查询今日报价总条数
        $quoteCount = ShopGoodsQuoteService::getQuotesCount();
        //查询会员信息
        $users = UserService::getUsersCount();
        //查询订单信息
        $orders = OrderInfoService::getOrderStatusCount(0,0);
        //当前服务器配置信息
        $config = [
            'server_name'=> $_SERVER["HTTP_HOST"],
            'server_version'=> php_uname('s').php_uname('r'),
            'php_version'=> PHP_VERSION,
            'server_ip'=> $_SERVER["SERVER_ADDR"],
            'server_port'=>$_SERVER['SERVER_PORT'],
            'server_language'=>$_SERVER['HTTP_ACCEPT_LANGUAGE'],
            'upload_max_filesize'=>get_cfg_var("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许",
            'time'=>date("Y-m-d H:i:s"),
            'web_server'=>$_SERVER["SERVER_SOFTWARE"],
            'mysql_version'=>$version[0]->ver,
        ];
        //dd($config);
        return $this->display('admin.home',[
            'shopCount'=>$shopCount,
            'orderCount'=>$orderCount,
            'totalAccount'=>$totalAccount,
            'quoteCount'=>$quoteCount,
            'users'=>$users,
            'orders'=>$orders,
            'config'=>$config,
        ]);
    }

    //ajax获取当月统计数据
    public function getMonthlyOrders()
    {
        //查询当年每月的订单数量
        $monthly_orders = OrderInfoService::getMonthlyOrders();
        return $this->result($monthly_orders,200,'');
    }
    //不能清除小程序用户信息 只用于数据即时显示 功能即时生效
    public function clear(){
//        Cache::flush();
    }

    //获取各促销活动未审核数量
    public function getActivityCount(Request $request)
    {
        $consign_count = ShopGoodsQuoteService::getConsignCount(['type'=>3,'consign_status'=>"0|2","is_delete"=>0]);
        $promote_count = ActivityPromoteService::getWaitReview(['review_status'=>"1|2",'is_delete'=>0]);
        $wholesale_count = ActivityWholesaleService::getWaitReview(['review_status'=>"1|2",'is_delete'=>0]);
        $order_status = OrderInfoService::getOrderCountByStatus();//各订单状态
        $shop_waitvalidate = ShopService::getShopsCount(['is_freeze'=>0,'is_validated'=>0]);//待审核商家
        $user_certification = UserRealService::getWaitCertificate(['review_status'=>"0|2"]);//待实名审核用户
        return $this->result(
            ['consign_count'=>$consign_count,
             'promote_count'=>$promote_count,
             'wholesale_count'=>$wholesale_count,
             'shop_waitvalidate'=>$shop_waitvalidate,
             'user_certification'=>$user_certification,
             'order_status'=>$order_status
            ],
            200,
            'success');
    }
}
