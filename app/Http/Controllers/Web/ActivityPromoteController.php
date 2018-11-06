<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ActivityPromoteService;

class ActivityPromoteController extends Controller
{
    //限时抢购
    public function buyLimit(){
        $review_status = 3;
        try{
            $promoteInfo = ActivityPromoteService::buyLimit($review_status);
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
        $userId = session('_web_user_id');
        try{
            $activityInfo = ActivityPromoteService::buyLimitToBalance($goodsId,$activityId,$goodsNum,$userId);
            session()->put('buyLimitSession',$activityInfo);
            return $this->success('','',$activityInfo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

}
