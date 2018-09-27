<?php

namespace App\Http\Middleware;

use App\Services\ShopLoginService;
use Closure;

class SellerAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {

        if(empty(session('_seller_user_id'))){
            return redirect(route('seller_login'));
        }

        //缓存商户用户的基本信息
        if(!session()->has('_seller_user')){
            $user_info = ShopLoginService::getInfo(session('_seller_user_id'));
            session()->put('_seller_user', $user_info);
        }

        //缓存模板信息
        if(!session()->has('seller_theme')){
            session()->put('seller_theme', getConfig('seller_template','default'));
        }

        return $next($request);
    }
}
