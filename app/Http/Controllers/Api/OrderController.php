<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\UserService;
use App\Services\UserRealService;
use App\Services\UserAddressService;
use App\Services\OrderInfoService;
use App\Services\ActivityPromoteService;
use App\Services\ShopGoodsQuoteService;
class OrderController extends ApiController
{
    //订单删除
    public function orderDel(Request $request){
        $id = $request->input('id');
        try{
            OrderInfoService::orderDel($id);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //我的订单
    public function orderList(Request $request)
    {
        $tab_code = $request->input('tab_code', '');
        $order_no = $request->input('order_no');
        $page = $request->input('currpage', 1);
        $page_size = $request->input('pagesize', 10);
        $firm_id = $this->getDeputyUserInfo($request)['firm_id'];
        $currUser  = $this->getDeputyUserInfo($request);


        $condition['status'] = $tab_code;
        $condition['begin_time'] = $request->input('begin_time');
        $condition['end_time'] = $request->input('end_time');

        if($this->getDeputyUserInfo($request)['is_firm']){
            if($this->getDeputyUserInfo($request)['is_self'] == 0 && $this->getDeputyUserInfo($request)['is_firm'] ){
                $condition['user_id'] = $this->getDeputyUserInfo($request)['user_id'];
                $condition['firm_id'] = $firm_id;
            }else{
                $condition['user_id'] = $firm_id;
                $condition['firm_id'] = $firm_id;
            }
        }else{
            $condition['user_id'] = $firm_id;
            $condition['firm_id'] = 0;
        }

        if(!empty($order_no)){
            $condition['order_sn'] = '%'.$order_no.'%';
        }

        $rs_list = OrderInfoService::getWebOrderList($currUser,$condition, $page, $page_size);

        $data = [
            'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
            'recordsTotal' => $rs_list['total'], //数据总行数
            'recordsFiltered' => $rs_list['total'], //数据总行数
            'data' => $rs_list['list']
        ];

        return $this->success($data, 'success');
    }

    //订单详情
    public function orderDetails(Request $request){
        $order_sn = $request->input('order_sn');
        try{
            $orderDetailsInfo = OrderInfoService::orderDetails($order_sn);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
        return $this->success(compact('orderDetailsInfo'),'success');
    }

    //订单取消
    public function orderCancel(Request $request){
        $id = $request->input('id');
        try{
            OrderInfoService::orderCancel($id);
            return $this->success('取消成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //审核通过
    public function egis(Request $request){
        $id = $request->input('id');
        try{
            OrderInfoService::egis($id);
            return $this->success('审核成功');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //确认收货
    public function orderConfirmTake(Request $request){
        $id = $request->input('id');
        try{
            OrderInfoService::orderConfirmTake($id);
            return $this->success('','success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //各个状态的订单数量
    public function orderStatusCount(Request $request){
        $deputy_user = $this->getDeputyUserInfo($request);
        if($deputy_user['is_firm']){
            if($deputy_user['is_firm'] && $deputy_user['is_self'] == 0){
                $status = OrderInfoService::getOrderStatusCount($deputy_user['user_id'], $deputy_user['firm_id']);
            }else{
                $firm_id = $deputy_user['firm_id'];
                $status = OrderInfoService::getOrderStatusCount($deputy_user['firm_id'], $firm_id);
            }
        }else{
            $status = OrderInfoService::getOrderStatusCount($deputy_user['firm_id'], 0);
        }
        return $this->success($status, 'success');
    }

    //订单确认页面
    public function confirmOrder(Request $request)
    {

        $info = $this->getDeputyUserInfo($request);
        $userInfo = $this->getUserInfo($request);
        $cartSession = Cache::get("cartSession".$userInfo['id']);
        $goodsList = $cartSession['goods_list'];

        $userRealInfo = UserRealService::getInfoByUserId($userInfo['id']);
        if (empty($userRealInfo)){
            return $this->error('您还没有实名认证，不能下单');
        }
        if ($userRealInfo['review_status'] != 1 ){
            return $this->error('您的实名认证还未通过，不能下单');
        }
        if(empty($goodsList)){
            return $this->error('没有对应的商品');
        }


        // 收货地址列表
        $addressList = UserAddressService::getInfoByUserId($userInfo['id']);
        if (!empty($addressList)){
            foreach ($addressList as $k=>$v){
                $addressList[$k] = UserAddressService::getAddressInfo($v['id']);
                if ($v['id'] == $cartSession['address_id']){
                    $addressList[$k]['is_select'] = 1;
                }else{
                    $addressList[$k]['is_select'] ='';
                };
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
        //限时抢购
        if(!empty($id)){
            try{
                ActivityPromoteService::getActivityPromoteById($id);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }

            $goods_amount = $goodsList[0]['account_money'];
            return $this->success(compact('invoiceInfo','addressList','goodsList','goods_amount','id'),'success');
        }else{
            //购物车
            $goods_amount = 0;
            try{
                foreach ($goodsList as $k3=>$v3){
                    $goodsList[$k3]['delivery_place'] = ShopGoodsQuoteService::getShopGoodsQuoteById($v3['shop_goods_quote_id'])['delivery_place'];
                    $goodsList[$k3]['account'] = number_format($v3['goods_price']*$v3['goods_number'],2);
                    $goods_amount += $v3['goods_price']*$v3['goods_number'];
                }
                $goods_amount = number_format($goods_amount,2);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
        return $this->success(compact('invoiceInfo','addressList','goodsList','goods_amount'),'success');
    }

    //生成订单
    public function createOrder(Request $request)
    {
        $info = $this->getDeputyUserInfo($request);
        $userIds = [];
        // 判断是否为企业用户
        if($info['is_firm']){
            //企业用户，企业
            $userInfo = $this->getUserInfo($request);
            $userIds['user_id'] = $this->getUserID($request);
            $userIds['firm_id'] = $info['firm_id'];
        }else{
            //个人
            $userInfo = $this->getUserInfo($request);
            $userIds['user_id'] = $this->getUserID($request);
            $userIds['firm_id'] = '';
        }
        $words = $request->input('words',' ');
        // 判断是否有开票信息 地址可用
        $userRealInfo = UserRealService::getInfoByUserId($userInfo['id']);
        if (empty($userRealInfo)){
            return $this->error('您还没有实名认证，不能下单');
        }
        if ($userRealInfo['review_status'] != 1 ){
            return $this->error('您的实名认证还未通过，不能下单');
        }
        $addressList = UserAddressService::getInfoByUserId($userInfo['id']);
        if (empty($addressList)){
            return $this->error('无地址信息请前去维护');
        }

        // 没有默认地址的情况下
        if (empty($userInfo['address_id'])){
            $userInfo['address_id'] = UserAddressService::getInfoByUserId($userInfo['id'])[0]['id'];
        }
        $user_id = $this->getUserID($request);
        $cartSession = Cache::get("cartSession".$user_id);
        $cartList = $cartSession['goods_list'];
        if($cartSession['address_id'] == ''){
            return $this->error('请选择收货地址');
        }
        //限时抢购下单
        if($cartSession['from'] == 'promote'){
            try{
                $re[] = OrderInfoService::createOrder($cartList,$userIds,$cartSession['address_id'],$words,$cartSession['from']);
                if (!empty($re)){
                    Cache::forget('cartSession'.$user_id);
                    return $this->success($re,'订单提交成功');
                } else {
                    return $this->error('订单提交失败');
                }
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }

        }elseif($cartSession['from'] == 'cart'){
            //购物车下单
            $shop_data = [];
            foreach ($cartList as $k=>$v){
                if (!isset($shop_data[$v['shop_id']])){
                    $shop_data[$v['shop_id']] = $v['shop_id'];
                }
            }

            foreach ($shop_data as $k2=>$v2){
                $shop_data[$v2] = [];
                foreach ($cartList as $k3=>$v3){
                    if ($k2 == $v3['shop_id']){
                        $shop_data[$v2][]=$v3;
                    }
                }
            }
           // dd($shop_data);
            try{
                $re=[];
                foreach ($shop_data as $k4=>$v4){
                    $re[] =  OrderInfoService::createOrder($v4,$userIds,$cartSession['address_id'],$words,$cartSession['from']);
                }
                if (!empty($re)){
                    Cache::forget('cartSession'.$user_id);
                    return $this->success($re,'订单提交成功');
                } else {
                    return $this->error('订单提交失败');
                }
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
    }


    //选择公司
    public function changeDeputy(Request $request)
    {
        $user_id = $request->input('user_id', 0);
        if(empty($user_id)){
            //代表自己
            $info = [
                'is_self' => 1,
                'is_firm' => $this->getUserInfo($request)['is_firm'],
                'firm_id'=> $this->getUserID($request),
                'name' => $this->getUserInfo($request)['nick_name']
            ];
            Cache::put("_api_deputy_user_".$this->getUserID($request), $info, 60*24*1);
            return $this->success($info,'success');
        }else{
            //获取用户所代表的公司
            $firms = UserService::getUserFirms($this->getUserID($request));
            foreach ($firms as $firm){
                if($user_id == $firm['firm_id']){
                    //修改代表信息
                    $firm['is_self'] = 0;
                    $firm['is_firm'] = 1;
                    $firm['firm_id'] = $user_id;
                    $firm['name'] = $firm['firm_name'];
                    Cache::put("_api_deputy_user_".$user_id, $firm, 60*24*1);
                    return $this->success($firm,'success');
                }
            }
            //找不到，清空session
            Cache::forget('_api_user_'.$user_id);
            Cache::forget('_api_deputy_user_'.$user_id);
            return $this->success('','success');
        }
    }

    //获取当前用户所代理的所有公司
    public function getUserFirmList(Request $request)
    {
        $user_id = $this->getUserID($request);
        if($user_id){
            $user_info = $user_info = UserService::getInfo($user_id);
            if(!$user_info['is_firm']){
                $user_info['firms'] = UserService::getUserFirms($user_id);
            }
            return $this->success($user_info,'success');
        }else{
            return $this->error('error');
        }
    }




}