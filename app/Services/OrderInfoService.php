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
    public static function getOrderGoodsByOrderid($order_id)
    {
        $order_goods = OrderGoodsRepo::getList([], ['order_id' => $order_id]);
        foreach ($order_goods as $k => $vo) {
            $shop_goods_quote = ShopGoodsQuoteRepo::getInfo($vo['shop_goods_quote_id']);
            $good = GoodsRepo::getInfo($vo['goods_id']);
            $order_goods[$k]['shop_name'] = $shop_goods_quote['shop_name'];
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

}
