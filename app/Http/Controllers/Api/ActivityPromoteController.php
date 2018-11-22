<?php

namespace App\Http\Controllers\Api;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\ActivityPromoteService;

class ActivityPromoteController extends ApiController
{
    //限时抢购
    public function buyLimit(){
        $condition['review_status'] = 3;
        try{
            $promoteInfo = ActivityPromoteService::buyLimit($condition);
            return $this->success($promoteInfo,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //限时抢购详情
    public function buyLimitDetail(Request $request){
        $id = $request->input('id');
        $userId = $this->getUserID($request);
        //进入详情页 增加点
        try{
            $res = ActivityPromoteService::addClickCountApi($id);
            $goodsInfo = ActivityPromoteService::buyLimitDetailsApi($id,$userId);
            return $this->success(compact('goodsInfo'),'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //抢购详情 立即下单
    public function buyLimitToBalance(Request $request){
        $goodsId = $request->input('goodsId');
        $activityId = $request->input('activityId');
        $goodsNum = $request->input('goodsNum');
        $userInfo = $this->getUserInfo($request);
        $apiDeputyUser = $this->getDeputyUserInfo($request);

        if($apiDeputyUser['is_self'] && ($apiDeputyUser['is_firm'] == 0)){
            return $this->error('抢购只能是企业用户下单');
        }
        if(($apiDeputyUser['is_firm'] == 1) && ($apiDeputyUser['is_self'] == 0)){
            if(!session('_curr_deputy_user')['can_po']){
                return $this->error('您没有权限为该企业下单');
            }
        }
        try{
            $activityInfo = ActivityPromoteService::buyLimitToBalance($goodsId,$activityId,$goodsNum,$userInfo['id']);
            //判断是否有默认地址如果有 则直接赋值 没有则取出一条
            if($userInfo['address_id']){
                $address_id = $userInfo['address_id'];
            }else{
                #取一条地址id
                $address_id = UserService::getOneAddressId($userInfo['id']);
            }
            $session_data = [
                'goods_list'=>$activityInfo,
                'address_id'=>$address_id,
                'from'=>'promote'
            ];
            Cache::put('cartSession'.$userInfo['id'], $session_data, 60*24*1);
            return $this->success($session_data,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }



}
