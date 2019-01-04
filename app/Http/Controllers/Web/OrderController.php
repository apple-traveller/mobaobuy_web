<?php

namespace App\Http\Controllers\Web;

use App\Services\ActivityPromoteService;
use App\Services\ActivityWholesaleService;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use App\Services\OrderInfoService;
use App\Services\ShopGoodsQuoteService;
use App\Services\UserAddressService;
use App\Services\UserRealService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    //我的订单
    public function orderList(Request $request)
    {
        //
        $tab_code = $request->input('tab_code', '');

        if ($request->isMethod('get')) {
            return $this->display('web.user.order.list', compact('tab_code'));
        } else {
            $page = $request->input('start', 0) / $request->input('length', 5) + 1;
            $page_size = $request->input('length', 5);
            $firm_id = session('_curr_deputy_user')['firm_id'];
            $currUser = session('_curr_deputy_user');
            $order_no = $request->input('order_no');

            $condition['status'] = $tab_code;
            $condition['begin_time'] = $request->input('begin_time');
            $condition['end_time'] = $request->input('end_time');

            if (session('_curr_deputy_user')['is_firm']) {
//                    $condition['user_id'] = $firm_id;
                    $condition['firm_id'] = $firm_id;
            } else {
                $condition['user_id'] = $firm_id;
                $condition['firm_id'] = 0;
            }

            if (!empty($order_no)) {
                $condition['order_sn'] = '%' . $order_no . '%';
            }

            $rs_list = OrderInfoService::getWebOrderList($currUser, $condition, $page, $page_size);

            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $rs_list['total'], //数据总行数
                'recordsFiltered' => $rs_list['total'], //数据总行数
                'data' => $rs_list['list']
            ];

            return $this->success('', '', $data);
        }
    }

    public function orderStatusCount()
    {

        $deputy_user = session('_curr_deputy_user');
        if ($deputy_user['is_firm']) {
            $status = OrderInfoService::getOrderStatusCount('', $deputy_user['firm_id']);
        } else {
            //个人
            $status = OrderInfoService::getOrderStatusCount($deputy_user['firm_id'], 0);
        }
        return $this->success('', '', $status);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rule = [
            'cat_name' => 'required|unique:goods_category',
            'parent_id' => 'required|numeric',
            'is_nav_show' => 'required|numeric',
            'is_show' => 'required|numeric',
            'category_links' => 'required',
            'cat_alias_name' => 'nulleric'
        ];
        $data = $this->validate($request, $rule);
        try {
            GoodsCategoryService::categoryCreate($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $id = $request->input('id');
        $rule = [
            'cat_name' => 'required|unique:goods_category',
            'parent_id' => 'required|numeric',
            'is_nav_show' => 'numeric',
            'is_show' => 'required|numeric',
            'category_links' => 'nullable',
            'cat_alias_name' => 'nullable'
        ];
        $data = $this->validate($request, $rule);
        try {
            GoodsCategoryService::categoryUpdate($id, $data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        GoodsCategoryService::delete($id);
    }

    //订单删除
    public function orderDel(Request $request)
    {
        $id = $request->input('id');
        try {
            OrderInfoService::orderDel($id);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //订单详情
    public function orderDetails($id)
    {
        $firmId = session('_curr_deputy_user')['firm_id'];
        try {
            $orderDetailsInfo = OrderInfoService::orderDetails($id,$firmId);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        if($orderDetailsInfo){
            return $this->display('web.user.order.orderDetails', compact('orderDetailsInfo'));
        }else{
            return $this->redirect('/order/list');
        }
    }

    //审核通过
    public function egis(Request $request)
    {
        $id = $request->input('id');
        try {
            OrderInfoService::egis($id);
            return $this->success('审核成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //订单取消
    public function orderCancel(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('waitAffirm');
        try {
            OrderInfoService::orderCancel($id,$type);
            return $this->success('取消成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //确认收货
    public function orderConfirmTake(Request $request)
    {
        $firmUser = session('_curr_deputy_user');

        if($firmUser['is_firm'] && $firmUser['is_self'] == 0){
            $userId = $firmUser['user_id'];
        }else{
            $userId = $firmUser['firm_id'];
        }

        $id = $request->input('id');
        try {
            OrderInfoService::orderConfirmTake($id,$firmUser['firm_id'],$userId);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    //确认订单页面
    public function confirmOrder(Request $request, $id = '')
    {
        $info = session('_curr_deputy_user');
        $userInfo = session('_web_user');
        $cartSession = session('cartSession');
        $goodsList = $cartSession['goods_list'];
        $from = $cartSession['from'];
        if(empty($cartSession) || !isset($cartSession) || empty($goodsList)){
             return $this->redirect('/cart');
        }

        $invoiceInfo = UserRealService::getInfoByUserId($info['firm_id']);
        if (empty($invoiceInfo)){
            return $this->error('您还没有实名认证，不能下单');
        }
        if ($invoiceInfo['review_status'] != 1) {
            return $this->error('您的实名认证还未通过，不能下单');
        }


        //取地址信息的时候 要先判断是否是以公司职员的身份为公司下单 是则取公司账户的地址
        if ($info['is_self'] == 0 && $info['is_firm'] == 1) {
            $u_id = $info['firm_id'];
            $address_id = $info['address_id'] ? $info['address_id'] : 0;
        }else{
            $u_id = $userInfo['id'];
            $address_id = $userInfo['address_id'] ? $userInfo['address_id'] : 0;
        }

        // 收货地址列表
        $addressList = UserAddressService::getInfoByUserId($u_id);
        if (!empty($addressList)) {
            foreach ($addressList as $k => $v) {
                $addressList[$k] = UserAddressService::getAddressInfo($v['id']);
                if ($v['id'] == $cartSession['address_id']) {
                    $addressList[$k]['is_select'] = 1;
                } else {
                    $addressList[$k]['is_select'] = '';
                };
                if ($v['id'] == $address_id) {
                    $addressList[$k]['is_default'] = 1;
                    $first_one[$k] = $addressList[$k];
                } else {
                    $addressList[$k]['is_default'] = '';
                };

            }
            if (!empty($first_one)) {
                foreach ($first_one as $k1 => $v1) {
                    unset($addressList[$k1]);
                    array_unshift($addressList, $first_one[$k1]);
                }
            }
        }


        if ($from == 'promote') {//限时抢购
            try {
                ActivityPromoteService::getActivityPromoteById($id);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }

            $goods_amount = $goodsList[0]['account_money'];
            return $this->display('web.goods.confirmOrder', compact('invoiceInfo', 'addressList', 'goodsList', 'goods_amount', 'id'));

        } elseif ($from == 'wholesale') {//集采火拼

            try {
                ActivityWholesaleService::getActivityWholesaleById($id);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }

            $goods_amount = $goodsList[0]['amount'];
            $deposit = $goodsList[0]['deposit'];
            return $this->display('web.goods.confirmWholesaleOrder', compact('invoiceInfo', 'addressList', 'goodsList', 'goods_amount', 'id', 'deposit'));

        } elseif ($from == 'consign') {//清仓特卖

            $goods_amount = 0;
            try {
                foreach ($goodsList as $k3 => $v3) {
//                    dd($v3);
                    $goodsList[$k3]['delivery_place'] = ShopGoodsQuoteService::getShopGoodsQuoteById($v3['id'])['delivery_place'];
                    $goodsList[$k3]['account'] = number_format($v3['shop_price'] * $v3['goods_number'], 2);
                    $goods_amount += $v3['shop_price'] * $v3['goods_number'];
                }
//                $goods_amount = number_format($goods_amount, 2);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            return $this->display('web.goods.confirmOrder', compact('invoiceInfo', 'addressList', 'goodsList', 'goods_amount'));
        } else {
            //购物车
            $goods_amount = 0;
            try {
                foreach ($goodsList as $k3 => $v3) {
                    $goodsList[$k3]['delivery_place'] = ShopGoodsQuoteService::getShopGoodsQuoteById($v3['shop_goods_quote_id'])['delivery_place'];
                    $goodsList[$k3]['account'] = number_format($v3['goods_price'] * $v3['goods_number'], 2);
                    $goods_amount += $v3['goods_price'] * $v3['goods_number'];
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return $this->display('web.goods.confirmOrder', compact('invoiceInfo', 'addressList', 'goodsList', 'goods_amount'));
    }

    //创建订单
    public function createOrder(Request $request)
    {
        $info = session('_curr_deputy_user');
        $userIds = [];
        $userIds['user_name'] = session('_web_user')['user_name'];
        // 判断是否为企业用户
        if ($info['is_firm']) {
            //企业用户，企业
            $userInfo = $info;
            $userIds['user_id'] = session('_web_user')['id'];
            $userIds['firm_id'] = $info['firm_id'];
            $userIds['need_approval'] = session('_web_user')['need_approval'];
            $u_id = $info['firm_id'];

            //短信 type
            $smsType = '企业';
        } else {
            //个人
            $userInfo = session('_web_user');
            $userIds['user_id'] = $userInfo['id'];
            $userIds['firm_id'] = '';
            $u_id = $userInfo['id'];

            //短信 type
            $smsType = '个人';
        }
        $words = $request->input('words', ' ');
        // 判断是否有开票信息 地址可用
        $invoiceInfo = UserRealService::getInfoByUserId($userIds['user_id']);
        if (empty($invoiceInfo)) {
            return $this->error('您还没有实名认证，不能下单');
        }
        if ($invoiceInfo['review_status'] != 1) {
            return $this->error('您的实名认证还未通过，不能下单');
        }
        $addressList = UserAddressService::getInfoByUserId($u_id);
        if (empty($addressList)) {
            return $this->error('无地址信息请前去维护');
        }

        $cartSession = session('cartSession');
        $carList = $cartSession['goods_list'];
        if ($cartSession['address_id'] == '') {
            return $this->error('请选择收货地址');
        }
        //限时抢购下单
        if ($cartSession['from'] == 'promote') {
            try {
                $re[] = OrderInfoService::createOrder($carList, $userIds, $cartSession['address_id'], $words, $cartSession['from'],$smsType);
                if (!empty($re)) {

                    Session::forget('cartSession');
                    return $this->success('订单提交成功', '', $re);
                } else {
                    return $this->error('订单提交失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }

        } elseif ($cartSession['from'] == 'wholesale') {

            try {
                $re[] = OrderInfoService::createOrder($carList, $userIds, $cartSession['address_id'], $words, $cartSession['from'],$smsType);
                if (!empty($re)) {
                    Session::forget('cartSession');
                    return $this->success('订单提交成功', '', $re);
                } else {
                    return $this->error('订单提交失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }

        } else {
            //购物车下单
            $shop_data = [];
            foreach ($carList as $k => $v) {
                if (!isset($shop_data[$v['shop_id']])) {
                    $shop_data[$v['shop_id']] = $v['shop_id'];
                }
            }
            foreach ($shop_data as $k2 => $v2) {
                $shop_data[$v2] = [];
                foreach ($carList as $k3 => $v3) {
                    if ($k2 == $v3['shop_id']) {
                        $shop_data[$v2][] = $v3;
                    }
                }
            }

            try {
                $re = [];
                foreach ($shop_data as $k4 => $v4) {
                    $re[] = OrderInfoService::createOrder($v4, $userIds, $cartSession['address_id'], $words, $cartSession['from'],$smsType);
                }
                if (!empty($re)) {
                    Session::forget('cartSession');
                    return $this->success('订单提交成功', '', $re);
                } else {
                    return $this->error('订单提交失败');
                }
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }


    }



    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderSubmission(Request $request)
    {
        $re = $request->input('re', '');
        if (!empty($re)) {
            $re = json_decode($re);
        } else {
            return $this->error('参数错误');
        }
        return $this->display('web.user.order.orderSubmission', ['re' => $re]);
    }


}
