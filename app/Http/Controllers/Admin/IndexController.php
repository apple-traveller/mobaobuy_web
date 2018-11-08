<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\ShopService;
use App\Services\OrderInfoService;
use App\Services\ShopGoodsQuoteService;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
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
        $shopCount = ShopService::getShopsCount();
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
            'config'=>$config
        ]);
    }


    public function clear(){
        Cache::flush();
    }
}
