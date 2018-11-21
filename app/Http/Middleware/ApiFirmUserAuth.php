<?php
namespace App\Http\Middleware;
use App\Http\Controllers\Api\ApiController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class ApiFirmUserAuth extends Apicontroller
{

    public function handle(Request $request, Closure $next, $guard = null)
    {
        $deputy_user = $this->getDeputyUserInfo($request);
        if(($deputy_user['is_self']) == 0){
            if($deputy_user['can_po'] == 0){
               return $this->error('当前用户没有下单权限');
            }
        }

        return $next($request);
    }


}
