<?php

namespace App\Http\Controllers\Web;
use App\Services\GoodsService;
use App\Services\UserAddressService;
use App\Services\UserRealService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * cart
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function cart(Request $request){
        $userId = session('_web_user_id');
        if(session('_curr_deputy_user')['is_firm']){
            $userId = session('_curr_deputy_user')['firm_id'];
        }

        $invoiceInfo = UserRealService::getInfoByUserId($userId);
        if (empty($invoiceInfo)){
            return $this->error('当前用户还没有实名认证，不能下单');
        }
        if ($invoiceInfo['review_status'] != 1 ){
            return $this->error('当前用户实名认证还未通过，不能下单');
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

    /**
     * 删除购物车信息
     * delCart
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delCart(Request $request){
        $id = $request->input('id');
        try{
            GoodsService::delCart($id);
            return $this->success();
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 递加产品数量
     * addCartGoodsNum
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addCartGoodsNum(Request $request){
        $id = $request->input('id');
        try{
             $account = GoodsService::addCartGoodsNum($id);
             return $this->success('','',$account);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 递减产品数量
     * reduceCartGoodsNum
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse]
     */
    public function reduceCartGoodsNum(Request $request){
        $id = $request->input('id');
        try{
            $account = GoodsService::reduceCartGoodsNum($id);
            return $this->success('','',$account);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 清空购物车
     * clearCart
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function clearCart(){
        $userId = session('_web_user_id');
        try{
            GoodsService::clearCart($userId);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 购物车 去结算
     * toBalance
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function toBalance(Request $request){
        $cartIds = $request->input('cartId');
        $userInfo = session('_web_user');
        try{
            $goods_list = GoodsService::toBalance($cartIds,$userInfo['id']);
            //判断是否有默认地址如果有 则直接赋值 没有则取出一条
            $address_id = UserAddressService::getOneAddressId();
            //进入订单确认页面前先定义购物车session
            $cartSession = [
                'goods_list'=>$goods_list,
                'address_id'=> $address_id,
                'from'=>'cart'
            ];

            session()->put('cartSession',$cartSession);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 选择订单收货地址
     * editOrderAddress
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editOrderAddress(Request $request)
    {
        $address_id = $request->input('address_id','');
        if(!$address_id){
            return $this->error('缺少参数地址ID！');
        }
        $address_info = UserAddressService::getAddressInfo($address_id);
        if(!$address_info){
            return $this->error('地址信息不存在！');
        }
        $cartSession = session('cartSession');
        $cartSession['address_id'] = $address_id;

        session()->put('cartSession',$cartSession);
        return $this->success('选择成功');
    }

    /**
     * 购物车多选
     * checkListen
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * 购物车input判断
     * checkListenCartInput
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function checkListenCartInput(Request $request){
        $id = $request->input('id');
        $goodsNumber = $request->input('goodsNumber');


        try{
            $goods_number = GoodsService::checkListenCartInput($id,$goodsNumber);
            return $this->success('','',$goods_number);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改购物车数量
     * editCartNum
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
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
        return $this->display('web.order.order',compact('orderList'));
    }
}
