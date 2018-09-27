<?php

namespace App\Http\Middleware;

use App\Services\AdminService;
use Closure;
use Illuminate\Support\Facades\View;

class AdminAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {

        if(empty(session('_admin_user_id'))){
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'code' => '0',
                    'msg' => '您已退出登录或登录超时！',
                ]);
            } else {
                return redirect(route('admin_login'));
            }
        }

        //缓存用户的基本信息
        if(!session()->has('_admin_user_info')){
            $user_info = AdminService::getInfo(session('_admin_user_id'));
            session()->put('_admin_user_info', $user_info);
        }

        //缓存模板信息
        if(!session()->has('admin_theme')){
            session()->put('admin_theme', getConfig('admin_template','default'));
        }

        return $next($request);
    }
}
