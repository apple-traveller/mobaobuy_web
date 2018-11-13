<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
class ApiController
{
    protected function success($data = '',$msg = '')
    {
        $result = [
            'code' => 200,
            'msg'  => $msg,
            'data' => $data
        ];

        return response()->json($result);
    }

    protected function error($msg = '', $data = '', $code='400')
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ];
        return response()->json($result);
    }

    public function getUserID(Request $request){
        $uuid = $request->input('Authenticate');
        if(!empty($uuid)){
            $user_id = Cache::get($uuid, 0);
            if($user_id){
                return $user_id;
            }
        }

        return response()->json([
            'code' => '-400',
            'msg' => '您已退出登录或登录超时！',
        ]);
    }

    public function getUserInfo(Request $request){
        $uuid = $request->input('Authenticate');
        if(!empty($uuid)){
            $user_id = Cache::get($uuid, 0);
            if($user_id){
                return Cache::remember('_api_user_'.$user_id, 60*24*1, function() use($user_id){
                    $user_info = UserService::getInfo($user_id);
                    if(!$user_info['is_firm']){
                        $user_info['firms'] = UserService::getUserFirms($user_id);
                    }
                    return $user_info;
                });
            }
        }

        return response()->json([
            'code' => '-400',
            'msg' => '您已退出登录或登录超时！',
        ]);
    }

    public function getDeputyUserInfo(Request $request){
        $uuid = $request->input('Authenticate');
        if(!empty($uuid)){
            $user_id = Cache::get($uuid, 0);
            if($user_id){
                return Cache::remember('_api_deputy_user_'.$user_id, 60*24*1, function() use($user_id, $request){
                    $userinfo = $this->getUserInfo($request);
                    $info = [
                        'is_self' => 1,
                        'is_firm' => $userinfo['is_firm'],
                        'firm_id'=> $userinfo['id'],
                        'name' => $userinfo['nick_name'],
                    ];
                    return $info;
                });
            }
        }

        return response()->json([
            'code' => '-400',
            'msg' => '您已退出登录或登录超时！',
        ]);
    }
}