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
        return $next($request);
    }
}
