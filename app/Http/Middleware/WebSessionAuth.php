<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;


class AdminAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        //var_dump($request->getRequestUri());

        if(empty(session('_web_info'))){
            return $this->success('页面已过期，请重新登陆！',route('login'));
        }
        return $next($request);
    }
}
