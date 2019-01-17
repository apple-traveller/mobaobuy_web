<?php

namespace App\Http\Controllers\Api;
use App\Services\ShopGoodsQuoteService;
use App\Services\UserAddressService;
use Illuminate\Http\Request;
use App\Services\ActivityPromoteService;
use Illuminate\Support\Facades\Cache;
class ActivityConsignController extends ApiController
{
    //清仓特卖
    public function index(){
        $condition['b.type'] = 3;//清仓特卖
        $condition['b.is_delete'] = 0;
        $condition['b.consign_status'] = 1;
        try{
            $consignInfo =  ShopGoodsQuoteService::getShopGoodsQuoteListByFields(['add_time'=>'desc'],$condition);
            return $this->success(compact('consignInfo'),'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //清仓特卖详情
    public function detail(Request $request){
        $userId = 0;
        $uuid = $request->input('token');
        if(!empty($uuid)){
            $userId = Cache::get($uuid, 0);
        }
        $id = $request->input('id');
        //进入详情页 增加点击量
        try{
            $goodsInfo = ShopGoodsQuoteService::detailApi($id,$userId);
            return $this->success(compact('goodsInfo'),'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //清仓特卖 立即下单
    public function toBalance(Request $request){
        $goodsId = $request->input('goodsId');
        $activityId = $request->input('activityId');
        $goodsNum = $request->input('goodsNum');
        $userInfo = $this->getUserInfo($request);
        $deputy_user = $this->getDeputyUserInfo($request);
        try{
            $activityInfo = ShopGoodsQuoteService::toBalance($goodsId,$activityId,$goodsNum,$userInfo['id']);
            //判断是否有默认地址如果有 则直接赋值 没有则取出一条
            $address_id = UserAddressService::getOneAddressIdApi($userInfo,$deputy_user);
            $session_data = [
                'goods_list'=>$activityInfo,
                'address_id'=>$address_id,
                'from'=>'consign'
            ];
            Cache::put('cartSession'.$deputy_user['firm_id'], $session_data, 60*24*1);
            return $this->success($session_data,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


}
