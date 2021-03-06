<?php
namespace App\Services;

use App\Repositories\ActivityPromoteRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\OrderGoodsRepo;
use App\Repositories\OrderInfoRepo;
use App\Repositories\UserCollectGoodsRepo;
use Carbon\Carbon;

class ActivityPromoteService
{
    use CommonService;

    public static function getList($params=[], $page = 1 ,$pageSize=10){
        $condition = ['is_delete'=>0];
        if(isset($params['status'])){
            $condition['review_status'] = $params['status'];
        }
        if(isset($params['end_time'])){
            $condition['end_time|>'] = Carbon::now();
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
        unset($item);
        return $info_list;
    }


    //web
    //限时抢购
    public static function buyLimit($condition){
        $info_list = ActivityPromoteRepo::getList([],$condition);
        foreach($info_list as &$v){
            $goodsInfo = GoodsRepo::getInfo($v['goods_id']);
            $v['unit_name'] = $goodsInfo['unit_name'];
            $v['goods_name_en'] = $goodsInfo['goods_full_name_en'];
            $shopInfo = ShopService::getShopById($v['shop_id']);
            $v['shop_name_en'] = $shopInfo['shop_name_en'];
        }
        unset($v);

        foreach ($info_list as &$item){
            if(Carbon::now()->gt($item['end_time'])){
                //以结束
                $item['is_over'] = true;
            }else{
                $item['is_over'] = false;
            }

            if(Carbon::now()->lt($item['begin_time'])){
                //未开始
                $item['is_soon'] = true;
            }else{
                //已开始
                $item['is_soon'] = false;
            }
        }
        unset($item);

        //未结束
        $buyLimitArr = [];
        //已结束
        $buyLimitArrOver = [];
        foreach($info_list as $k=>$v){
            if($v['is_over'] == false){
                $buyLimitArr[] = $v;
            }else{
                $buyLimitArrOver[] = $v;
            }
        }

        if(!empty($buyLimitArr)){
            if(!empty($buyLimitArrOver)){
                foreach ($buyLimitArrOver as $kk=>$vv){
                    $keyLen = count($buyLimitArr);
                    $buyLimitArr[$keyLen] = $vv;
                }
            }
        }else{
            return $buyLimitArrOver;
        }
        return $buyLimitArr;

    }

    //限时抢购详情
    public static function buyLimitDetails($id,$userId){
        $id = decrypt($id);
        $ActivityInfo =  ActivityPromoteRepo::getInfo($id);
        if(empty($ActivityInfo)){
            self::throwBizError(trans('error.promote_goods_not_exist'));
        }
        $goodsInfo = GoodsRepo::getInfo($ActivityInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError(trans('error.goods_not_exist'));
        }

        //自定义属性分割
        if(!empty($goodsInfo['goods_attr'])){
            $goodsAttr = explode(';',$goodsInfo['goods_attr']);
            $arr = [];
            foreach($goodsAttr as $k=>$v){
                $good_attr = explode(':',$v);
                    $arr[$k]['attr'] = $good_attr[0];
                    $arr[$k]['value'] = $good_attr[1];
            }

        }else{
            $arr = '';
        }

        $goodsInfo['goods_attrs'] = $arr ? $arr : '';
        $goodsInfo['activity_price'] = $ActivityInfo['price'];
        $goodsInfo['activity_num'] = $ActivityInfo['num'];
        $goodsInfo['available_quantity'] = $ActivityInfo['available_quantity'];
        $goodsInfo['activity_id'] = $ActivityInfo['id'];
        $goodsInfo['min_limit'] = $ActivityInfo['min_limit'];
        $goodsInfo['goods_name'] = $ActivityInfo['goods_name'];
        $goodsInfo['max_limit'] = $ActivityInfo['max_limit'];
        $goodsInfo['goods_id'] = $ActivityInfo['goods_id'];
        //活动有效期总秒数
        $goodsInfo['seconds'] = strtotime($ActivityInfo['end_time']) - time();
        //商品市场价
        $goodsList = GoodsRepo::getList([],['id'=>$ActivityInfo['goods_id']]);
        $goodsInfo['goodsList'] = $goodsList;

        //商品是否已收藏
        $collectGoods= UserCollectGoodsRepo::getInfoByFields(['user_id'=>$userId,'goods_id'=>$ActivityInfo['goods_id']]);
        if(empty($collectGoods)){
            $goodsInfo['collectGoods'] = 0;
        }else{
            $goodsInfo['collectGoods'] = 1;
        }
        return $goodsInfo;
    }

    //限时抢购详情
    public static function buyLimitDetailsApi($id,$userId){
        $ActivityInfo =  ActivityPromoteRepo::getInfo($id);
        if(empty($ActivityInfo)){
            self::throwBizError('促销商品不存在');
        }
        $goodsInfo = GoodsRepo::getInfo($ActivityInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('商品不存在');
        }

        $goodsInfo['activity_price'] = $ActivityInfo['price'];
        $goodsInfo['activity_num'] = $ActivityInfo['num'];
        $goodsInfo['available_quantity'] = $ActivityInfo['available_quantity'];
        $goodsInfo['activity_id'] = $ActivityInfo['id'];
        $goodsInfo['min_limit'] = $ActivityInfo['min_limit'];
        $goodsInfo['goods_name'] = $ActivityInfo['goods_name'];
        $goodsInfo['max_limit'] = $ActivityInfo['max_limit'];
        //活动有效期总秒数
        $goodsInfo['seconds'] = strtotime($ActivityInfo['end_time']) - time();
        //商品市场价
        $goodsList = GoodsRepo::getList([],['id'=>$ActivityInfo['goods_id']]);
        $goodsInfo['goodsList'] = $goodsList;
        //商品是否已收藏
        $collectGoods= UserCollectGoodsRepo::getInfoByFields(['user_id'=>$userId,'goods_id'=>$ActivityInfo['goods_id']]);
        //dd($collectGoods);
        if(empty($collectGoods)){
            $goodsInfo['collectGoods'] = 0;
        }else{
            $goodsInfo['collectGoods'] = 1;
        }
        return $goodsInfo;
    }

    //限时抢购 立即下单
    public static function buyLimitToBalance($goodsId,$activityId,$goodsNum,$userId){

        $activityInfo = ActivityPromoteRepo::getInfo($activityId);
        //先判断活动有效期
        if(strtotime($activityInfo['end_time']) < time()){
            self::throwBizError(trans('error.activity_over_tips'));
        }
        //规格判断处理
        if($goodsNum > $activityInfo['available_quantity']){
            self::throwBizError(trans('error.insufficient_stock_tips'));
        }
        if($goodsNum < $activityInfo['min_limit']){
            self::throwBizError(trans('error.no_less_num_tips'));
        }
        $goodsInfo = GoodsRepo::getInfo($activityInfo['goods_id']);
        if($goodsNum % $goodsInfo['packing_spec'] == 0){
            $goodsNumber = $goodsNum;
        }else{
            if($goodsNum > $goodsInfo['packing_spec']){

                $yuNumber = $goodsNum / $goodsInfo['packing_spec'];
                $dNumber = $goodsInfo['packing_spec'] - $yuNumber;
                $goodsNumber = ($yuNumber+1)*$goodsInfo['packing_spec'];
            }else{
                $goodsNumber = $goodsInfo['packing_spec'];
            }
        }

        //商品信息
        $activityInfo['goods_number'] = $goodsNumber;
        $activityInfo['account_money'] = $goodsNumber * $activityInfo['price'];
        $activityInfo['goods_price'] = $activityInfo['price'];
        $activityInfo['unit_name'] = $goodsInfo['unit_name'];
        $activityArr = [];
        $activityArr[] = $activityInfo;
        return $activityArr;
    }

    //通过id查抢购表数据
    public static function getActivityPromoteById($id){
        $id = decrypt($id);
        $activityPromoteInfo = ActivityPromoteRepo::getInfo($id);
        if(empty($activityPromoteInfo)){
            self::throwBizError(trans('error.goods_not_exist'));
        }
    }


    //通过id查抢购表数据
    public static function getActivityPromoteByIdApi($id){
        $activityPromoteInfo = ActivityPromoteRepo::getInfo($id);
        if(empty($activityPromoteInfo)){
            self::throwBizError('不存在的商品信息');
        }
    }

    //增加限时抢购的点击量
    public static function addClickCount($id)
    {
        $id = decrypt($id);
        return ActivityPromoteRepo::addClickCount($id);
    }

    //增加限时抢购的点击量
    public static function addClickCountApi($id)
    {
        return ActivityPromoteRepo::addClickCount($id);
    }

    public static function buyLimitMaxLimit($userId,$id,$goodsNumber){
        $id = decrypt($id);
        $activityInfo = ActivityPromoteRepo::getInfo($id);
        if(empty($activityInfo)){
            self::throwBizError(trans('error.goods_info_tips'));
        }
        if($activityInfo['max_limit'] != 0){
            $orderList = OrderInfoRepo::getList([],['firm_id'=>$userId,'extension_id'=>$id]);
            $goodsCount = 0;
            foreach($orderList as $v){
                $goodsCount += OrderGoodsRepo::getInfoByFields(['order_id'=>$v['id']])['goods_number'];
            }
            $goodsCount += $goodsNumber;
            if($goodsCount > $activityInfo['max_limit']){
                self::throwBizError(trans('error.beyond_maximum'));
            }
            $data['max_limit'] = $activityInfo['max_limit'];
            $data['can_buy_num'] = $activityInfo['max_limit'] - $goodsCount;
            return $data;
        }
    }

    public static function getWaitReview($condition)
    {
        $count = ActivityPromoteRepo::getTotalCount($condition);
        return $count;
    }
}