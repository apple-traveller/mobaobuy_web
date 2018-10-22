<?php

namespace App\Http\Controllers\Web;
use App\Services\GoodsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\SmsService;


class GoodsController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function  index(){

    }

    //产品列表
    public function goodsList(){
        $goodsList = GoodsService::goodsList();
        return $this->display('web.goods.goodsList',compact('goodsList'));
    }

    //购物车
    public function cart(Request $request){
        $userId = session('_web_user_id');
        dump($userId);
        dump(session('_curr_deputy_user'));
        dump(session('_web_user'));
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
            try{
                 GoodsService::searchGoodsQuote($userId,$id);
                 return $this->success('加入购物车成功');
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }

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

    //确认订单页面
    public function confirmOrder(Request $request){
        //公司id
        $firmId = session('_web_firm_id');
        //个人id
        $userId = session('_web_user_id');
        //获取发票信息
        try{
            if($firmId){
                $invoicesInfo = GoodsService::getInvoices($firmId);
            }else{
                $invoicesInfo = GoodsService::getInvoices($userId);
            }
            $goodsInfo = session('cartSession');
            //获取收货地
            $addressInfo = GoodsService::showAddress($userId);
            return $this->display('web.goods.confirmOrder',compact('addressInfo','invoicesInfo'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //确认提交订单
    public function createOrder(Request $request){
        $userId = session('_web_user_id');
        $cartInfo = session('cartSession');
        $userAddress = $request->input('address');
        $invoices = $request->input('invoices');

        if(empty($cartInfo)){
            return $this->error('产品信息不存在');
        }
        try{
            GoodsService::createOrder($cartInfo,$userId,$userAddress,$invoices);
//            Session::forget('cartSession');
            return $this->success('订单提交成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

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
        dump($orderList);
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
