<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class ApiAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {

        if(empty(session('_api_user_id'))){
            return response()->json([
                'code' => '0',
                'msg' => '您已退出登录或登录超时！',
            ]);
        }

        return $next($request);
    }
}
