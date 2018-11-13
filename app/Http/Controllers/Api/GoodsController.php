<?php

namespace App\Http\Controllers\Api;

use App\Services\ShopGoodsQuoteService;
use Illuminate\Http\Request;
use App\Services\GoodsService;
use App\Services\UserRealService;
class GoodsController extends ApiController
{
    //报价列表
    public function getList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $sort_shop_price = $request->input("sort_shop_price",'');
        $orderType = $request->input("orderType","b.add_time:desc");
        $cate_id = $request->input('cate_id',"");
        $condition = [];
        $orderBy = [];
        if(!empty($sort_shop_price)){
            $orderBy['b.shop_price'] = $sort_shop_price;
        }
        if(empty($sort_shop_price) && !empty($orderType)){
            $t = explode(":",$orderType);
            $orderBy[$t[0]] = $t[1];
        }

        if(!empty($cate_id)){
            $c['opt'] = 'OR';
            $c['g.cat_id'] = $cate_id;
            $c['cat.parent_id'] = $cate_id;
            $condition[] = $c;
        }

        $pageSize = 10;
        $goodsList= ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>$orderBy],$condition);
        if(empty($goodsList['list'])){
            return $this->error('error');
        }else{
            return $this->success([
                'list'=>$goodsList['list'],
                'currpage'=>$currpage,
                'total'=>$goodsList['total'],
                'pageSize'=>$pageSize
            ],'success');
        }
    }

    //获取所有的分类
    public function getCates(Request $request)
    {
        $cates = ShopGoodsQuoteService::getShopGoodsQuoteCates();
        return $this->success($cates,'success');
    }

    //商品详情
    public function detail(Request $request)
    {
        $id = $request->input("id");
        if(empty($id)){
            return $this->error('缺少参数，商品报价id');
        }
        $good_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        return $this->success($good_info,'success');
    }

    //价格走势图
    public function productTrend(Request $request)
    {
        $goodsId = $request->input('id');//goods_id
        if(empty($goodsId)){
            return $this->error('缺少参数，商品id');
        }
        try{
            $goodsList = GoodsService::productTrend($goodsId);
            return $this->success($goodsList,'success');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //加入购物车
    public function addCart(Request $request)
    {
        $userId = $this->getUserID($request);
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm']){
            $userId = $deputy_user['firm_id'];
        }

        $invoiceInfo = UserRealService::getInfoByUserId($userId);
        if (empty($invoiceInfo)){
            return $this->error('您还没有实名认证，不能下单');
        }
        if ($invoiceInfo['review_status'] != 1 ){
            return $this->error('您的实名认证还未通过，不能下单');
        }

        //报价表添加到购物车.
        $id = $request->input('id');
        $number = $request->input('number');
        try{
            GoodsService::searchGoodsQuote($userId,$id,$number);
            $count = GoodsService::getCartCount($userId);
            return $this->success($count,'加入购物车成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //购物车列表
    public function getCartList(Request $request)
    {

    }


}