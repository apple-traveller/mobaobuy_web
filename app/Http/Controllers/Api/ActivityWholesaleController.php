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
            ActivityWholesaleService::addClickCountApi($id);
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
        try{
            $activityInfo = ActivityWholesaleService::toBalance($goodsId,$activityId,$goodsNum,$userInfo['id']);
            //判断是否有默认地址如果有 则直接赋值 没有则取出一条
            $address_id = UserAddressService::getOneAddressId();
            $session_data = [
                'goods_list'=>$activityInfo,
                'address_id'=>$address_id,
                'from'=>'wholesale'
            ];
            Cache::put('cartSession'.$userInfo['id'], $session_data, 60*24*1);
            return $this->success($session_data,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
