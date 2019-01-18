<?php

namespace App\Http\Controllers;

use App\Services\ShopGoodsQuoteService;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    public function route($path){
        print_r('路由地址不存在！');
        abort(404);
        //return redirect()->action('Web\UserLoginController@firmRegister');
    }
    public function closeQuote(){
        //自动闭市 报价截止时间变成当天下午5:00 同时检查闭市的报价对应的购物车信息页清除
        $day = date('Y-m-d');
        $set_time = $day . ' ' .getConfig('close_quote');
        $start_time = $day . ' 00:00:00';
        $end_time = $day . ' 23:59:59';

        ShopGoodsQuoteService::closeQuote(
            [
                'add_time|>=' => $start_time,
                'add_time|<=' => $end_time,
                'is_delete' => 0,
                'type' => '1|2',
                'is_self_run' => 1

            ],
            [
                'expiry_time' => $set_time
            ]
        );
    }
}
