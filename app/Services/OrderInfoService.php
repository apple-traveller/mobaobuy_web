<?php
namespace App\Services;
use App\Repositories\OrderInfoRepo;
use App\Repositories\OrderGoodsRepo;
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
    public static function getWebOrderList($condition, $page = 1 ,$pageSize=10){
        $condition['is_delete'] = 0;
        $orderList = OrderInfoRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['add_time'=>'desc']],$condition);
        foreach ($orderList['list'] as &$item){
            $item['status'] = self::getOrderStatusName($item['order_status'],$item['pay_status'],$item['shipping_status']);
            $item['goods'] = self::getOrderGoodsByOrderId($item['id']);

            $item['deliveries'] = OrderDeliveryRepo::getList([], ['order_id'=>$item['id'], 'status'=>1], ['shipping_name','shipping_billno']);
        }

        return $orderList;
    }

    private static function getOrderStatusName($order_status, $pay_status, $shipping_status){
        $status = '';
        switch ($order_status){
            case 0: $status = '已作废';break;
            case 1: $status = '待审批';break;
            case 2: $status = '待确认';break;
            case 3: $status = '已确认';break;
            case 4: $status = '已完成';break;
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
            }
        }
        return $status;
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
        $condition['order_status'] = 1;
        $status['waitApproval'] = OrderInfoRepo::getTotalCount($condition);

        //待确认数量
        $condition['order_status'] = 2;
        $status['waitAffirm'] = OrderInfoRepo::getTotalCount($condition);

        //待付款数量
        $condition['order_status'] = 3;
        $condition['pay_status'] = '0|2';
        $status['waitPay'] = OrderInfoRepo::getTotalCount($condition);

        //待发货数量
        $condition['order_status'] = 3;
        $condition['shipping_status'] = '0|2';
        $status['waitPay'] = OrderInfoRepo::getTotalCount($condition);

        //待收货
        $condition['order_status'] = 3;
        $condition['shipping_status'] = 1;
        $status['waitConfirm'] = OrderInfoRepo::getTotalCount($condition);

        return $status;
    }

    //查询一条数据
    public static function getOrderInfoById($id)
    {
        return OrderInfoRepo::getInfo($id);
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
            $shop_goods_quote = ShopGoodsQuoteRepo::getInfo($vo['shop_goods_quote_id']);
            $good = GoodsRepo::getInfo($vo['goods_id']);
            $order_goods['list'][$k]['shop_name'] = $shop_goods_quote['shop_name'];
            $order_goods['list'][$k]['brand_name'] = $good['brand_name'];
        }
        return $order_goods;
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
            $deliveryGoods[$k]['shop_name'] = $shop_goods_quote['shop_name'];
            $deliveryGoods[$k]['goods_price'] = $order_good['goods_price'];
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
        try{
            self::beginTransaction();
            $order_delivery = OrderDeliveryRepo::modify($data['id'],$data);
            $order_goods = OrderGoodsRepo::getList([],['order_id'=>$order_delivery['order_id']]);
            $flag = false;
            foreach($order_goods as $v){
                if($v['goods_number']>$v['send_number'] && $v['send_number']!=0){
                    $flag = true;
                }
            }
            if($flag==true){
               return OrderInfoRepo::modify($order_delivery['order_id'],['shipping_status'=>2]);//部分发货
            }

            $flag1 = true;
            foreach($order_goods as $v){
                if($v['goods_number']!=$v['send_number']){
                    $flag1 = false;
                }
            }
            if($flag1==true){
                return OrderInfoRepo::modify($order_delivery['order_id'],['shipping_status'=>1]);//已全部发货
            }
            self::commit();
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
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

}
