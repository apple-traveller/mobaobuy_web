<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class WebSessionAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        //var_dump($request->getRequestUri());
        if(empty(session('_web_info'))){
            //web统计
            $ip = $request->getClientIp();
            $json=file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.'116.226.54.5');
            $arr=json_decode($json);
            $province =  $arr->data->region;    //省份
            $city = $arr->data->city;    //城市
            $visitTimes = 1;
            $uri = $this->Get_Uri();
            $carbon = substr(Carbon::now(),0,10);
            $browser = $this->Get_Browser();
            $os = $this->Get_Os();
            $url = $this->Get_Url();
            $domain = $this->Get_Domain();

            $res = DB::select('select * from stats where ip_address = ? and access_time = ?',[$ip,$carbon]);
            if($res){
                $result = array_map('get_object_vars', $res);
                DB::update('update stats set visit_times = ? where id = ?',[$result[0]['visit_times']+1,$result[0]['id']]);
            }else{
                DB::insert('insert into stats
                (access_time,ip_address,visit_times,browser,system,area,referer_domain,referer_path,access_url) values
                (?,?,?,?,?,?,?,?,?)',[$carbon,$ip,$visitTimes,$browser,$os,$city,$domain,$url,$uri]);
            }
            return redirect('/webLogin');
        }

        if(session('_web_info')['log_info'] == '个人会员登陆'){

        }
        //判断用户初始化权限
//        $users = DB::select('select * from firm_users where user_id = ?',session('_web_info')['id']);
//        if($users['can_po']){
//            session()->put('can_po',$users['can_po']);
//        }
//        if($users['can_pay']){
//            session()->put('can_pay',$users['can_pay']);
//        }
//        if($users['can_confirm']){
//            session()->put('can_confirm',$users['can_confirm']);
//        }
//        if($users['can_stock_in']){
//            session()->put('can_stock_in',$users['can_stock_in']);
//        }
//        if($users['can_stock_out']){
//            session()->put('can_stock_out',$users['can_stock_out']);
//        }
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
