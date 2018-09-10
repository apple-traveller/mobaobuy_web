<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WebStats
{

    public function handle($request, Closure $next, $guard = null)
    {
        if(empty(session('_web_info'))){

        }
        return $next($request);
    }


}
