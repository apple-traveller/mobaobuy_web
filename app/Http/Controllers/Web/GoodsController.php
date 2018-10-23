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
use Illuminate\Support\Facades\Cache;
use App\Services\SmsService;
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

    //商品列表
    public function goodsList(){
        $goodsList = GoodsService::goodsList();
        return $this->display('web.goods.goodsList',compact('goodsList'));
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
                 return $this->success('加入购物车成功');
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
             GoodsService::addCartGoodsNum($id);
             return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //递减产品数量
    public function reduceCartGoodsNum(Request $request){
        $id = $request->input('id');
        try{
            GoodsService::reduceCartGoodsNum($id);
            return $this->success();
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
                } else {
                    $addressList[$k]['is_default'] ='';
                };
            }
            $goodsList = CartService::getCheckGoodsList($userInfo['id']);

//            $goodsList = session('cartSession');


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
        $user_id = session('_web_user_id');
        $carList = CartService::getCheckGoodsList($user_id);
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
//               $this->redirectTo('/orderSubmission',['123123123']);
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
        $re = $request->input('re');
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
