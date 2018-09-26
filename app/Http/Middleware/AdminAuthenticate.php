<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class AdminAuthenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        $user_id = session('_admin_user_id');

        if (empty($user_id)) {
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
