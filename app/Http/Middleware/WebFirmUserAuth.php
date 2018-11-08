<?php
namespace App\Http\Middleware;
use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class WebFirmUserAuth extends controller
{

    public function handle($request, Closure $next, $guard = null)
    {
        if((session('_curr_deputy_user')['is_self']) == 0){
            if(session('_curr_deputy_user')['can_po'] == 0){
               return $this->error('当前用户没有下单权限');
            }
        }
//        "can_po" => 1
//  "can_pay" => 0
//  "can_confirm" => 0
//  "can_stock_in" => 0
//  "can_stock_out" => 0
//  "can_approval" => 1
//  "can_stock_view" => 0
//  "can_invoice" => 0
        return $next($request);
    }


}
