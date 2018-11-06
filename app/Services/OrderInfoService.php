<?php
namespace App\Services;
use App\Repositories\OrderInfoRepo;
use App\Repositories\OrderGoodsRepo;
use App\Repositories\RegionRepo;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\UserInvoicesRepo;
use App\Repositories\OrderActionLogRepo;
use App\Repositories\ShippingRepo;
use App\Repositories\OrderDeliveryRepo;
use App\Repositories\OrderDeliveryGoodsRepo;
use App\Repositories\UserRepo;
class OrderInfoService
{
    use CommonService;

    //列表（分页）
    public static function getOrderInfoList($pager, $condition)
    {
        return OrderInfoRepo::getListBySearch($pager, $condition);
    }

    //获取分页订单列表
    public static function getWebOrderList($currUser,$condition, $page = 1 ,$pageSize=10){
        $condition['is_delete'] = 0;

        $condition = array_merge($condition, self::setStatueCondition($condition['status']));
        unset($condition['status']);

        if(!empty($condition['begin_time'])){
            $condition['add_time|>='] = $condition['begin_time'] . ' 00:00:00';
        }
        unset($condition['begin_time']);
        if (!empty($condition['end_time'])) {
            $condition['add_time|<='] = $condition['end_time'] . ' 23:59:59';
        }
        unset($condition['end_time']);

        $orderList = OrderInfoRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['add_time'=>'desc']],$condition);

        //企业会员权限
        if($currUser['is_firm']){

            if($condition['firm_id'] && $currUser['is_self'] == 0){

                $currUserAuth = FirmUserService::getAuthByCurrUser($condition['firm_id'],$currUser['user_id']);
            }
        }

        foreach ($orderList['list'] as $k=>&$item){
            $item['status'] = self::getOrderStatusName($item['order_status'],$item['pay_status'],$item['shipping_status']);
            $item['goods'] = self::getOrderGoodsByOrderId($item['id']);
            $item['deliveries'] = OrderDeliveryRepo::getList([], ['order_id'=>$item['id'], 'status'=>1], ['id','shipping_name','shipping_billno']);

            //企业
            if($condition['firm_id'] == $currUser['firm_id'] && $currUser['is_self']){
                if($item['order_status'] == 0){
                    $orderList['list'][$k]['auth'][] = 'can_del';
                    $orderList['list'][$k]['auth_desc'][] = '删除';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderDel('.$item['id'].')"';
                }
                if($item['order_status'] == 1){
                    $orderList['list'][$k]['auth'][] = 'can_approval';
                    $orderList['list'][$k]['auth'][] = 'can_cancel';
                    $orderList['list'][$k]['auth_desc'][] = '审批';
                    $orderList['list'][$k]['auth_desc'][] = '取消';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderApproval('.$item['id'].')"';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                }
                if($item['order_status'] == 2){
                    $orderList['list'][$k]['auth'][] = 'can_cancel';
                    $orderList['list'][$k]['auth'][] = 'wait_Confirm';
                    $orderList['list'][$k]['auth_desc'][] = '取消';
                    $orderList['list'][$k]['auth_desc'][] = '待商家确认';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                    $orderList['list'][$k]['auth_html'][] = '';
                }

                if($item['order_status'] == 3){
                    if($item['pay_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_pay';
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '去支付';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_html'][] = 'href="http://'.$_SERVER['SERVER_NAME'].'/payment?order_id='.$item['id'].'"';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                    }elseif($item['pay_status'] == 1){
                        $orderList['list'][$k]['auth'][] = 'can_confirm';
                        $orderList['list'][$k]['auth_desc'][] = '待确认收货';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="confirmTake('.$item['id'].')"';
                    }
                }
            }

            //企业会员
            if($condition['firm_id'] != $currUser['firm_id'] && $currUser['is_firm'] == 1){
//                dump('企业会员');
                if($currUserAuth){
                    //已作废订单
                    if($item['order_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_del';
                        $orderList['list'][$k]['auth_desc'][] = '删除';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderDel('.$item['id'].')"';
                    }
                    //待企业审核订单
                    if($item['order_status'] == 1){
                        if($currUserAuth['can_can_approval']){
                            $orderList['list'][$k]['auth'][] = 'can_approval';
                            $orderList['list'][$k]['auth_desc'][] = '审批';
                            $orderList['list'][$k]['auth_html'][] = 'onclick="orderApproval('.$item['id'].')"';
                        }else{
                            $orderList['list'][$k]['auth'][] = 'wait_approval';
                            $orderList['list'][$k]['auth_desc'][] = '待审批';
                            $orderList['list'][$k]['auth_html'][] = '';
                        }

                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                    }
                    //待商家确认
                    if($item['order_status'] == 2){
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth'][] = 'wait_Confirm';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_desc'][] = '待商家确认';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                        $orderList['list'][$k]['auth_html'][] = '';
                    }
                    //已确认
                    if($item['order_status'] == 3){
                        if($item['pay_status'] == 0 && $currUserAuth[0]['can_pay']){
                            $orderList['list'][$k]['auth'][] = 'can_pay';
                            $orderList['list'][$k]['auth'][] = 'can_cancel';
                            $orderList['list'][$k]['auth_desc'][] = '去支付';
                            $orderList['list'][$k]['auth_desc'][] = '取消';
                            $orderList['list'][$k]['auth_html'][] = 'href="http://'.$_SERVER['SERVER_NAME'].'/payment?order_id='.$item['id'].'"';
                            $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                        }
                        if($item['pay_status'] == 1 && $currUserAuth[0]['can_confirm']){
                            $orderList['list'][$k]['auth'][] = 'can_confirm';
                            $orderList['list'][$k]['auth_desc'][] = '待确认收货';
                            $orderList['list'][$k]['auth_html'][] = 'onclick="confirmTake('.$item['id'].')"';
                        }
                    }
                }
            }

            //个人
            if($currUser['is_firm'] == 0){
                //个人
                if($item['order_status'] == 0){
                    $orderList['list'][$k]['auth'][] = 'can_del';
                    $orderList['list'][$k]['auth_desc'][] = '删除';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderDel('.$item['id'].')"';
                }

                if($item['order_status'] == 2){
                    $orderList['list'][$k]['auth'][] = 'can_cancel';
                    $orderList['list'][$k]['auth'][] = 'wait_Confirm';
                    $orderList['list'][$k]['auth_desc'][] = '取消';
                    $orderList['list'][$k]['auth_desc'][] = '待商家确认';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                    $orderList['list'][$k]['auth_html'][] = '';
                }
                if($item['order_status'] == 3){
                    if($item['pay_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_pay';
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '去支付';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_html'][] = 'href="http://'.$_SERVER['SERVER_NAME'].'/payment?order_id='.$item['id'].'"';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                    }elseif($item['pay_status'] == 1){
                        $orderList['list'][$k]['auth'][] = 'can_confirm';
                        $orderList['list'][$k]['auth_desc'][] = '确认收货';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="confirmTake('.$item['id'].')"';
                    }
                }


            }
            if($item['order_status'] == 4){
                $orderList['list'][$k]['auth'][] = 'finish';
                $orderList['list'][$k]['auth_desc'][] = '已完成';
                $orderList['list'][$k]['auth_html'][] = '';
            }

            if($item['order_status'] == 5){
                $orderList['list'][$k]['auth'][] = 'wait_invoice';
                $orderList['list'][$k]['auth_desc'][] = '申请开票';
                $orderList['list'][$k]['auth_html'][] = 'href="/invoice"';
            }

        }

        return $orderList;
    }
    //得到对应的权限
    private static function getFirmUserAuth($userId,$auth){

    }

    private static function getOrderStatusName($order_status, $pay_status, $shipping_status){
        $status = '';
        switch ($order_status){
            case 0: $status = '已作废';break;
            case 1: $status = '待审批';break;
            case 2: $status = '待确认';break;
            case 3: $status = '已确认';break;
            case 4: $status = '已完成';break;
            case 5: $status = '待开票';break;
        }

        if($order_status > 0 && $order_status <> 4){
            switch ($pay_status){
                case 0: $status .= ', 未付款';break;
                case 1: $status .= ', 已付款';break;
                case 2: $status .= ', 部分付款';break;
            }

            switch ($shipping_status){
                case 0: $status .= ', 未发货';break;
                case 1: $status .= ', 已发货';break;
                case 2: $status .= ', 部分发货';break;
                case 3: $status .= ', 已收货';break;
            }
        }
        return $status;
    }

    private static function setStatueCondition($status_code){
        $condition = [];
        switch ($status_code){
            case 'waitApproval':
                $condition['order_status'] = 1;break;
            case 'waitAffirm':
                $condition['order_status'] = 2;break;
            case 'waitPay':
                $condition['order_status'] = 3;
                $condition['pay_status'] = '0|2';break;
            case 'waitSend':
                $condition['order_status'] = 3;
                $condition['shipping_status'] = '0|2';break;
            case 'waitConfirm':
                $condition['order_status'] = 3;
                $condition['shipping_status'] = 1;break;
            case 'finish':
                $condition['order_status'] = 4;break;
            case 'cancel':
                $condition['order_status'] = 0;break;
        }
        return $condition;
    }

    public static function getOrderStatusCount($user_id, $firm_id){
        $condition['is_delete'] = 0;
        if($user_id > 0){
            $condition['user_id'] = $user_id;
        }
        if($firm_id > 0){
            $condition['firm_id'] = $firm_id;
        }

        $status = [
            'waitApproval' => 0,
            'waitAffirm' => 0,
            'waitPay' => 0,
            'waitSend' => 0,
            'waitConfirm' => 0
        ];
        //待审批数量
        $condition = array_merge($condition, self::setStatueCondition('waitApproval'));
        $status['waitApproval'] = OrderInfoRepo::getTotalCount($condition);

        //待确认数量
        $condition = array_merge($condition, self::setStatueCondition('waitAffirm'));
        $status['waitAffirm'] = OrderInfoRepo::getTotalCount($condition);

        //待付款数量
        $condition = array_merge($condition, self::setStatueCondition('waitPay'));
        $status['waitPay'] = OrderInfoRepo::getTotalCount($condition);

        //待发货数量
        $condition = array_merge($condition, self::setStatueCondition('waitSend'));
        $status['waitSend'] = OrderInfoRepo::getTotalCount($condition);

        //待收货
        $condition = array_merge($condition, self::setStatueCondition('waitConfirm'));
        $status['waitConfirm'] = OrderInfoRepo::getTotalCount($condition);

        return $status;
    }

    //查询一条数据
    public static function getOrderInfoById($id)
    {
        $order_info = OrderInfoRepo::getInfo($id);
        $order_info['region'] = RegionService::getRegion($order_info['country'],$order_info['province'],$order_info['city'],$order_info['street']);
        return $order_info;
    }


    public static function modify($data)
    {
        return OrderInfoRepo::modify($data['id'], $data);
    }

    //获取订单商品信息
    public static function getOrderGoodsByOrderId($order_id)
    {
        $order_goods = OrderGoodsRepo::getList([], ['order_id' => $order_id]);
        foreach ($order_goods as $k => $vo) {
            $good = GoodsRepo::getInfo($vo['goods_id']);
            $order_goods[$k]['brand_name'] = $good['brand_name'];
        }
        return $order_goods;
    }

    //获取商品信息(带总条数)
    public static function getOrderGoodsList($orderid)
    {
        $order_goods =  OrderGoodsRepo::getListBySearch([], ['order_id' => $orderid]);
        foreach ($order_goods['list'] as $k => $vo){
            $good = GoodsRepo::getInfo($vo['goods_id']);
            $order_goods['list'][$k]['brand_name'] = $good['brand_name'];
        }
        return $order_goods;
    }

    public static function getOrderGoods($params=[], $page = 1 ,$pageSize=10){
        $condition = [];
        if(!empty($params['order_id'])){
            $condition['order_id'] = $params['order_id'];
        }
        if(!empty($params['user_id'])){
            $condition['user_id'] = $params['user_id'];
        }
        if(!empty($params['order_id'])){
            $condition['order_id'] = $params['order_id'];
        }
        if(!empty($params['goods_name'])){
            $condition['goods_name'] = '%'.$params['goods_name'].'%';
        }

        return OrderGoodsRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['add_time'=>'desc']],$condition);
    }

    //获取收货地址信息
    public static function getConsigneeInfo($id)
    {
        return OrderInfoRepo::getList([], ['id' => $id], ['consignee', 'country', 'province', 'city', 'district', 'street', 'address', 'zipcode', 'mobile_phone'])[0];
    }

    //获取发票信息
    public static function getInvoiceInfo($id)
    {
        return UserInvoicesRepo::getInfo($id);
    }

    //修改商品信息
    public static function modifyOrderGoods($data)
    {
        return OrderGoodsRepo::modify($data['id'], $data);
    }

    //查询所有的快递信息
    public static function getShippingList()
    {
        return ShippingRepo::getList([],['enabled'=>1]);
    }

    //更新订单的商品总金额
    public static function modifyGoodsAmount($id)
    {
        $orderInfo = OrderInfoRepo::getInfo($id);
        //查询该订单的所有的商品
        $orderGoods = OrderGoodsRepo::getList([], ['order_id' => $orderInfo['id']]);
        $sum = 0;
        foreach ($orderGoods as $k => $v) {
            $sum += $v['goods_price'] * $v['goods_number'];
        }
        $order_amount = $sum+$orderInfo['shipping_fee']-$orderInfo['discount'];
        return OrderInfoRepo::modify($id, ['goods_amount' => $sum,'order_amount'=>$order_amount]);
    }

    //获取费用信息
    public static function getFeeInfo($id)
    {
        return OrderInfoRepo::getList([], ['id' => $id], ['goods_amount', 'shipping_fee', 'discount', 'money_paid','order_amount'])[0];
    }

    //保存管理员操作日志信息
    public static function createLog($data)
    {
        return OrderActionLogRepo::create($data);
    }

    //查询操作日志信息
    public static function getOrderLogsByOrderid($id)
    {
        return OrderActionLogRepo::getList(['log_time'=>'desc'],['order_id'=>$id]);
    }

    //保存发货单相关信息
    public static function createDelivery($order_delivery_goods_data,$order_delivery_data)
    {
        try{
            self::beginTransaction();
            $orderDelivery = OrderDeliveryRepo::create($order_delivery_data);
            foreach($order_delivery_goods_data as $k=>$v){
                $order_delivery_goods_data[$k]['delivery_id']=$orderDelivery['id'];
                $orderDeliveryGoods = OrderDeliveryGoodsRepo::create($order_delivery_goods_data[$k]);
                //修改order_goods表的已发货数量
                $order_goods = OrderGoodsRepo::getInfo($orderDeliveryGoods['order_goods_id']);
                OrderGoodsRepo::modify($orderDeliveryGoods['order_goods_id'],['send_number'=>$order_goods['send_number']+$orderDeliveryGoods['send_number']]);

            }
            //修改order_info表的发货状态shipping_status
            $order_goods = OrderGoodsRepo::getList([],['order_id'=>$orderDelivery['order_id']]);
            $flag = true;
            foreach($order_goods as $vo){
                if($vo['goods_number']!=$vo['send_number']){
                    $flag = false;
                }
            }
            if($flag==false){
                OrderInfoRepo::modify($orderDelivery['order_id'],['shipping_status'=>2]);//部分发货
            }else{
                OrderInfoRepo::modify($orderDelivery['order_id'],['shipping_status'=>1]);//全部发货
            }
            self::commit();
            return $orderDelivery;
        }catch(\Exception $e){
            self::rollBack();
            Self::throwBizError($e->getMessage());
        }
    }

    //发货单列表
    public static function getDeliveryList($pager,$condition)
    {
        $delivery =  OrderDeliveryRepo::getListBySearch($pager,$condition);
        foreach ($delivery['list'] as $k=>$v){
            $orderinfo = OrderInfoRepo::getList([],['id'=>$v['order_id']],['add_time'])[0];
            $delivery['list'][$k]['order_add_time'] = $orderinfo['add_time'];
        }
        return $delivery;
    }

    //发货单详情
    public static function getDeliveryInfo($id)
    {
        $delivery = OrderDeliveryRepo::getInfo($id);
        $user = UserRepo::getList([],['id'=>$delivery['user_id']],['user_name'])[0];
        $order = OrderInfoRepo::getList([],['id'=>$delivery['order_id']],['add_time','shipping_fee'])[0];
        $delivery['user_name'] = $user['user_name'];//购货人
        $delivery['order_add_time'] = $order['add_time'];//购货人
        $delivery['shipping_fee'] = $order['shipping_fee'];//配送费用
        return $delivery;
    }

    //获取发货单
    public static function getDeliveryGoods($delivery_id)
    {
        $deliveryGoods = OrderDeliveryGoodsRepo::getList([],['delivery_id'=>$delivery_id]);
        foreach($deliveryGoods as $k=>$v){
            //查询所属店铺
            $shop_goods_quote = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
            //查询所属订单的商品信息
            $order_good = OrderGoodsRepo::getInfo($v['order_goods_id']);
            $deliveryGoods[$k]['goods_price'] = $order_good['goods_price']?$order_good['goods_price']:'';
        }
        return $deliveryGoods;
    }

    //修改发货单
    public static function modifyDelivery($data)
    {
        return OrderDeliveryRepo::modify($data['id'],$data);
    }

    //修改发货状态
    public static function modifyDeliveryStatus($data)
    {
        $order_delivery = OrderDeliveryRepo::modify($data['id'],$data);
        return $order_delivery;

    }


    /**
     * 根据条件查询
     * @param $where
     * @return array
     */
    public static function getOrderInfoByWhere($where)
    {
        return OrderInfoRepo::getInfoByFields($where);
    }

    //web 订单删除
    public static function orderDel($id){
        return OrderInfoRepo::modify($id,['is_delete'=>1]);
    }

    // 订单详情
    public static function orderDetails($id){
        $orderInfo =  OrderInfoRepo::getInfoByFields(['order_sn'=>$id]);
        $goodsInfo = OrderGoodsRepo::getList([],['order_id'=>$orderInfo['id']]);

        $country = RegionRepo::getInfo($orderInfo['country']);
        $province = RegionRepo::getInfo($orderInfo['province']);
        $city = RegionRepo::getInfo($orderInfo['city']);
        $district = RegionRepo::getInfo($orderInfo['district']);

        //获取会员发票信息
        $userInvoceInfo = UserInvoicesRepo::getInfo($orderInfo['invoice_id']);
        return ['orderInfo'=>$orderInfo,'userInvoceInfo'=>$userInvoceInfo,'goodsInfo'=>$goodsInfo,'country'=>$country['region_name'],'province'=>$province['region_name'],'city'=>$city['region_name'],'district'=>$district['region_name']];
    }

    //企业订单审核通过操作
    public static function egis($id){
        return OrderInfoRepo::modify($id,['order_status'=>2]);
    }

    //订单取消
    public static function orderCancel($id){
        return OrderInfoRepo::modify($id,['order_status'=>0]);
    }

    //订单确认收货
    public static function orderConfirmTake($id){
        $orderInfo = OrderInfoRepo::getInfo($id);
        if(empty($orderInfo)){
            self::throwBizError('订单信息不存在');
        }
        if($orderInfo['pay_status'] == 1 && $orderInfo['shipping_status'] == 1){
            return OrderInfoRepo::modify($id,['shipping_status'=>3]);
        }
        self::throwBizError('订单状态有误!');


    }

}
