<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class ApiClosed
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $uuid = $request->input('token');
        if(!empty($uuid)){
            //缓存用户的基本信息
            $user_id = Cache::get($uuid, 0);
            if(!Cache::get('_api_user_'.$user_id)){
                $user_info = $user_info = UserService::getInfo($user_id);
                if(!$user_info['is_firm']){
                    $user_info['firms'] = UserService::getUserFirms($user_id);
                }
                Cache::put("_api_user_".$user_id, $user_info, 60*24*1);
            }

            if(!Cache::get('_api_deputy_user_'.$user_id)){
                $info = [
                    'is_self' => 1,
                    'is_firm' => Cache::get('_api_user_'.$user_id)['is_firm'],
                    'firm_id'=> $user_id,
                    'name' => Cache::get('_api_user_'.$user_id)['nick_name'],
                ];
                Cache::put("_api_deputy_user_".$user_id, $info, 60*24*1);
            }

        }

        return $next($request);
    }
}
