<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderInfoService;
use App\Services\UserService;
use App\Services\RegionService;
use App\Services\UserInvoicesService;
class OrderInfoController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $order_status = $request->input('order_status',-1);
        $order_sn = $request->input('order_sn');
        $condition = [];
        $pageSize = 10;
        if($order_status!=-1){
            $condition['order_status'] = $order_status;
        }
        if($order_sn!=""){
            $condition['order_sn'] = "%".$order_sn."%";
        }
        $orders = OrderInfoService::getOrderInfoList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        $users = UserService::getUsersByColumn(['id','user_name']);
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
        $id = $data['id'];
        unset($data['currpage']);
        try{
            if(key_exists('id',$data)){
                $order = OrderInfoService::modify($data);
                if(!empty($order)){
                    return $this->success('修改成功',url('/admin/orderinfo/detail')."?id=".$id."&currpage=".$currpage);
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
        $orderInfo = OrderInfoService::getOrderInfoById($id);
        $user = UserService::getInfo($orderInfo['user_id']);
        $region = RegionService::getRegion($orderInfo['country'],$orderInfo['province'],$orderInfo['city'],$orderInfo['district']);
        $user_invoices = UserInvoicesService::getInvoice($orderInfo['invoice_id']);//发票信息
        $order_goods = OrderInfoService::getOrderGoodsByOrderid($orderInfo['id']);//订单商品
        // $operator
        return $this->display('admin.orderinfo.detail',[
            'currpage'=>$currpage,
            'orderInfo'=>$orderInfo,
            'user'=>$user,
            'region'=>$region,
            'order_goods'=>$order_goods,
            'user_invoices'=>$user_invoices
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
    public function modify2(Request $request)
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

    //修改收货人信息
    public function modifyConsignee(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $consigneeInfo = OrderInfoService::getConsigneeInfo($id);
        $countrys = RegionService::getRegionListByRegionType(0);
        $provinces = RegionService::getRegionListByRegionType(1);
        $citys = RegionService::getRegionListByRegionType(2);
        $districts = RegionService::getRegionListByRegionType(3);
        return $this->display('admin.orderinfo.consignee',[
            'consigneeInfo'=>$consigneeInfo,
            'id'=>$id,
            'currpage'=>$currpage,
            'countrys'=>$countrys,
            'provinces'=>$provinces,
            'citys'=>$citys,
            'districts'=>$districts
        ]);
    }

    //修改发票信息
    public function modifyInvoice(Request $request)
    {
        $id = $request->input('id');
        $invoice_id = $request->input('invoice_id');
        $currpage = $request->input('currpage');
        $invoiceInfo = OrderInfoService::getInvoiceInfo($invoice_id);
        //dd($invoiceInfo);
        return $this->display('admin.orderinfo.invoice',[
            'invoiceInfo'=>$invoiceInfo,
            'id'=>$id,
            'currpage'=>$currpage,
        ]);
    }

    //保存开票信息
    public function saveInvoice(Request $request)
    {
        $data = $request->all();
        $currpage = $data['currpage'];
        $order_id = $data['order_id'];
        unset($data['currpage']);
        unset($data['order_id']);
        try{
            $order = UserInvoicesService::editInvoices($data['id'],$data);
            if(!empty($order)){
                return $this->success('修改成功',url('/admin/orderinfo/detail')."?id=".$order_id."&currpage=".$currpage);
            }else{
                return $this->error('修改失败');
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
        $orderGoods = OrderInfoService::getOrderGoodsByOrderid($id);
        //dd($orderGoods);
        return $this->display('admin.orderinfo.good',[
            'orderGoods'=>$orderGoods,
            'currpage'=>$currpage,
            'id'=>$id
        ]);
    }

    //保存商品信息
    public function saveOrderGoods(Request $request)
    {
        $data = $request->all();
        $order_id = $data['order_id'];
        $currpage = $data['currpage'];
        unset($data['order_id']);
        unset($data['currpage']);
        try{
            $info = OrderInfoService::modifyOrderGoods($data);
            OrderInfoService::modifyGoodsAmount($order_id);
            if(!$info){
                return $this->error('更新失败');
            }
            return $this->success("/admin/orderinfo/modifyOrderGoods?id=".$order_id."&currpage=".$currpage,200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }




}
