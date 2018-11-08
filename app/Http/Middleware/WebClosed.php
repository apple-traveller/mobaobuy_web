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

class WebClosed
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(getConfig('shop_closed') == '1'){
            print_r(getConfig('close_comment'));
            die();
        }

        if(!empty(session('_web_user_id'))){
            //缓存用户的基本信息
            if(!session()->has('_web_user')){
                $user_info = UserService::getInfo(session('_web_user_id'));
                if(!$user_info['is_firm']){
                    $user_info['firms'] = UserService::getUserFirms(session('_web_user_id'));
                }
//                dd($user_info);

                session()->put('_web_user', $user_info);
            }

                if(!session()->has('_curr_deputy_user')){
                $info = [
                    'is_self' => 1,
                    'is_firm' => session('_web_user')['is_firm'],
                    'firm_id'=> session('_web_user_id'),
                    'name' => session('_web_user')['nick_name'],
                ];
                session()->put('_curr_deputy_user', $info);
            }

            //缓存模板信息
            if(!session()->has('web_theme')){
                session()->put('web_theme', getConfig('template','default'));
            }
        }

        return $next($request);
    }
}
