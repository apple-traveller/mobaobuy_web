<?php

namespace App\Http\Middleware;

use App\Services\ShopLoginService;
use App\Services\ShopService;
use Closure;

class SellerAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {

        if(empty(session('_seller_id'))){
            return redirect(route('seller_login'));
        }
        //缓存商户用户的基本信息
        if(!session()->has('_seller_user')){
            $user_info = ShopLoginService::getInfo(session('_seller_id')['user_id']);
            $shop_info = ShopService::getShopById($user_info['shop_id']);
            $data = [
                'user_id' => $user_info['id'],
                'user_name' => $user_info['user_name'],
                'is_super' => $user_info['is_super'],
                'shop_info' => $shop_info
            ];
            session()->put('_seller', $data);
        }
        return $next($request);
    }

    //获取当前路径
    function Get_Uri(){
        $uri =  'http://'.@$_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI'];
        return $uri;
    }

    //获取来源路径
    function Get_Url(){
        $url = @$_SERVER['HTTP_REFERER'];
        return $url;
    }

    //获取来源域名
    function Get_Domain(){
        $url = @$_SERVER["HTTP_REFERER"]; //获取完整的来路URL
        $str = str_replace("http://","",$url); //去掉http://
        $strdomain = explode("/",$str); // 以“/”分开成数组
        $domain = $strdomain[0]; //取第一个“/”以前的字符
        if(empty($domain)){
            return '';
        }
        return $domain;

    }
    ////获得访客浏览器类型
    function Get_Browser(){
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i',$br)) {
                $br = 'MSIE';
            }
            elseif (preg_match('/Firefox/i',$br)) {
                $br = 'Firefox';
            }
            elseif (preg_match('/Chrome/i',$br)) {
                $br = 'Chrome';
            }
            elseif (preg_match('/Safari/i',$br)) {
                $br = 'Safari';
            }
            elseif (preg_match('/Opera/i',$br)) {
                $br = 'Opera';
            }else {
                $br = 'Other';
            }
            return $br;
        }
        else{
            return "unknow";
        }
    }


    ////获取访客操作系统
    function Get_Os(){
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $OS = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/win/i',$OS)) {
                $OS = 'Windows';
            }
            elseif (preg_match('/mac/i',$OS)) {
                $OS = 'MAC';
            }
            elseif (preg_match('/linux/i',$OS)) {
                $OS = 'Linux';
            }
            elseif (preg_match('/unix/i',$OS)) {
                $OS = 'Unix';
            }
            elseif (preg_match('/bsd/i',$OS)) {
                $OS = 'BSD';
            }
            else {
                $OS = 'Other';
            }
            return $OS;
        }
        else{
            return "unknow";
        }
    }
}
