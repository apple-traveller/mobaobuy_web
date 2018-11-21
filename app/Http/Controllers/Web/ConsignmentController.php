<?php

namespace App\Http\Controllers\Web;
use App\Repositories\CartRepo;
use App\Repositories\UserCollectGoodsRepo;
use App\Services\CartService;
use App\Services\GoodsService;
use App\Services\UserAddressService;
use App\Services\UserInvoicesService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Support\Facades\Session;
use App\Services\GoodsCategoryService;
use App\Services\BrandService;
use App\Services\RegionService;
class ConsignmentController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function  index(){

    }

    //寄售
    public function consignment(){

    }

    //寄售详情
    public function consignmentDetails(){

    }

    //产品列表
    public function goodsList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
        $orderType = $request->input("orderType","b.add_time:desc");
        $brand_id = $request->input("brand_id","");
        $cate_id = $request->input('cate_id',"");
        $cat_name = $request->input('cat_name',"");
        $place_id = $request->input('place_id',"");
        $keyword = $request->input('keyword',"");//搜索关键字
        $condition = [];
        if(!empty($orderType)){
            $order = explode(":",$orderType);
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
        if(!empty($keyword)){
            $con['opt'] = 'OR';
            $con['b.goods_name'] = '%'.$keyword.'%';
            $con['cat.cat_name'] = '%'.$keyword.'%';
            $condition[] = $con;
        }
        $orderBy = [];
        if(!empty($orderType)){
            $t = explode(":",$orderType);
            $orderBy[$t[0]] = $t[1];
        }
        $pageSize = 10;
        //产品报价列表
        $goodsList= ShopGoodsQuoteService::getQuoteByWebSearch(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>$orderBy],$condition);
        return $this->display("web.quote.list",[
            'search_data'=>$goodsList,
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'orderType'=>$orderType,
            'lowest'=>$lowest,
            'highest'=>$highest,
            'brand_id'=>$brand_id,
            'cate_id'=>$cate_id,
            'cat_name'=>$cat_name,
            'place_id'=>$place_id,
            'keyword'=>$keyword,
        ]);
    }

    //根据条件范围收索产品(ajax)
    public function goodsListByCondition(Request $request)
    {

        $currpage = $request->input("currpage",1);
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
        $pageSize = 10;
        $goodsList= ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>$orderBy],$condition);
        if(empty($goodsList['list'])){
            return $this->result("",400,'error');
        }else{
            return $this->result([
                'list'=>$goodsList['list'],
                'currpage'=>$currpage,
                'total'=>$goodsList['total'],
                'pageSize'=>$pageSize
            ],200,'success');
        }
    }

    //产品详情
    public function goodsDetail(Request $request)
    {
        $id = $request->input("id");
        $shop_id = $request->input("shop_id");
        $good_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $currpage = $request->input("currpage", 1);
        $goods_id = $good_info['goods_id'];
        $condition = [
            'shop_id' => $shop_id,
            'goods_id' => $goods_id
        ];
        $pageSize = 10;
        $userId = session('_web_user_id');
        $cart_count = GoodsService::getCartCount($userId);
        $goodList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize' => $pageSize, 'page' => $currpage, 'orderType' => ['add_time' => 'desc']], $condition);
//        dd($good_info);
        //是否收藏
        $collectGoods = UserService::checkUserIsCollect($userId,$good_info['goods_id']);
        return $this->display("web.goods.goodsDetail", [
            'good_info' => $good_info,
            'goodsList' => $goodList['list'],
            'total' => $goodList['total'],
            'currpage' => $currpage,
            'pageSize' => $pageSize,
            'id' => $id,
            'shop_id' => $shop_id,
            'cart_count'=>$cart_count,
            'collectGoods'=> $collectGoods
        ]);
    }

    //购物车
    public function cart(Request $request){
        $userId = session('_web_user_id');
        if(session('_curr_deputy_user')['is_firm']){
            $userId = session('_curr_deputy_user')['firm_id'];
        }

        if($request->isMethod('get')){
            try{
                $cartInfo = GoodsService::cart($userId);
                return $this->display('web.goods.cart',compact('cartInfo'));
            }catch(\Exception $e){
                return $this->error($e->getMessage());
            }
        }else{
            //报价表添加到购物车.
            $id = $request->input('id');
            $number = $request->input('number');
            try{
                GoodsService::searchGoodsQuote($userId,$id,$number);
                $count = GoodsService::getCartCount($userId);
                return $this->success('加入购物车成功',"",$count);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
    }

    //删除购物车商品
    public function delCart(Request $request){
        $id = $request->input('id');
        try{
            GoodsService::delCart($id);
            return $this->success();
        }catch(\Exection $e){
            return $this->error($e->getMessage());
        }
    }

    //递加产品数量
    public function addCartGoodsNum(Request $request){
        $id = $request->input('id');
        try{
             $account = GoodsService::addCartGoodsNum($id);
             return $this->success('','',$account);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //递减产品数量
    public function reduceCartGoodsNum(Request $request){
        $id = $request->input('id');
        try{
            $account = GoodsService::reduceCartGoodsNum($id);
            return $this->success('','',$account);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //清空购物车
    public function clearCart(){
        $userId = session('_web_user_id');
        try{
            GoodsService::clearCart($userId);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //购物车 去结算
    public function toBalance(Request $request){
        $cartIds = $request->input('cartId');
        $userId = session('_web_user_id');
        try{
            $cartSession = GoodsService::toBalance($cartIds,$userId);
            session()->put('cartSession',$cartSession);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    /**
     * 订单维护页面
     * @param Request $request
     * @return GoodsController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmOrder(){
        $info = session('_curr_deputy_user');

        //获取发票信息
        try{
            // 判断是否为企业用户
            if($info['is_firm']){
                $userInfo = UserService::getInfo($info['firm_id']);
            }else{
                $userInfo = session('_web_user');
            }
            $invoicesList = GoodsService::getInvoices($userInfo['id']);
            if (!empty($invoicesList)){
                foreach ($invoicesList as $k=>$v){
                    $invoicesList[$k] = UserInvoicesService::getInvoice($v['id']);
                }
                if (!empty($userInfo['invoice_id'])) {
                    $invoicesInfo = UserInvoicesService::getInvoice($userInfo['invoice_id']);
                } else {

                }
            } else {
                $invoicesInfo = [];
                $invoicesList = [];
            }

            // 收货地址列表
            $addressList = UserAddressService::getInfoByUserId($userInfo['id']);
            if (!empty($addressList)){
                foreach ($addressList as $k=>$v){
                    $addressList[$k] = UserAddressService::getAddressInfo($v['id']);
                    if ($v['id'] == $userInfo['address_id']){
                        $addressList[$k]['is_default'] =1;
                        $first_one[$k] = $addressList[$k];
                    } else {
                        $addressList[$k]['is_default'] ='';
                    };
                }
                if(!empty($first_one)){
                    foreach ($first_one as $k1=>$v1){
                        unset($addressList[$k1]);
                        array_unshift($addressList,$first_one[$k1]);
                    }
                }
            }
            $goodsList = session('cartSession');
            foreach ($goodsList as $k3=>$v3){
                $goodsList[$k3]['delivery_place'] = ShopGoodsQuoteService::getShopGoodsQuoteById($v3['shop_goods_quote_id'])['delivery_place'];
            }
            return $this->display('web.goods.confirmOrder',compact('invoicesInfo','invoicesList','addressList','goodsList'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //确认提交订单
    public function createOrder(Request $request){

        $info = session('_curr_deputy_user');

        $userIds = [];
        // 判断是否为企业用户
        if($info['is_firm']){
            $userInfo = UserService::getInfo($info['firm_id']);
            $userIds['user_id'] = session('_web_user_id');
            $userIds['firm_id'] = $info['firm_id'];
        }else{
            $userInfo = session('_web_user');
            $userIds['user_id'] = session('_web_user_id');
            $userIds['firm_id'] = '';
        }
        $words = $request->input('words',' ');

        // 判断是否有开票信息 地址可用
        $invoicesList = GoodsService::getInvoices($userInfo['id']);
        $addressList = UserAddressService::getInfoByUserId($userInfo['id']);
        if (empty($invoicesList)){
            return $this->error('无开票信息请前去维护');
        }
        if (empty($addressList)){
            return $this->error('无地址信息请前去维护');
        }

        $carList = session('cartSession');
        $shop_data = [];

        foreach ($carList as $k=>$v){
            if (!isset($shop_data[$v['shop_id']])){
                $shop_data[$v['shop_id']] = $v['shop_id'];
            }
        }
        foreach ($shop_data as $k2=>$v2){
            $shop_data[$v2] = [];
            foreach ($carList as $k3=>$v3){
                if ($k2 == $v3['shop_id']){
                    $shop_data[$v2][]=$v3;
                }
            }
        }
        // 没有默认地址的情况下
        if (empty($userInfo['address_id'])){
            $userInfo['address_id'] = UserAddressService::getInfoByUserId($userInfo['id'])[0]['id'];
        }
        // 没有默认开票的情况下
        if (empty($userInfo['invoice_id'])){
            $userInfo['invoice_id'] = GoodsService::getInvoices($userInfo['id'])[0]['id'];
        }
        try{
            $re=[];
            foreach ($shop_data as $k4=>$v4){
                $re[] =  GoodsService::createOrder($v4,$userIds,$userInfo['address_id'],$userInfo['invoice_id'],$words);
            }
           if (!empty($re)){
               Session::forget('cartSession');
               return $this->success('订单提交成功','',$re);
           } else {
                return $this->error('订单提交失败');
           }
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderSubmission(Request $request)
    {
        $re = $request->input('re','');
        if (!empty($re)){
            $re = json_decode($re);
        } else {
            return $this->error('参数错误');
        }
        return $this->display('web.goods.orderSubmission',['re'=>$re]);
    }


    //购物车多选
    public function checkListen(Request $request){
        $userId = session('_web_user_id');
        $cartIds = $request->input('cartId');
        try{
            GoodsService::checkListen($cartIds);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改购物车数量
    public function editCartNum(Request $request){
        $cartNum = $request->input('cartNum');
        $id = $request->input('id');
        if(!is_numeric($cartNum)){
            return $this->error();
        }
        try{

            GoodsService::editCartNum($id,$cartNum);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //我的订单
    public function orderList(){
        $userId = session('_web_user_id');
        $orderList = GoodsService::orderList($userId);
//        dump($orderList);
        return $this->display('web.order.order',compact('orderList'));
    }

    //审核通过
    public function egis(Request $request){
        $id = $request->input('id');
        try{
            GoodsService::egis($id);
            return $this->success('审核成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //订单取消
    public function orderCancel(Request $request){
        $id = $request->input('id');
        try{
            GoodsService::orderCancel($id);
            return $this->success('取消成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
