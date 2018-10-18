<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class WebAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {

        if(empty(session('_web_user_id'))){
            return redirect(route('login'));
        }

        //缓存用户的基本信息
        if(!session()->has('_web_user')){
            $user_info = UserService::getInfo(session('_web_user_id'));
            if(!$user_info['is_firm']){
                $user_info['firms'] = UserService::getUserFirms(session('_web_user_id'));
            }

            session()->put('_web_user', $user_info);

        }

        if(!session()->has('_curr_deputy_user')){
            $info = [
                'is_self' => 1,
                'is_firm' => session('_web_user')['is_firm'],
                'firm_id'=> session('_web_user_id'),
                'name' => session('_web_user')['nick_name']
            ];
            session()->put('_curr_deputy_user', $info);
        }

        //缓存模板信息
        if(!session()->has('web_theme')){
            session()->put('web_theme', getConfig('template','default'));
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
