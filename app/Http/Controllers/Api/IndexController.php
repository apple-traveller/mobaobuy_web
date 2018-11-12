<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ActivityPromoteService;
use App\Services\AdService;
use App\Services\GoodsService;
use App\Services\OrderInfoService;
use App\Services\IndexService;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Support\Facades\Cache;
class IndexController extends Controller
{
    public function index(Request $request)
    {
        //获取大轮播图
        $banner_ad = AdService::getActiveAdvertListByPosition(1);

        //获取活动
        $promote_list = ActivityPromoteService::getList(['status'=>3,'end_time'=>1], 1, 2);

        //成交动态 假数据 暂时定为$trans_type=1 时为开启创建并显示假数据 暂时创建的是8点到18点之间的数据 缓存有效期一天
        $trans_type = 1;
        $trans_false_list = [];
        if($trans_type == 1){
            $day = date('Ymd');
            $cache_name = $day.'TRANS';
            if(Cache::has($cache_name)){
                $trans_false_list = Cache::get($cache_name);
            }else{//没有缓存 创建假数据
                $trans_false_list = IndexService::createFalseData();
                Cache::add($cache_name,$trans_false_list,1440);
            }
        }
        //成交动态 真实数据
        $trans_list = OrderInfoService::getOrderGoods([], 1, 10);
        //自营报价
        $goodsQuoteList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>4,'page'=>1,'orderType'=>['b.add_time'=>'desc']],['is_self_run'=>1]);
        //获取产品列表
        $goodsList = GoodsService::getGoodsList(['pageSize'=>4,'page'=>1,'orderType'=>['add_time'=>'desc']],['is_delete'=>0]);

        return $this->result([
            'banner_ad' => $banner_ad,
            'goodsQuoteList'=>$goodsQuoteList['list'],
            'promote_list'=>$promote_list['list'],
            'trans_list'=>$trans_list['list'],
            'trans_false_list'=>$trans_false_list,
            'goodsList'=>$goodsList['list']
        ],200,'success');
    }
}