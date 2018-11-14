<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiAuthenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $uuid = $request->input('Authenticate');
        if(!empty($uuid)){
            $user_id = Cache::get($uuid, 0);
            if($user_id){
                return $next($request);
            }
        }

        return response()->json([
            'code' => '-400',
            'msg' => '您已退出登录或登录超时！',
        ]);
    }
}
