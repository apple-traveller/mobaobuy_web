<?php

namespace App\Http\Controllers\Api;

use App\Services\GoodsCategoryService;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Http\Request;
use App\Services\GoodsService;
use App\Services\UserRealService;
use App\Services\CartService;
use Illuminate\Support\Facades\Cache;
use App\Services\UserAddressService;
use App\Services\UserService;
use App\Services\ShopStoreService;

class GoodsController extends ApiController
{
    //自营报价列表
    public function getList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = $request->input("pageSize",10);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
        $sort_goods_number = $request->input("sort_goods_number",'');
        $sort_add_time = $request->input("sort_add_time",'');
        $sort_shop_price = $request->input("sort_shop_price",'');
//        $orderType = $request->input("orderType","b.add_time:desc");
        $brand_id = $request->input("brand_id","");
        $cate_id = $request->input('cate_id',"");
        $place_id = $request->input('place_id',"");
        $goods_name = $request->input('goods_name','');
        $is_self_run = $request->input('is_self_run',0);
        $type = $request->input('type',0);
        $shop_store_id = $request->input('shop_store_id',0);
        $condition =[];
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
//        if(empty($sort_goods_number) && empty($sort_add_time) && empty($sort_shop_price) && !empty($orderType)){
//            $t = explode(":",$orderType);
//            $orderBy[$t[0]] = $t[1];
//        }
        if(empty($lowest)&&empty($highest)){
            $condition = [];
        }
        if(!empty($is_self_run)){
            $condition['b.is_self_run'] = 1;
        }
        if(!empty($goods_name)){
            $condition['b.goods_name'] = "%".$goods_name."%";
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
            $c['cat2.parent_id'] = $cate_id;
            $condition[] = $c;
        }
        if(!empty($place_id)){
            $condition['place_id'] = $place_id;
        }
        if($shop_store_id!=0){
            $condition['b.shop_store_id'] = $shop_store_id;
        }
        if(empty($type)){
            //$condition['b.type'] = '1';//小程序默认的只显示自营报价
        }else{
            if($type == 3){
                $condition['b.is_self_run'] = 0;
            }else{
                $condition['b.type'] = $type;
                $condition['b.is_self_run'] = 1;
            }
        }

