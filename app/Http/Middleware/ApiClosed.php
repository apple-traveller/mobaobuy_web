<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\ApiController;
use App\Services\UserService;
use App\Services\UserRealService;
use App\Services\FirmUserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ApiClosed extends ApiController
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if(getConfig('shop_closed') == '1'){
            return $this->error('网站已关闭');
        }

        $uuid = $request->input('token');
        $user_id = Cache::get($uuid, 0);
        if($user_id!=0 && !empty($user_id)){
            //缓存用户的基本信息
            if(Cache::has('_api_user_'.$user_id)) {
                if(Cache::get('_api_user_'.$user_id)['is_real'] == 2){
                    $user_real_count = UserRealService::getTotalCount(['user_id'=>$user_id,'review_status'=>1]);
                    if($user_real_count > 0){
                        Cache::forget('_api_user_'.$user_id);
                        Cache::forget('_api_deputy_user_'.$user_id);
                    }
                }

                $deputy_user = $this->getDeputyUserInfo($request);
                $user_info = $this->getUserInfo($request);
                if(Cache::has('_api_deputy_user_'.$user_id) && $deputy_user['is_self'] != 1) {
                    $user_info = UserService::getInfo($user_id);
                    //用户不切换生效权限,is_logout存的是企业的id
                    if ($user_info['is_logout'] > 0 && $user_info['is_logout'] == $deputy_user['firm_id']) {
                        $firm = FirmUserService::getInfoByCondition(['firm_id'=>$deputy_user['firm_id'],'user_id'=>$user_id]);
                        $firm_info = UserService::getInfo($firm['firm_id']);
                        $firm['is_self'] = 0;
                        $firm['is_firm'] = 1;
                        $firm['name'] = $firm_info['nick_name'];
                        $firm['address_id'] = $firm_info['address_id'];
                        Cache::put('_api_deputy_user_'.$user_id,$firm,60*24*1);
                        UserService::modify($user_id, ['is_logout' => 0]);
                    }
                }
            }

            if(!Cache::has('_api_user_'.$user_id)){
                $user_info = UserService::getInfo($user_id);
                #判断是否实名
                $user_real_count = UserRealService::getTotalCount(['user_id'=>$user_id,'review_status'=>1]);
                if($user_real_count > 0){
                    $user_info['is_real'] = 1;//已实名
                }else{
                    $user_info['is_real'] = 2;//未实名
                }

                if(!$user_info['is_firm']){
                    $user_info['firms'] = UserService::getUserFirms($user_id);
                }
                Cache::put('_api_user_'.$user_id,$user_info,60*24*1);
            }

            if(!Cache::has('_api_deputy_user_'.$user_id)){
                $user_info = $this->getUserInfo($request);
                $info = [
                    'is_self' => 1,
                    'is_firm' => $user_info['is_firm'],
                    'firm_id'=> $user_id,
                    'name' => $user_info['nick_name'],
                    'address_id' => $user_info['address_id']
                ];
                Cache::put('_api_deputy_user_'.$user_id,$info,60*24*1);
            }
        }
        return $next($request);
    }
}
