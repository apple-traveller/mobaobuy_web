<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-16
 * Time: 15:34
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\OrderInfoService;
use App\Services\RegionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopDeliveryController extends Controller
{
    public function list(Request $request)
    {
        $shop_id = session()->get('_seller_id')['shop_id'];
        $order_sn = $request->input('order_sn');
        $currentPage = $request->input('currentPage', 1);
        $pageSize = 10;
        $condition = [];
        $condition['shop_id'] = $shop_id;
        if ($order_sn != "") {
            $condition['order_sn'] = "%" . $order_sn . "%";
        }
        $deliverys = OrderInfoService::getDeliveryList(['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['add_time' => 'desc']], $condition);
        return $this->display('seller.delivery.list', [
            'deliverys' => $deliverys['list'],
            'total' => $deliverys['total'],
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'order_sn' => $order_sn,
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        $currentPage = $request->input('currentPage');
        $delivery = OrderInfoService::getDeliveryInfo($id);
        //地区信息
        $region = RegionService::getRegion($delivery['country'], $delivery['province'], $delivery['city'], $delivery['district']);
        //商品信息
        $delivery_goods = OrderInfoService::getDeliveryGoods($id);

        return $this->display('seller.delivery.detail', [
            'currentPage' => $currentPage,
            'delivery' => $delivery,
            'region' => $region,
            'delivery_goods' => $delivery_goods,
        ]);
    }

    public function modifyShippingBillno(Request $request)
    {
        $data = [
            'id'=>$request->input('id'),
            'shipping_billno'=>$request->input('val'),
        ];
        $delivery = OrderInfoService::getDeliveryInfo($data['id']);
        if ($delivery['status'] == 1){
            return $this->error('订单已发货无法修改订单号');
        }
        try{
            $flag = OrderInfoService::modifyDelivery($data);
            return $this->result($flag['shipping_billno'],200,'修改成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id','');
        $status = $request->input('status','');
        $data = [
            'id'=> $id,
            'status'=>$status
        ];
        try{
            $flag = OrderInfoService::modifyDeliveryStatus($data);
            $logData = [
                'action_note' => '发货',
                'action_user' => session('_seller')['user_name'],
                'order_id' => $id,
                'order_status' => $flag['order_status'],
                'action_place' => 0,
                'shipping_status' => $flag['shipping_status'],
                'pay_status' => $flag['pay_status'],
                'log_time' => Carbon::now()
            ];
            OrderInfoService::createLog($logData);
            //修改订单表的发货状态
            return $this->result('',200,'修改成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
