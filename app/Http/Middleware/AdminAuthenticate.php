<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class AdminAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        //var_dump($request->getRequestUri());
        $admininfo = $request->session()->get('_admin_info');

        if (empty($admininfo)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'code' => '400',
                    'msg' => '您已退出登录或登录超时！',
                ]);
            } else {
                return redirect(route('admin_login'));
            }
        }

        return $next($request);
    }
}
