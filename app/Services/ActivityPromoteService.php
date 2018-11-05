<?php
namespace App\Services;

use App\Repositories\ActivityPromoteRepo;
use App\Repositories\GoodsRepo;
use Carbon\Carbon;

class ActivityPromoteService
{
    use CommonService;

    public static function getList($params=[], $page = 1 ,$pageSize=10){
        $condition = [];
        if(isset($params['status'])){
            $condition['review_status'] = $params['status'];
        }
        if(!empty($params['goods_name'])){
            $condition['goods_name'] = '%'.$params['goods_name'].'%';
        }

        $info_list = ActivityPromoteRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['end_time'=>'desc']],$condition);
        foreach ($info_list['list'] as &$item){
            if(Carbon::now()->gt($item['end_time'])){
                $item['is_over'] = true;
            }else{
                $item['is_over'] = false;
            }

            if(Carbon::now()->lt($item['begin_time'])){
                $item['is_soon'] = true;
            }else{
                $item['is_soon'] = false;
            }
        }
        return $info_list;
    }


    //web
    //限时抢购
    public static function buyLimit($review_status){
        return ActivityPromoteRepo::getList([],['review_status'=>$review_status]);
    }

    //限时抢购详情
    public static function buyLimitDetails($id){
        $id = decrypt($id);
        $ActivityInfo =  ActivityPromoteRepo::getInfo($id);
        if(empty($ActivityInfo)){
            self::throwBizError('促销商品不存在');
        }
        $goodsInfo = GoodsRepo::getInfo($ActivityInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('产品不存在');
        }
        $goodsInfo['activity_price'] = $ActivityInfo['price'];
        $goodsInfo['activity_num'] = $ActivityInfo['num'];
        $goodsInfo['available_quantity'] = $ActivityInfo['available_quantity'];
        $goodsInfo['activity_id'] = $ActivityInfo['id'];
        $goodsInfo['min_limit'] = $ActivityInfo['min_limit'];
        return $goodsInfo;
    }

    //限时抢购 立即下单
    public static function buyLimitToBalance($goodsId,$activityId,$goodsNum,$userId){
        $goodsInfo = GoodsRepo::getInfo($goodsId);
        $activityInfo = ActivityPromoteRepo::getInfo($activityId);

        //规格判断处理
        if($goodsNum > $activityInfo['available_quantity']){
            self::throwBizError('超出当前可售数量');
        }
        if($goodsNum < $activityInfo['min_limit']){
            self::throwBizError('不能低于起售数量');
        }

        if($goodsNum % $goodsInfo['packing_spec'] == 0){
            $goodsNumber = $goodsNum;
        }else{
            if($goodsNum > $goodsInfo['packing_spec']){
                $yuNumber = $goodsNum % $goodsInfo['packing_spec'];
                $dNumber = $goodsInfo['packing_spec'] - $yuNumber;
                $goodsNumber = $goodsNum + $dNumber;

            }else{
                $goodsNumber = $goodsInfo['packing_spec'];
            }
        }

        //商品信息
        $activityInfo['goods_number'] = $goodsNumber;
        $activityInfo['account_money'] = $goodsNumber * $activityInfo['price'];
        $activityInfo['goods_price'] = $activityInfo['price'];
        $activityArr = [];
        $activityArr[] = $activityInfo;
        return $activityArr;
    }
}