<?php

namespace App\Http\Controllers\Api;

use App\Services\ShopGoodsQuoteService;
use Illuminate\Http\Request;
use App\Services\GoodsService;
use App\Services\UserRealService;
use App\Services\CartService;
use Illuminate\Support\Facades\Cache;
class GoodsController extends ApiController
{
    //报价列表
    public function getList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = $request->input("pageSize",10);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
        $sort_goods_number = $request->input("sort_goods_number",'');
        $sort_add_time = $request->input("sort_add_time",'');
        $sort_shop_price = $request->input("sort_shop_price",'');
        $orderType = $request->input("orderType","b.add_time:desc");
        $brand_id = $request->input("brand_id","");
        $cate_id = $request->input('cate_id',"");
        $place_id = $request->input('place_id',"");
        $condition = [];

        $orderBy = [];
        if(!empty($sort_goods_number)){
            $orderBy['b.goods_number'] = $sort_goods_number;
        }
        if(!empty($sort_add_time)){
            $orderBy['b.add_time'] = $sort_add_time;
        }
        if(!empty($sort_shop_price)){
            $orderBy['b.shop_price'] = $sort_shop_price;
        }
        if(empty($sort_goods_number) && empty($sort_add_time) && empty($sort_shop_price) && !empty($orderType)){
            $t = explode(":",$orderType);
            $orderBy[$t[0]] = $t[1];
        }
        if(empty($lowest)&&empty($highest)){
            $condition = [];
        }
        if($lowest=="" && $highest!=""){
            $condition['shop_price|<='] = $highest;
        }
        if($highest=="" && $lowest!=""){
            $condition['shop_price|>='] = $lowest;
        }
        if($lowest!="" && $highest!=""&&$lowest<$highest){
            $condition['shop_price|<='] = $highest;
            $condition['shop_price|>='] = $lowest;
        }
        if($lowest>$highest){
            $condition['shop_price|>='] = $lowest;
        }

        if(!empty($brand_id)){
            $condition['g.brand_id'] = $brand_id;
        }
        if(!empty($cate_id)){
            $c['opt'] = 'OR';
            $c['g.cat_id'] = $cate_id;
            $c['cat.parent_id'] = $cate_id;
            $condition[] = $c;
        }
        if(!empty($place_id)){
            $condition['place_id'] = $place_id;
        }

        $goodsList= ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>$orderBy],$condition);
        if(empty($goodsList['list'])){
            return $this->error('无数据');
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

    //保存关键词
    public function saveHotKeyWords(Request $request)
    {
        $keyword = $request->input('keywords');
        $user_id = $request->input('user_id');
        if(empty($user_id)){
            $user_id = 'a'.str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        }
        $data = [
            'keywords' => $keyword,
            'user_id' =>$user_id,
            'ip' =>$request->getClientIp()
        ];
        GoodsService::saveHotKeyWords($data);
        return $this->success('','success');
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
        $userId = $request->input('userid');
        if (empty($userId)){
            return $this->error('缺少参数，userid');
        }
        try{
            $cartInfo = GoodsService::cart($userId);
            return $this->success(compact('cartInfo'));
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //删除购物车商品
    public function delCart(Request $request){
        $id = $request->input('id');
        try{
            $flag = GoodsService::delCart($id);
            if($flag){
                return $this->success('','删除成功');
            }else{
                return $this->error('','购物车无此商品',402);
            }

        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //清空购物车
    public function clearCart(Request $request){
        $userId = $request->input('id');
        try{
            GoodsService::clearCart($userId);
            return $this->success('','清空成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //递加产品数量
    public function addCartGoodsNum(Request $request){
        $id = $request->input('id');//购物车id
        try{
            $account = GoodsService::addCartGoodsNum($id);
            return $this->success($account,'递加成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //递减产品数量
    public function reduceCartGoodsNum(Request $request){
        $id = $request->input('id');//购物车id
        try{
            $account = GoodsService::reduceCartGoodsNum($id);
            return $this->success($account,'递减成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改购物车数量
    public function editCartNum(Request $request){
        $cartNum = $request->input('cartNum');
        $id = $request->input('id');
        if(!is_numeric($cartNum)){
            return $this->error('传入的数量必须为数字');
        }
        try{
            GoodsService::editCartNum($id,$cartNum);
            return $this->success('','success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //购物车input判断，修改
    public function checkListenCartInput(Request $request){
        $id = $request->input('id');
        $goodsNumber = $request->input('goodsNumber');
        try{
            $goods_number = GoodsService::checkListenCartInput($id,$goodsNumber);
            return $this->success($goods_number,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //获取购物车产品数量
    public function getCartNum(Request $request)
    {   $user_id = $this->getUserID($request);
        $num = 0;
        if(!empty($user_id)){
            //登录用户
            $curr_deputy_user = $this->getDeputyUserInfo($request);
            if($curr_deputy_user['is_self'] == 0){
                $user_id = $curr_deputy_user['firm_id'];
            }else{
                $user_id = $this->getUserID($request);
            }
            $num = CartService::getUserCartNum($user_id);
        }else{
            $num = 0;

        }
        return $this->success(['cart_num'=>$num],'success');
    }

    //购物车去结算
    public function toBalance(Request $request)
    {
        $cartIds = $request->input('cartId');
        $cartIds = explode(',',$cartIds);
        $userInfo = $this->getUserInfo($request);
        //return $this->success(Cache::get('cartSession46'),'success');
        try{
            $goods_list = GoodsService::toBalance($cartIds,$userInfo['id']);
            //进入订单确认页面前先定义购物车缓存
            $cartCache = [
                'goods_list'=>$goods_list,
                'address_id'=> $userInfo['address_id'],
                'from'=>'cart'
            ];
            Cache::put('cartSession'.$userInfo['id'], $cartCache, 60*24*1);
            return $this->success($cartCache,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }









}