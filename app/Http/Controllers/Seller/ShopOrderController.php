<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-09
 * Time: 11:51
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\OrderInfoService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopOrderController extends Controller
{
    /**
     * 商户电梯列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $currentPage = $request->input("currentPage",1);
        $shop_id = session('_seller_id')['shop_id'];
        $order_status = $request->input('order_status',-1);
        $order_sn = $request->input('order_sn');
        $condition = [];
        $condition['shop_id'] = $shop_id;
        $pageSize = 10;
        if($order_status!=-1){
            $condition['order_status'] = $order_status;
        }
        if($order_sn!=""){
            $condition['order_sn'] = "%".$order_sn."%";
        }
        $orders = OrderInfoService::getOrderInfoList(['pageSize'=>$pageSize,'page'=>$currentPage,'orderType'=>['add_time'=>'desc']],$condition);
        $users = UserService::getUsersByColumn(['id','user_name']);
        return $this->display('seller.order.list',[
            'orders'=>$orders['list'],
            'total'=>$orders['total'],
            'users'=>$users,
            'order_sn'=>$order_sn,
            'pageSize'=>$pageSize,
            'currentPage'=>$currentPage,
            'order_status'=>$order_status
        ]);
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
        $currentPage = $request->input('currentPage',1);
        $where =[
            'id' => $id,
            'shop_id' => $shop_id
        ];
        $orderInfo = OrderInfoService::getOrderInfoByWhere($where);
        $user = UserService::getInfo($orderInfo['user_id']);
        return $this->display('seller.order.detail',[
            'currentPage'=>$currentPage,
            'orderInfo'=>$orderInfo,
            'user'=>$user
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
        $id = $request->input('id','');
        $order_status = $request->input('order_status','0');
        $to_buyer = $request->input('to_buyer','');
        $where = [
            'id' => $id,
            'shop_id' => $shop_id
        ];
        // 判断订单是否存在
        $orderInfo = OrderInfoService::getOrderInfoByWhere($where);
        if (!empty($orderInfo)){
            $data = [
                'order_status' => $order_status,
                'to_buyer' => $to_buyer,
                'confirm_time' => Carbon::now()
            ];
            $re = OrderInfoService::modify($id,$data);
            if (!empty($re)){
                return $this->success('修改成功',url('/seller/order/list'));
            }
        } else {
            return $this->error('订单信息错误，或订单不存在',url('/seller/order/list'));
        }
    }
}
