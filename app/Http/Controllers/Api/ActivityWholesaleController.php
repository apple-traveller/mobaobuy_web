<?php

namespace App\Http\Controllers\Api;
use App\Services\ActivityWholesaleService;
use App\Services\UserAddressService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ActivityWholesaleController extends ApiController
{
    //集采火拼
    public function index(){
        $condition['review_status'] = 3;//已审核
        $condition['is_delete'] = 0;
        try{
            $wholesaleInfo = ActivityWholesaleService::wholesale($condition);
            return $this->success(compact('wholesaleInfo'),'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //集采火拼详情
    public function detail(Request $request){
        $userId = 0;
        $uuid = $request->input('token');
        if(!empty($uuid)){
            $userId = Cache::get($uuid, 0);
        }
        $id = $request->input('id');
        //进入详情页 增加点击量
        try{
            $res = ActivityWholesaleService::addClickCountApi($id);
            $goodsInfo = ActivityWholesaleService::detailApi($id,$userId);
            return $this->success(compact('goodsInfo'),'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //集采火拼 立即下单
    public function toBalance(Request $request){
        $goodsId = $request->input('goodsId');
        $activityId = $request->input('activityId');
        $goodsNum = $request->input('goodsNum');
        $userInfo = $this->getUserInfo($request);
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_self'] && ($deputy_user['is_firm'] == 0)){
            return $this->error('抢购只能是企业用户下单');
        }
        if(($deputy_user['is_firm'] == 1) && ($deputy_user['is_self'] == 0)){
            if(!$deputy_user['can_po']){
                return $this->error('您没有权限为该企业下单');
            }
        }
        try{
            $activityInfo = ActivityWholesaleService::toBalance($goodsId,$activityId,$goodsNum,$userInfo['id']);
            //判断是否有默认地址如果有 则直接赋值 没有则取出一条
            $address_id = UserAddressService::getOneAddressIdApi($userInfo,$deputy_user);
            //dd($address_id);
            $session_data = [
                'goods_list'=>$activityInfo,
                'address_id'=>$address_id,
                'from'=>'wholesale'
            ];

            Cache::put('cartSession'.$deputy_user['firm_id'], $session_data, 60*24*1);
            return $this->success($session_data,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
