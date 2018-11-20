<?php

namespace App\Http\Controllers\Web;
use App\Services\ActivityWholesaleService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ActivityPromoteService;

class ActivityWholesaleController extends Controller
{
    //集采拼团
    public function index(){
        $condition['review_status'] = 3;//已审核
        try{
            $wholesaleInfo = ActivityWholesaleService::wholesale($condition);
            return $this->display('web.activity.wholesale',compact('wholesaleInfo'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //集采拼团详情
    public function detail($id){
        $userId = session('_web_user_id');
        //进入详情页 增加点击量
        try{
            ActivityWholesaleService::addClickCount($id);
            $goodsInfo = ActivityWholesaleService::detail($id,$userId);
            return $this->display('web.activity.wholesaledetail',compact('goodsInfo'));
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

        if(session('_curr_deputy_user')['is_self'] && (session('_curr_deputy_user')['is_firm'] == 0)){
            return $this->error('抢购只能是企业用户下单');
        }
        if((session('_curr_deputy_user')['is_firm'] == 1) && (session('_curr_deputy_user')['is_self'] == 0)){
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
