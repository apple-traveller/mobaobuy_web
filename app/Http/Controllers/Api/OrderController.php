<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\UserService;
class OrderController extends ApiController
{
    //提交订单
    public function addOrder(Request $request)
    {

    }

    //选择公司
    public function changeDeputy(Request $request)
    {
        $user_id = $request->input('user_id', 0);
        if(empty($user_id)){
            //代表自己
            $info = [
                'is_self' => 1,
                'is_firm' => $this->getUserInfo($request)['is_firm'],
                'firm_id'=> $this->getUserID($request),
                'name' => $this->getUserInfo($request)['nick_name']
            ];
            Cache::put("_api_deputy_user_".$this->getUserID($request), $info, 60*24*1);
            return $this->success($info,'success');
        }else{
            //获取用户所代表的公司
            $firms = UserService::getUserFirms($this->getUserID($request));
            foreach ($firms as $firm){
                if($user_id == $firm['firm_id']){
                    //修改代表信息
                    $firm['is_self'] = 0;
                    $firm['is_firm'] = 1;
                    $firm['firm_id'] = $user_id;
                    $firm['name'] = $firm['firm_name'];
                    Cache::put("_api_deputy_user_".$user_id, $firm, 60*24*1);
                    return $this->success($firm,'success');
                }
            }
            //找不到，清空session
            Cache::forget('_api_user_'.$user_id);
            Cache::forget('_api_deputy_user_'.$user_id);
            return $this->success('','success');
        }
    }

    //获取当前用户所代理的所有公司
    public function getUserFirmList(Request $request)
    {
        $user_id = $this->getUserID($request);
        if($user_id){
            $user_info = $user_info = UserService::getInfo($user_id);
            if(!$user_info['is_firm']){
                $user_info['firms'] = UserService::getUserFirms($user_id);
            }
            return $this->success($user_info,'success');
        }else{
            return $this->error('error');
        }
    }



}