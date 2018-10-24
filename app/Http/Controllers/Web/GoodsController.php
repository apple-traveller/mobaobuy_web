<?php

namespace App\Http\Controllers\Web;
use App\Repositories\CartRepo;
use App\Services\CartService;
use App\Services\GoodsService;
use App\Services\UserAddressService;
use App\Services\UserInvoicesService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Support\Facades\Session;


class GoodsController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function  index(){

    }

    //产品列表
    public function goodsList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
        $price_bg1 = $request->input("price_bg1",1);
        $orderType = $request->input("orderType","id:asc");
        $condition = [];
        //$userId = session('_web_user_id');//判断用户是否登录
        if(!empty($orderType)){
            $order = explode(":",$orderType);
        }

        if(empty($lowest)&&empty($highest)){
            $condition = [];
        }
        if($lowest=="" && $highest!=""){
            $condition['shop_price|<'] = $highest;
        }
        if($highest=="" && $lowest!=""){
            $condition['shop_price|<'] = $lowest;
        }
        if($lowest!="" && $highest!=""&&$lowest<$highest){
            $condition['shop_price|<'] = $highest;
            $condition['shop_price|>'] = $lowest;
        }
        if($lowest>$highest){
            $condition['shop_price|<'] = $lowest;
        }
        $pageSize = 10;
        $userId = session('_web_user_id');
        $cart_count = GoodsService::getCartCount($userId);
        //积分列表
        $goodList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>[$order[0]=>$order[1]]],$condition);
        return $this->display("web.goods.goodsList",[
            'goodsList'=>$goodList['list'],
            'total'=>$goodList['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'orderType'=>$orderType,
            'cart_count'=>$cart_count,
            'lowest'=>$lowest,
            'highest'=>$highest,
            'price_bg1'=>$price_bg1,
        ]);
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
        $currpage = $request->input("currpage");
        $userId = session('_web_user_id');
        $cart_count = GoodsService::getCartCount($userId);
        $goodList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize' => $pageSize, 'page' => $currpage, 'orderType' => ['add_time' => 'desc']], $condition);
        return $this->display("web.goods.goodsDetail", [
            'good_info' => $good_info,
            'goodsList' => $goodList['list'],
            'total' => $goodList['total'],
            'currpage' => $currpage,
            'pageSize' => $pageSize,
            'id' => $id,
            'shop_id' => $shop_id,
            'cart_count'=>$cart_count
        ]);
    }

    //购物车
    public function cart(Request $request){
        $userId = session('_web_user_id');
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
            foreach ($invoicesList as $k=>$v){
                $invoicesList[$k] = UserInvoicesService::getInvoice($v['id']);
            }
            if (!empty($userInfo['invoice_id'])) {
                $invoicesInfo = UserInvoicesService::getInvoice($userInfo['invoice_id']);
            } else {
                $invoicesInfo = $invoicesList[0];
            }

            // 收货地址列表
            $addressList = UserAddressService::getInfoByUserId($userInfo['id']);

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

    //审核不通过 作废
    public function cancel(Request $request){
        $id = $request->input('id');
        try{
            GoodsService::cancel($id);
            return $this->success('作废成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //订单详情
    public function orderDetails($id){
        try{
            $orderGoodsInfo = GoodsService::orderDetails($id);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
        return $this->display('web.order.orderDetails',compact('orderGoodsInfo'));
    }

    //支付界面
    public function pay(){
//        $payInfo = GoodsService::pay();
        return $this->display('web.order.pay');
    }


    //等待审核界面
    public function waitConfirm(){
        return $this->display('web.order.waitConfirm');
    }

}
