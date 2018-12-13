<?php

namespace App\Http\Controllers\Web;
use App\Services\ActivityWholesaleService;
use App\Services\ShopGoodsQuoteService;
use App\Services\UserAddressService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ActivityPromoteService;

class ActivityConsignController extends Controller
{
    //清仓特卖
    public function index(){
        $condition['type'] = 3;//清仓特卖
        $condition['is_delete'] = 0;
        $condition['consign_status'] = 1;
        try{
            $consignInfo =  ShopGoodsQuoteService::getShopGoodsQuoteListByFields(['add_time'=>'desc'],$condition);
            return $this->display('web.activity.consign',compact('consignInfo'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //清仓特卖详情
    public function detail($id){
        $userId = session('_web_user_id');
        //进入详情页 增加点击量
        try{
            $goodsInfo = ShopGoodsQuoteService::detail($id,$userId);
            return $this->display('web.activity.consigndetail',compact('goodsInfo'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //清仓特卖 立即下单
    public function toBalance(Request $request){
        $goodsId = $request->input('goodsId');
        $activityId = $request->input('activityId');
        $goodsNum = $request->input('goodsNum');
        $userInfo = session('_web_user');


        try{
            $activityInfo = ShopGoodsQuoteService::toBalance($goodsId,$activityId,$goodsNum,$userInfo['id']);
            //判断是否有默认地址如果有 则直接赋值 没有则取出一条
            $address_id = UserAddressService::getOneAddressId();
            $session_data = [
                'goods_list'=>$activityInfo,
                'address_id'=>$address_id,
                'from'=>'consign'
            ];
            session()->put('cartSession',$session_data);
            return $this->success('','',$activityInfo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //抢购详情  最大数量控制
    public function buyLimitMaxLimit(Request $request){
       $goods_number =  $request->input('goods_number');
       $id = $request->input('id');
       if(session('_curr_deputy_user')['is_self'] == 0 && session('_curr_deputy_user')['is_firm'] == 1){
           $userId = session('_curr_deputy_user')['firm_id'];
       }elseif(session('_curr_deputy_user')['is_self'] == 1 && session('_curr_deputy_user')['is_firm'] == 1){
           $userId = session('_web_user_id');
       }

       try{
            $maxBuyNumInfo = ActivityPromoteService::buyLimitMaxLimit($userId,$id,$goods_number);
            return $this->success('','',$maxBuyNumInfo);
       }catch (\Exception $e){
           return $this->error($e->getMessage());
       }
    }

}
