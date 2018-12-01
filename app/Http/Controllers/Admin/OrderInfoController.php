<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\OrderInfoService;
use App\Services\UserService;
use App\Services\RegionService;
use App\Services\UserInvoicesService;
use App\Services\UserRealService;
class OrderInfoController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $order_status = $request->input('order_status',-1);
        $order_sn = $request->input('order_sn');
        $condition = [];
        $pageSize = 10;
        if($order_status!=-1){
            if($order_status==-3){
                $condition['shipping_status'] = 3;
            }elseif($order_status==11){
                $condition['pay_status'] = 1;
            }else{
                $condition['order_status'] = $order_status;
            }
        }
        if($order_sn!=""){
            $condition['order_sn'] = "%".$order_sn."%";
        }
        $orders = OrderInfoService::getOrderInfoList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        $users = UserService::getUsersByColumn([],['id','user_name']);
        return $this->display('admin.orderinfo.list',[
            'orders'=>$orders['list'],
            'total'=>$orders['total'],
            'users'=>$users,
            'order_sn'=>$order_sn,
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'order_status'=>$order_status
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $currpage = $data['currpage'];
        $order_status = $data['order_status'];
        $id = $data['id'];
        unset($data['currpage']);
        unset($data['order_status']);

        try{
            if(key_exists('id',$data)){
                $order = OrderInfoService::modify($data);
                if(!empty($order)){
                    return $this->success('修改成功',url('/admin/orderinfo/detail')."?id=".$id."&currpage=".$currpage."&order_status=".$order_status);
                }else{
                    return $this->error('修改失败');
                }
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }



    //查看详情
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $order_status = $request->input("order_status");
        $orderlog_currpage = $request->input('orderlog_currpage',1);
        $orderInfo = OrderInfoService::getOrderInfoById($id);
        $user = UserService::getInfo($orderInfo['user_id']);
        $region = RegionService::getRegion($orderInfo['country'],$orderInfo['province'],$orderInfo['city'],$orderInfo['district'],$orderInfo['address']);
        $user_real = UserRealService::getInfoByUserId($orderInfo['user_id']);//用户实名信息
        $order_goods = OrderInfoService::getOrderGoodsByOrderId($orderInfo['id']);//订单商品
        $orderLogs = OrderInfoService::getOrderLogsByOrderidPagenate(['pageSize'=>10,'page'=>$orderlog_currpage,'orderType'=>['log_time'=>'desc']],['order_id'=>$id]);
        return $this->display('admin.orderinfo.detail',[
            'currpage'=>$currpage,
            'orderInfo'=>$orderInfo,
            'user'=>$user,
            'region'=>$region,
            'order_goods'=>$order_goods,
            'user_real'=>$user_real,
            'orderLogs'=>$orderLogs['list'],
            'orderLogsTotal'=>$orderLogs['total'],
            'orderLogsCurrpage'=>$orderlog_currpage,
            'order_status'=>$order_status
        ]);
    }


    //ajax修改
    public function modify(Request $request)
    {
        $data = $request->all();
        try{
            OrderInfoService::modify($data);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改自动确认收获的天数
    public function modifyAutoDeliveryTime(Request $request)
    {
        $data = [
            'id'=>$request->input('id'),
            'auto_delivery_time'=>$request->input('val'),
        ];
        try{
            $flag = OrderInfoService::modifyAutoDeliveryTime($data);
            if($flag){
                return $this->result($flag['auto_delivery_time'],200,'修改成功');
            }
            return $this->error('失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改支付状态
    public function modifyPayStatus(Request $request)
    {
        $data = $request->all();
        try{
            $flag = OrderInfoService::modifyPayStatus($data);
            if($flag){
                return $this->result('',200,'修改成功');
            }
            return $this->result('',400,'修改失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //修改订单状态
    public function modifyOrderStatus(Request $request)
    {
        $data = $request->all();
        $action_note = $data['action_note'];
        if(empty($action_note)){
            if(key_exists('order_status',$data)){
                $action_note = "修改订单状态";
            }else{
                $action_note = "修改支付状态";
            }
        }
        unset($data['action_note']);
        try{
            $flag = OrderInfoService::modifyOrderStatus($data,$action_note);
            if($flag){
                return $this->result('',200,'修改成功');
            }
            return $this->result('',400,'修改失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //编辑收货人信息
    public function modifyConsignee(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $order_status = $request->input('order_status');
        $consigneeInfo = OrderInfoService::getConsigneeInfo($id);
        $countrys = RegionService::getRegionListByRegionType(0);
        $provinces = RegionService::getRegionListByRegionType(1);
        $citys = RegionService::getRegionListByRegionType(2);
        $districts = RegionService::getRegionListByRegionType(3);
        return $this->display('admin.orderinfo.consignee',[
            'consigneeInfo'=>$consigneeInfo,
            'id'=>$id,
            'currpage'=>$currpage,
            'order_status'=>$order_status,
            'countrys'=>$countrys,
            'provinces'=>$provinces,
            'citys'=>$citys,
            'districts'=>$districts
        ]);
    }

    //保存收货地址
    public function saveConsignee(Request $request)
    {
        $data = $request->all();
        $currpage = $data['currpage'];
        $order_status = $data['order_status'];
        $id = $data['id'];
        unset($data['currpage']);
        unset($data['order_status']);

        try{
            if(key_exists('id',$data)){
                $order = OrderInfoService::modifyConsignee($data);
                if(!empty($order)){
                    return $this->success('修改成功',url('/admin/orderinfo/detail')."?id=".$id."&currpage=".$currpage."&order_status=".$order_status);
                }else{
                    return $this->error('修改失败');
                }
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //编辑商品信息
    public function modifyOrderGoods(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $shop_name = $request->input("shop_name");
        $order_status = $request->input('order_status');
        $orderGoods = OrderInfoService::getOrderGoodsByOrderId($id);
        $goods_amount = OrderInfoService::getOrderInfoById($id)['goods_amount'];
        return $this->display('admin.orderinfo.good',[
            'orderGoods'=>$orderGoods,
            'currpage'=>$currpage,
            'id'=>$id,
            'goods_amount'=>$goods_amount,
            'shop_name'=>$shop_name,
            'order_status'=>$order_status,
        ]);
    }

    //保存商品信息
    public function saveOrderGoods(Request $request)
    {
        $data = $request->all();
        //{id: "456", goods_price: "300.00", goods_number: "120", order_id: "414"}
        try{
            //修改order_goods表的单价和数量,修改order_info订单总金额和商品总金额
            $flag = OrderInfoService::modifyOrderGoods($data);
            $goods_amount = OrderInfoService::getOrderInfoById($data['order_id'])['goods_amount'];
            if($flag){
                return $this->result($goods_amount,200,'更新成功');
            }
            return $this->result('',400,'更新失败');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    //编辑费用信息
    public function modifyFee(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $order_status = $request->input("order_status");
        $feeInfo = OrderInfoService::getFeeInfo($id);
        return $this->display('admin.orderinfo.fee',[
            'feeInfo'=>$feeInfo,
            'currpage'=>$currpage,
            'id'=>$id,
            "order_status"=>$order_status
        ]);
    }

    //保存费用信息
    public function saveFee(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $currpage = $data['currpage'];
        $order_status = $data['order_status'];
        unset($data['currpage']);
        unset($data['order_status']);

        try{
            $info = OrderInfoService::modifyFee($data);
            OrderInfoService::modifyGoodsAmount($id);
            if(!$info){
                return $this->error('更新失败');
            }
            return $this->success('更新成功',"/admin/orderinfo/detail?id=".$id."&currpage=".$currpage."&order_status=".$order_status);
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    //生成发货单
    public function delivery(Request $request)
    {
        $currpage = $request->input('currpage');
        $order_id = $request->input('order_id');
        //查询所有的快递信息
        $shippings = OrderInfoService::getShippingList();
        //查询该订单的所有商品信息
        $orderGoods = OrderInfoService::getOrderGoodsByOrderId($order_id);

        return $this->display('admin.orderinfo.delivery',[
            'shippings'=>$shippings,
            'currpage'=>$currpage,
            'orderGoods'=>$orderGoods,
            'id'=>$order_id
        ]);
    }

    //发货单商品（渲染表单）
    public function GoodsForm(Request $request)
    {
        $order_id = $request->input('order_id');
        $orderGoods = OrderInfoService::getOrderGoodsList($order_id);
        return json_encode(['count'=>$orderGoods['total'],'data'=>$orderGoods['list'],'code'=>0,'msg'=>'']);
    }

    //保存发货单
    public function saveDelivery(Request $request)
    {
        $data = $request->all();
        $order_id = $request->input('order_id');
        if(empty($data['layTableCheckbox'])){
            return $this->error('没有选择发货商品');
        }
        unset($data['layTableCheckbox']);
        $orderDeliveryGoodsData = json_decode($data['send_number_delivery'],true);
        $order_delivery_goods_data = []; //发货单商品信息
        foreach($orderDeliveryGoodsData as $k=>$v){
            $order_delivery_goods_data[$k]['order_goods_id'] = $v['id'];
            //$order_delivery_goods_data[$k]['shop_goods_id'] = $v['shop_goods_id'];
            $order_delivery_goods_data[$k]['shop_goods_quote_id'] = $v['shop_goods_quote_id'];
            $order_delivery_goods_data[$k]['goods_id'] = $v['goods_id'];
            $order_delivery_goods_data[$k]['goods_name'] = $v['goods_name'];
            $order_delivery_goods_data[$k]['goods_sn'] = $v['goods_sn'];
            if(!empty($v['send_number_delivery']) && $v['send_number_delivery']>$v['goods_number']-$v['send_number']){
                return $this->error('发货数量不能大于剩余商品数量');
            }
            if(empty($v['send_number_delivery'])){
                return $this->error('发货数量不能为空');
            }
            $order_delivery_goods_data[$k]['send_number'] = empty($v['send_number_delivery'])?0:$v['send_number_delivery'];
        }
        //发货单信息
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
        $order_delivery_data['mobile_phone'] = $orderInfo['mobile_phone'];//买家留言
        $order_delivery_data['postscript'] = $orderInfo['postscript'];
        $order_delivery_data['update_time'] = Carbon::now();
        $order_delivery_data['status'] = 0;
        try{
            $orderDelivery = OrderInfoService::createDelivery($order_delivery_goods_data,$order_delivery_data);
            if(!empty($orderDelivery)){
                return $this->success('生成发货单成功',url('/admin/orderinfo/delivery/list')."?order_sn=".$orderDelivery['order_sn']);
            }
            return $this->error('生成发货单失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //发货单列表
    public function deliveryList(Request $request)
    {
        $order_sn = $request->input('order_sn');
        $currpage = $request->input('currpage',1);
        $pageSize = 10;
        $condition = [];
        if($order_sn!=""){
            $condition['order_sn'] = "%".$order_sn."%";
        }
        $deliverys = OrderInfoService::getDeliveryList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('admin.orderinfo.deliverylist',[
            'deliverys'=>$deliverys['list'],
            'total'=>$deliverys['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'order_sn'=>$order_sn,
        ]);
    }

    //发货单详情
    public function deliveryDetail(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $delivery = OrderInfoService::getDeliveryInfo($id);
        //地区信息
        $region = RegionService::getRegion($delivery['country'],$delivery['province'],$delivery['city'],$delivery['district'],"");
        //商品信息
        $delivery_goods = OrderInfoService::getDeliveryGoods($id);
        //dd($delivery_goods);
        return $this->display('admin.orderinfo.deliverydetail',[
            'currpage'=>$currpage,
            'delivery'=>$delivery,
            'region'=>$region,
            'delivery_goods'=>$delivery_goods,
        ]);
    }

    //修改快递号
    public function modifyShippingBillno(Request $request)
    {
        $data = [
            'id'=>$request->input('id'),
            'shipping_billno'=>$request->input('val'),
        ];
        try{
            $flag = OrderInfoService::modifyDelivery($data);
            return $this->result($flag['shipping_billno'],200,'修改成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改发货状态
    public function modifyDeliveryStatus(Request $request)
    {
        $data = $request->all();

        try{
            $flag = OrderInfoService::modifyDeliveryStatus($data);
            //修改订单表的发货状态
            if(empty($flag)){
                return $this->result("",400,'修改失败');
            }
            return $this->result($flag,200,'修改成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function microtime_float()
    { /* 微秒 */
        list($usec, $sec) = explode(' ', microtime()); /* 非科学计数法 */
        return array('ms' => microtime(true) * 10000, 'mi' => sprintf("%.0f", ((float)$usec + (float)$sec) * 100000000),);
    }






}