        $condition['b.is_delete'] = 0;
        $goodsList= ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>$orderBy],$condition);
        foreach($goodsList['list'] as &$item){
            if($item['expiry_time']<\Carbon\Carbon::now()){
                $item['is_expire'] = true;
            }else{
                $item['is_expire'] = false;
            }
            if($item['goods_number']<=0){
                $item['is_sale'] = true;
            }else{
                $item['is_sale'] = false;
            }
        }
        if(empty($goodsList['list'])){
            return $this->success('','无数据');
        }else{
            return $this->success([
                'list'=>$goodsList['list'],
                'currpage'=>$currpage,
                'total'=>$goodsList['total'],
                'pageSize'=>$pageSize
            ],'success');
        }
    }



    //查询商品名称列表
    public function searchGoodsname(Request $request)
    {
        $goods_name = $request->input('goods_name');
        $pageSize = $request->input('pageSize',10);
        $currpage = $request->input('currpage',1);
        $condition = [];
        if(!empty($goods_name)){
            $condition['goods_name'] = "%".$goods_name."%";
        }
        $arr = [];
        $goodsList = GoodsService::getGoodsList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        foreach($goodsList['list'] as $k=>$v){
            $arr[] = $goodsList['list'][$k]['goods_name'];
        }
        return $this->success($arr,'success');
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
        if(empty($good_info)){
            return $this->error("没有该商品");
        }
        //判断该商品是否被收藏
        $user_id = $this->getUserID($request);
        $flag = UserService::checkUserIsCollectApi($user_id,$good_info['goods_id']);
        $good_info['is_collect'] = $flag;
        $goods_id = $good_info['goods_id'];
        $shop_id = $good_info['shop_id'];
        $condition = [
            'goods_id'=>$goods_id,
            'shop_id'=>$shop_id
        ];
        $goods_quote_list = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>4,'page'=>1,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->success(['good_info'=>$good_info,'goods_quote_list'=>$goods_quote_list['list'],],'success');
    }

    //价格走势图
    public function productTrend(Request $request)
    {
        $goodsId = $request->input('id');//goods_id
        if(empty($goodsId)){
            return $this->error('缺少参数，商品id');
        }
        try{
            $goodsList = GoodsService::productTrendApi($goodsId);
            return $this->success($goodsList,'success');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //保存关键词
    public function saveHotKeyWords(Request $request)
    {
        $search_key = $request->input('search_key');
        if(empty($search_key)){
            return $this->error('关键字不能为空');
        }
        GoodsService::saveHotKeyWords($search_key);
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
        $id = (int)$request->input('id');
        $number = (int)$request->input('number');
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
        
        $userId = $this->getUserID($request);
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm'] && $deputy_user['is_self']==0){
            $userId = $deputy_user['firm_id'];
        }
        $user_real = UserRealService::getInfoByUserId($userId);
        if(empty($user_real)){
            return $this->error("您还未实名认证");
        }
        try{
            $cartInfo = GoodsService::cart($userId);
            foreach($cartInfo['cartInfo'] as &$item){
                $shop_quote_info = ShopGoodsQuoteService::getShopGoodsQuoteById($item['shop_goods_quote_id']);
                if($shop_quote_info['expiry_time']<\Carbon\Carbon::now()){
                    $item['is_expire'] = true;
                }else{
                    $item['is_expire'] = false;
                }
                if($shop_quote_info['goods_number']<=0){
                    $item['is_sale'] = true;
                }else{
                    $item['is_sale'] = false;
                }
            }
            foreach($cartInfo['cartInfo'] as $k=>$v){
                $cartInfo['cartInfo'][$k]['inventory'] = $cartInfo['quoteInfo'][$k]['goods_number'];
                $cartInfo['cartInfo'][$k]['account'] = $cartInfo['quoteInfo'][$k]['account'];
                $cartInfo['cartInfo'][$k]['delivery_place'] = $cartInfo['quoteInfo'][$k]['delivery_place'];
                $cartInfo['cartInfo'][$k]['packing_spec'] = $cartInfo['goodsInfo'][$k]['packing_spec'];
            }
            return $this->success($cartInfo['cartInfo']);
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

    //购物车批量删除
    public function batchDelete(Request $request)
    {
        $cart_ids = $request->input('cart_ids');
        try{
            $id_arr = explode(',',$cart_ids);
            foreach($id_arr as $item){
                GoodsService::delCart($item);
            }
            return $this->success('','批量删除成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //递加商品数量
    public function addCartGoodsNum(Request $request){
        $id = $request->input('id');//购物车id
        try{
            $account = GoodsService::addCartGoodsNum($id);
            return $this->success($account,'递加成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //递减商品数量
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
            $flag = GoodsService::editCartNum($id,$cartNum);
            //dd($flag);
            if(empty($flag)){
                return $this->error('购物车中没有此商品');
            }else{
                return $this->success(['goods_number'=>$flag['goods_number'],'account'=>number_format($flag['goods_price']*$flag['goods_number'],2,".","")],'success');
            }
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

    //获取购物车商品数量
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

    //修改收货地址
    public function editOrderAddress(Request $request)
    {
        $address_id = $request->input('address_id','');
        $deputy = $this->getDeputyUserInfo($request);
        if(!$address_id){
            return $this->error('缺少参数地址ID！');
        }
        $address_info = UserAddressService::getAddressInfo($address_id);
        if(!$address_info){
            return $this->error('地址信息不存在！');
        }
        $cartSession = Cache::get('cartSession'.$deputy['firm_id']);
        $cartSession['address_id'] = $address_id;

        Cache::put('cartSession'.$deputy['firm_id'],$cartSession,60*24*1);
        $cartSession = Cache::get('cartSession'.$deputy['firm_id']);
        return $this->success($cartSession);
    }

    //购物车去结算
    public function toBalance(Request $request)
    {
        $cartIds = $request->input('cartId');
        $cartIds_array = explode(',',$cartIds);
        $userInfo = $this->getUserInfo($request);
        $dupty_user = $this->getDeputyUserInfo($request);
        try{
            $goods_list = GoodsService::toBalance($cartIds_array,$userInfo['id']);
            //判断是否有默认地址如果有 则直接赋值 没有则取出一条
            $address_id = UserAddressService::getOneAddressIdApi($userInfo,$dupty_user);
            //进入订单确认页面前先定义购物车缓存
            $cartCache = [
                'goods_list'=>$goods_list,
                'address_id'=> $address_id,
                'from'=>'cart',
            ];
            Cache::put('cartSession'.$dupty_user['firm_id'], $cartCache, 60*24*1);
            $cartSession = Cache::get('cartSession'.$dupty_user['firm_id']);
            return $this->success($cartSession,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage()); 
        }
    }

    //物性表
    public function goodsAttribute(Request $request)
    {
        $page = $request->input('currpage', 1);
        $page_size = $request->input('pagesize', 10);
        $goods_name= $request->input('goods_name', '');
        $condition = [];
        if(!empty($goods_name)){
            $condition['goods_full_name'] = '%' . $goods_name . '%';
        }
        try{
            $goodsInfo = GoodsService::goodsAttribute($condition,$page,$page_size);
            if(!empty($goodsInfo)){
                return $this->success(['total'=>$goodsInfo['total'],'goodslist'=>$goodsInfo['list']]);
            }else{
                return $this->error('无数据');
            }

        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //物性表详情
    public function goodsAttributeDetails(Request $request){
        $id = $request->input('goods_id');
        if(empty($id)){
            return $this->error('缺少参数，goods_id');
        }
        try{
            $shopInfo = GoodsService::getGoodInfo($id);
            //dd($shopInfo);
            return $this->success($shopInfo,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //物性表详情页下面的供应商列表
    public function goodSupplyList(Request $request)
    {
        $id = $request->input('goods_id');
        $page = $request->input('currpage',1);
        $page_size = $request->input('pagesize',6);
        if(empty($id)){
            return $this->error('缺少参数，goods_id');
        }
        try{
            $shopGoodsInfo = GoodsService::goodsAttributeDetails($id,$page,$page_size);
            //dd($shopGoodsInfo);
            return $this->success($shopGoodsInfo['list'],'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //获取分类
    public function getCateList(Request $request)
    {
        $parent_id = $request->input('parent_id',0);
        $res = GoodsCategoryService::getList($parent_id);
        foreach($res as &$item){
            $item['cat_img'] = getFileUrl($item['cat_img']);
        }
        return $this->success($res,'success');
    }

    //获取直营所有的店铺
    public function getShopStoreList(Request $request)
    {
        $res = ShopStoreService::getList();
        if(empty($res)){
            return $this->error('error');
        }else{
            return $this->success($res,'success');
        }
    }
}