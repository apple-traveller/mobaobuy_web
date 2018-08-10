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
            return redirect(url("/admin/login"));
        }


        return $next($request);
    }
}
