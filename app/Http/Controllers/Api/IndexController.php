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
use App\Services\DemandService;
use App\Services\IndexService;
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
        //成交动态 假数据 暂时定为$trans_type=1 时为开启创建并显示假数据 暂时创建的是8点到18点之间的数据 缓存有效期一天
        $trans_type = getConfig('open_trans_flow');
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
        foreach($trans_list['list'] as $k=>$v){
            $trans_list['list'][$k]['add_time'] = substr($trans_list['list'][$k]['add_time'],5);
        }

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

    //商品列表
    public function getGoodsList(Request $request)
    {
        $goodsList = GoodsService::getGoodsList(['pageSize'=>4,'page'=>1,'orderType'=>['add_time'=>'desc']],['is_delete'=>0]);
        return $this->success(['goods_list' => $goodsList['list']]);
    }

    //咨询列表
    public function getArticleList(Request $request)
    {
        $article_list = ArticleService::getArticleLists(['pageSize'=>7, 'page'=>1,'orderType'=>['add_time'=>'desc']], ['is_show'=> 1]);
        return $this->success(['article_list' => $article_list['list']]);
    }

    //获取供应商
    public function getShopsList(Request $request)
    {
        $shops = ShopGoodsQuoteService::getShopOrderByQuote(5);
        return $this->success(['shops' => $shops]);
    }

    //卖货需求
    public function addDemand(Request $request){
        $uuid = $request->input('token');
        $user_id = 0;
        if(!empty($uuid)){
            $user_id = Cache::get($uuid, 0);
        }
        if(empty($user_id) || $user_id!=0){
            $data = [
                'user_id' => 0,
                'contact_info' => $request->input('contact',''),
                'desc' => $request->input('content','')
            ];
        }else{
            $userinfo = UserService::getInfo($user_id);
            $data = [
                'user_id' => $user_id,
                'contact_info' => $userinfo['user_name'],
                'desc' => $request->input('content','')
            ];
        }
        if(empty($data['contact_info'])){
            return $this->error('联系方法不能为空!');
        }
        if(empty($data['desc'])){
            return $this->error('需求内容不能为空!');
        }

        DemandService::create($data);

        return $this->success('','需求信息提交成功，请耐心等待客服联系！');
    }



}