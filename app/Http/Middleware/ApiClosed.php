<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\ApiController;
use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ApiClosed extends ApiController
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $uuid = $request->input('token');
        $user_id = Cache::get($uuid, 0);
        if(!empty($user_id)){
            //缓存用户的基本信息
            $user_info = UserService::getInfo($user_id);
            $deputy_user = Cache::get('_api_deputy_user_'.$user_id);
            //dd($deputy_user);
            //用户不切换生效权限,is_logout存的是企业的id
            if($user_info['is_logout']){
                if($user_info['is_firm'] == 0 && $deputy_user['is_self'] == 0){
                    //获取用户所代表的公司
                    //firms是firmuser表信息 加企业名称和addressid
                    $firms = UserService::getUserFirms($user_id);
                    foreach ($firms as $firm){
                        if($user_info['is_logout'] == $firm['firm_id']){
                            //修改代表信息
                            $firm['is_self'] = 0;
                            $firm['is_firm'] = 1;
                            $firm['name'] = $firm['firm_name'];
                            Cache::put('_api_deputy_user_'.$user_id,$firm,60*24*1);
                        }
                    }
                }
            }

            if(!$user_info['is_firm']){
                $user_info['firms'] = UserService::getUserFirms($user_id);
            }

            if(Cache::has('_api_deputy_user_'.$user_id)){
                $info = [
                    'is_self' => 1,
                    'is_firm' => Cache::get('_api_user_'.$user_id)['is_firm'],
                    'firm_id'=> $user_id,
                    'name' => Cache::get('_api_user_'.$user_id)['nick_name'],
                    'address_id' => Cache::get('_api_user_'.$user_id)['address_id']
                ];
                Cache::put("_api_deputy_user_".$user_id, $info, 60*24*1);
            }

        }
        return $next($request);
    }
}
