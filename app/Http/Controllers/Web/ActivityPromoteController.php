<?php

namespace App\Http\Controllers\Web;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ActivityPromoteService;

class ActivityPromoteController extends Controller
{
    //限时抢购
    public function buyLimit(){
        $condition['review_status'] = 3;
        $condition['end_time|>'] = Carbon::now();
        try{
            $promoteInfo = ActivityPromoteService::buyLimit($condition);
            return $this->display('web.goods.buyLimit',compact('promoteInfo'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //限时抢购详情
    public function buyLimitDetails($id){
        try{
            $goodsInfo = ActivityPromoteService::buyLimitDetails($id);
            return $this->display('web.goods.buyLimitDetails',compact('goodsInfo'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //抢购详情 立即下单
    public function buyLimitToBalance(Request $request){
        $goodsId = $request->input('goodsId');
        $activityId = $request->input('activityId');
        $goodsNum = $request->input('goodsNum');
        $userInfo = session('_web_user');
        try{
            $activityInfo = ActivityPromoteService::buyLimitToBalance($goodsId,$activityId,$goodsNum,$userInfo['id']);
            $session_data = [
                'goods_list'=>$activityInfo,
                'address_id'=>$userInfo['address_id'],
                'from'=>'promote'
            ];
            session()->put('cartSession',$session_data);
            return $this->success('','',$activityInfo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

}
