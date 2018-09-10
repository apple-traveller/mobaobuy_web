<?php

namespace App\Http\Controllers\Web;

use App\Services\SysConfigService;
use Illuminate\Http\Request;
use App\Services\Web\UserLoginService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class SysConfigController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public function __construct(){
        session()->put('theme','default');
    }

    //获取配置信息
    public function sysCacheSet(){
        //code individual_reg_closed 是否关闭个人注册
        //code individual_reg_check 个人注册是否需要审核
        //code individual_trade_closed 是否关闭个人交易
        //code firm_reg_closed 是否关闭企业注册
        //code firm_reg_check 企业注册是否审核
        //code firm_stock_closed 是否关闭企业库存管理
        $sysInfo = Cache::remember('sys',10,function(){
             return SysConfigService::sysCacheSet();
        });
         return $sysInfo;
    }

    //清除配置缓存
    public function sysCacheClean(){
        Cache::forget('sys');
        //Cache::flush();
    }
}
