<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-09
 * Time: 11:51
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\FirmUserService;
use App\Services\OrderInfoService;
use App\Services\RegionService;
use App\Services\ShopGoodsQuoteService;
use App\Services\UserInvoicesService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopOrderController extends Controller
{
    /**
     * 商户订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Request $request)
    {
        $currentPage = $request->input("currentPage", 1);
        $order_sn = $request->input('order_sn','');
        $tab_code = $request->input('tab_code','');
        $shop_id = session('_seller_id')['shop_id'];

        $condition = [];
        $condition['is_delete'] = 0;
        $condition['shop_id'] = $shop_id;
        $condition[]['order_status']='!1';
        if (!empty($tab_code)){
            $condition['tab_code'] = $tab_code;
        }
        $pageSize = 10;
        if ($order_sn != "") {
            $condition['order_sn'] = "%" . $order_sn . "%";
        }
        $orders = OrderInfoService::getOrderInfoList(['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['add_time' => 'desc']], $condition);
        $users = UserService::getUsersByColumn([],['id','user_name']);
        return $this->display('seller.order.list', [
            'orders' => $orders['list'],
            'total' => $orders['total'],
            'users' => $users,
            'order_sn' => $order_sn,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'tab_code' => $tab_code
        ]);
    }

    /**
     * 获取各状态的数量
     * @return ShopOrderController|\Illuminate\Http\RedirectResponse
     */
    public function getStatusCount()
    {
        $seller_id = session('_seller_id')['shop_id'];
        $status = OrderInfoService::getOrderStatusCount(0,0,$seller_id);
        if (!empty($status)){
            return $this->success('success','',$status);
        } else {
            return $this->error('error');
        }
    }

    /**
     * 订单详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $shop_id = session('_seller_id')['shop_id'];
        $currentPage = $request->input('currentPage', 1);
        $where = [
            'id' => $id,
            'shop_id' => $shop_id
        ];
        $orderInfo = OrderInfoService::getOrderInfoByWhere($where);

        $region = RegionService::getRegion($orderInfo['country'], $orderInfo['province'], $orderInfo['city'], $orderInfo['district']);
        $order_goods = OrderInfoService::getOrderGoodsByOrderId($orderInfo['id']);//订单商品
        $orderLogs = OrderInfoService::getOrderLogsByOrderid($id);
        if (!empty($orderInfo)){
            $user_invoices = UserInvoicesService::getInvoice($orderInfo['invoice_id']);//发票信息
            if (empty($user_invoices)){
                $user_invoices = [];
            }
        } else {
            $user_invoices = [];
        }
        $user = UserService::getInfo($orderInfo['user_id']);
        if(empty($user)){
            $user = FirmUserService::getFirmInfo($orderInfo['firm_id']);
        }
        return $this->display('seller.order.detail', [
            'currentPage' => $currentPage,
            'orderInfo' => $orderInfo,
            'user' => $user,
            'region' => $region,
            'order_goods' => $order_goods,
            'user_invoices' => $user_invoices,
            'orderLogs' => $orderLogs
        ]);
    }

    /**
     * 订单确认
     * @param Request $request
     * @return ShopOrderController|\Illuminate\Http\RedirectResponse
     */
    public function updateOrderStatus(Request $request)
    {
        $shop_id = session('_seller_id')['shop_id'];
        $id = $request->input('id', '');
        $order_status = $request->input('order_status', '');
        $pay_status = $request->input('pay_status','');
        $action_note = $request->input('action_note', '');
        $delivery_period = $request->input('delivery_period','');
        $where = [
            'id' => $id,
            'shop_id' => $shop_id
        ];
        // 判断订单是否存在
        try {
            $orderInfo = OrderInfoService::getOrderInfoByWhere($where);
            if ($order_status ==3){
                if ($orderInfo['extension_code'] == ''){
                    $re_rock =  ShopGoodsQuoteService::updateStock($id);
                    if (!$re_rock){
                        return $this->error('库存不足，无法确认');
                    }
                }
                if ($orderInfo['order_status'] !=2){
                    return $this->error('订单状态不符合执行该操作的条件');
                }
            }
            if (!empty($orderInfo)) {
                $data = [
                    'id' => $id,
                    'confirm_time' => Carbon::now()
                ];
                // 交货时间
                if (!empty($delivery_period)){
                    $data['delivery_period'] = $delivery_period;
                }
                if (!empty($order_status)){
                    $data['order_status'] = $order_status;
                }
                if (!empty($pay_status)){
                    $data['pay_status'] = $pay_status;
                    // 已收款&&已收货 变更订单 待开票
                    if ($pay_status==1 && $orderInfo['shipping_status']==3){
                        $data['order_status'] = 5;
                    }
                }
                $re = OrderInfoService::modify($data);

                if (!empty($re)) {
                    if(empty($action_note)){
                        $action_note = "修改订单状态";
                    }
                    //存储日志信息
                    $logData = [
                        'action_note' => $action_note,
                        'action_user' => session('_seller')['user_name'],
                        'order_id' => $id,
                        'order_status' => $re['order_status'],
                        'shipping_status' => $re['shipping_status'],
                        'pay_status' => $re['pay_status'],
                        'log_time' => Carbon::now()
                    ];
                    if (!empty($order_status)){
                        $logData['order_status'] = $order_status;
                    } else {
                        $logData['pay_status'] = $pay_status;
                    }
                    OrderInfoService::createLog($logData);
                    return $this->success('修改成功', url('/seller/order/list'));
                }
            } else {
                return $this->error('订单信息错误，或订单不存在', url('/seller/order/list'));
            }
        }catch (\Exception $e){
            return $this->error('订单信息错误，或订单不存在', url('/seller/order/list'));
        }
    }

    /**
     * 修改商家留言
     * @param Request $request
     * @return ShopOrderController|\Illuminate\Http\RedirectResponse
     */
    public function toBuyerModify(Request $request)
    {
        $shop_id = session('_seller_id')['shop_id'];
        $id = $request->input('id', '');
        $toBuyer = $request->input('to_buyer', '');

        if (!$id && $shop_id) {
            return $this->error('参数错误');
        }

        $where = [
            'id' => $id,
            'shop_id' => $shop_id
        ];
        // 判断订单是否存在
        $orderInfo = OrderInfoService::getOrderInfoByWhere($where);

        $data = [
            'id' => $id,
            'to_buyer' => $toBuyer
        ];
        if (!empty($orderInfo)) {
            $re = OrderInfoService::modify($data);
            if ($re) {
                return $this->success('修改成功');
            }
        } else {
            return $this->error('订单信息不存在,请刷新');
        }

    }

    /**
     * 修改自动确认收获的天数
     * @param Request $request
     * @return ShopOrderController
     */
    public function modifyReceiveDate(Request $request)
    {
        $data = [
            'id'=>$request->input('id'),
            'auto_delivery_time'=>$request->input('val'),
        ];
        try{
            $flag = OrderInfoService::modify($data);
            return $this->result($flag['auto_delivery_time'],200,'修改成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改订单中商品信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modifyGoodsInfo(Request $request)
    {
        $id = $request->input('id');
        $currentPage = $request->input('currentPage');
        $orderGoods = OrderInfoService::getOrderGoodsByOrderId($id);
        $goods_amount = OrderInfoService::getOrderInfoById($id)['goods_amount'];
        return $this->display('seller.order.goods',[
            'orderGoods'=>$orderGoods,
            'currentPage'=>$currentPage,
            'id'=>$id,
            'goods_amount' => $goods_amount
        ]);
    }

    /**
     * 修改订单商品信息
     * @param Request $request
     * @return ShopOrderController|\Illuminate\Http\RedirectResponse
     */
    public function saveGoods(Request $request)
    {
        $id = $request->input('id','');
        $goods_price = $request->input('goods_price','');
        $order_id = $request->input('order_id','');
        $goods_number = $request->input('goods_number','');
        $currentPage = $request->input('currentPage',1);
        $data = [
            'id' => $id
        ];
       if ($goods_price){
           $data['goods_price'] = $goods_price;
       }
       if ($goods_number){
           $data['goods_number'] = $goods_number;
       }
        try{
            $info = OrderInfoService::modifyOrderGoods($data);
            OrderInfoService::modifyGoodsAmount($order_id);
            if(!$info){
                return $this->error('更新失败');
            }
            return $this->success("/seller/order/modifyGoodsInfo?id=".$order_id."&currentPage=".$currentPage,200);
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }


    /**
     * 维护运费 & 折扣
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modifyFree(Request $request)
    {
        $id = $request->input('id');
        $currentPage = $request->input('currentPage','1');
        $feeInfo = OrderInfoService::getFeeInfo($id);
        return $this->display('seller.order.free',[
            'feeInfo'=>$feeInfo,
            'currentPage'=>$currentPage,
            'id'=>$id
        ]);
    }

    /**
     * 保存运费 & 折扣
     * @param Request $request
     * @return ShopOrderController|\Illuminate\Http\RedirectResponse
     */
    public function saveFree(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $currentPage = $data['currentPage'];
        unset($data['currentPage']);
        try{
            $info = OrderInfoService::modify($data);
            OrderInfoService::modifyGoodsAmount($id);
            if(!$info){
                return $this->error('更新失败');
            }
            return $this->success('更新成功',"/seller/order/detail?id=".$id."&currentPage=".$currentPage);
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    /**
     * 生成发货单页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delivery(Request $request)
    {
        $currentPage = $request->input('currentPage');
        $order_id = $request->input('order_id');
        //查询所有的快递信息
        $shippings = OrderInfoService::getShippingList();
        //查询该订单的所有商品信息
        $orderGoods = OrderInfoService::getOrderGoodsByOrderId($order_id);

        return $this->display('seller.order.delivery',[
            'shippings'=>$shippings,
            'currentPage'=>$currentPage,
            'orderGoods'=>$orderGoods,
            'id'=>$order_id
        ]);
    }

    /**
     * 为发货订单提供商品接口
     * @param Request $request
     * @return string
     */
    public function orderGoods(Request $request)
    {
        $order_id = $request->input('order_id');
        $orderGoods = OrderInfoService::getOrderGoodsList($order_id);
        return json_encode(['count'=>$orderGoods['total'],'data'=>$orderGoods['list'],'code'=>0,'msg'=>'']);
    }

    /**
     * 生成发货单 订单商品数量在此处修改
     * @param Request $request
     * @return ShopOrderController|\Illuminate\Http\RedirectResponse
     */
    public function saveDelivery(Request $request)
    {
        $data = $request->all();
        $order_id = $request->input('order_id');
        $orderInfo = OrderInfoService::getOrderInfoById($order_id);

        if ($orderInfo['pay_type'] == 1 && $orderInfo['pay_status'] != 1){
            return $this->error('未付全款无法生成发货单');
        }
        unset($data['layTableCheckbox']);
        $orderDeliveryGoodsData = json_decode($data['send_number_delivery'],true);
        $order_delivery_goods_data = []; //发货单商品信息
        foreach($orderDeliveryGoodsData as $k=>$v){
            $order_delivery_goods_data[$k]['order_goods_id'] = $v['id'];
            $order_delivery_goods_data[$k]['shop_goods_id'] = $v['shop_goods_id'];
            $order_delivery_goods_data[$k]['shop_goods_quote_id'] = $v['shop_goods_quote_id'];
            $order_delivery_goods_data[$k]['goods_id'] = $v['goods_id'];
            $order_delivery_goods_data[$k]['goods_name'] = $v['goods_name'];
            $order_delivery_goods_data[$k]['goods_sn'] = $v['goods_sn'];
            if(!empty($v['send_number_delivery']) && $v['send_number_delivery']>$v['goods_number']-$v['send_number']){
                return $this->error('发货数量不能大于剩余商品数量');
            }
            $order_delivery_goods_data[$k]['send_number'] = empty($v['send_number_delivery'])?0:$v['send_number_delivery'];
        }
        $order_delivery = [];//发货单信息
        $orderInfo = OrderInfoService::getOrderInfoById($order_id);
        $order_delivery_data['delivery_sn'] = $this->microtime_float()['mi'];
        $order_delivery_data['order_id'] = $order_id;
        $order_delivery_data['order_sn'] = $orderInfo['order_sn'];
        $order_delivery_data['add_time'] = Carbon::now();
        $order_delivery_data['shipping_id'] = $data['shipping_id'];
        $order_delivery_data['shipping_name'] = $data['shipping_name'];
        $order_delivery_data['shipping_billno'] = $data['shipping_billno'];
        $order_delivery_data['user_id'] = $orderInfo['user_id'];
        $order_delivery_data['firm_id'] = $orderInfo['firm_id'];
        $order_delivery_data['shop_id'] = $orderInfo['shop_id'];
        $order_delivery_data['shop_name'] = $orderInfo['shop_name'];
        $order_delivery_data['action_user'] = session()->get('_admin_user_info')['real_name'];
        $order_delivery_data['consignee'] = $orderInfo['consignee'];
        $order_delivery_data['address'] = $orderInfo['address'];
        $order_delivery_data['country'] = $orderInfo['country'];
        $order_delivery_data['province'] = $orderInfo['province'];
        $order_delivery_data['city'] = $orderInfo['city'];
        $order_delivery_data['district'] = $orderInfo['district'];
        $order_delivery_data['street'] = $orderInfo['street'];
        $order_delivery_data['zipcode'] = $orderInfo['zipcode'];
        $order_delivery_data['mobile_phone'] = $orderInfo['mobile_phone'];
        $order_delivery_data['postscript'] = $orderInfo['postscript'];
        $order_delivery_data['update_time'] = Carbon::now();
        $order_delivery_data['status'] = 0;
        //dd($order_delivery_data);
        try{
            $orderDelivery = OrderInfoService::createDelivery($order_delivery_goods_data,$order_delivery_data);
            if(!empty($orderDelivery)){
                return $this->success('生成发货单成功',url('/seller/order/list?tab_code=waitSend'));
            }
            return $this->error('生成发货单失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改订单支付方式
     * @param Request $request
     * @return ShopOrderController|\Illuminate\Http\RedirectResponse
     */
    public function updatePayType(Request $request){
        $order_id = $request->input('order_id','');
        $type = $request->input('type','');
        if (empty($order_id) || empty($type)){
            return $this->error('参数错误');
        }

        // 查询该订单是否存在
        $orderInfo = OrderInfoService::getOrderInfoById($order_id);
        if (empty($orderInfo)){
            return $this->error('出现了意想不到的错误');
        }
        if ($orderInfo['order_status']>=3){
            return $this->error('订单已确认，无法更改收款方式');
        }
        $data = [
            'id'=>$order_id,
            'pay_type' =>$type
        ];

        $re = OrderInfoService::modify($data);

        if ($re){
            return $this->success('修改成功');
        } else {
            return $this->error('修改失败');
        }
    }

    public function microtime_float()
    { /* 微秒 */
        list($usec, $sec) = explode(' ', microtime()); /* 非科学计数法 */
        return array('ms' => microtime(true) * 10000, 'mi' => sprintf("%.0f", ((float)$usec + (float)$sec) * 100000000),);
    }
}
