<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ActivityPromoteService;
use App\Services\AdService;
use App\Services\GoodsService;
use App\Services\OrderInfoService;
use App\Services\ArticleService;
use App\Services\ShopGoodsQuoteService;
use App\Services\UserService;
use Illuminate\Support\Facades\Cache;
class IndexController extends ApiController
{
    //获取首页大图轮播
    public function getBannerAd(Request $request)
    {
        $banner_ad = AdService::getActiveAdvertListByPosition(1);
        foreach($banner_ad as $k=>$v){
            $banner_ad[$k]['ad_img'] = getFileUrl($banner_ad[$k]['ad_img']);
        }
        return $this->success(['banner_ad' => $banner_ad]);
    }

    //获取首页成交动态
    public function getTransList(Request $request)
    {
        $trans_list = OrderInfoService::getOrderGoods([], 1, 3);
        return $this->success(['trans_list' => $trans_list['list']]);
    }

    //获取首页优惠活动
    public function getPromoteList(Request $request)
    {
        $promote_list = ActivityPromoteService::getList(['status'=>3,'end_time'=>1], 1, 3);
        return $this->success(['promote_list' => $promote_list['list']]);
    }

    //自营报价
    public function getGoodsQuoteList(Request $request)
    {
        $goodsQuoteList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>4,'page'=>1,'orderType'=>['b.add_time'=>'desc']],['is_self_run'=>1]);
        return $this->success(['goodsQuoteList' => $goodsQuoteList['list']]);
    }

    //产品列表
    public function getGoodsList(Request $request)
    {
        $goodsList = GoodsService::getGoodsList(['pageSize'=>4,'page'=>1,'orderType'=>['add_time'=>'desc']],['is_delete'=>0]);
        return $this->success(['goods_list' => $goodsList['list']]);
    }

    //咨询列表
    public function getArticleList(Request $request)
    {
        $article_list = ArticleService::getArticleLists(['pageSize'=>7, 'page'=>1,'orderType'=>['add_time'=>'desc']], ['is_show'=> 1])['list'];
        return $this->success(['article_list' => $article_list['list']]);
    }



}