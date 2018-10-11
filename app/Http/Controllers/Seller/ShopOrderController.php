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
use App\Services\RegionService;
use App\Services\UserInvoicesService;
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
        $currentPage = $request->input("currentPage", 1);
        $shop_id = session('_seller_id')['shop_id'];
        $order_status = $request->input('order_status', -1);
        $order_sn = $request->input('order_sn');
        $condition = [];
        $condition['shop_id'] = $shop_id;
        $pageSize = 10;
        if ($order_status != -1) {
            $condition['order_status'] = $order_status;
        }
        if ($order_sn != "") {
            $condition['order_sn'] = "%" . $order_sn . "%";
        }
        $orders = OrderInfoService::getOrderInfoList(['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['add_time' => 'desc']], $condition);
        $users = UserService::getUsersByColumn(['id', 'user_name']);
        return $this->display('seller.order.list', [
            'orders' => $orders['list'],
            'total' => $orders['total'],
            'users' => $users,
            'order_sn' => $order_sn,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'order_status' => $order_status
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
        $currentPage = $request->input('currentPage', 1);
        $where = [
            'id' => $id,
            'shop_id' => $shop_id
        ];
        $orderInfo = OrderInfoService::getOrderInfoByWhere($where);
        $region = RegionService::getRegion($orderInfo['country'], $orderInfo['province'], $orderInfo['city'], $orderInfo['district']);
        $order_goods = OrderInfoService::getOrderGoodsByOrderid($orderInfo['id']);//订单商品
        $user_invoices = UserInvoicesService::getInvoice($orderInfo['invoice_id']);//发票信息
        $user = UserService::getInfo($orderInfo['user_id']);
        return $this->display('seller.order.detail', [
            'currentPage' => $currentPage,
            'orderInfo' => $orderInfo,
            'user' => $user,
            'region' => $region,
            'order_goods' => $order_goods,
            'user_invoices' => $user_invoices
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
        $order_status = $request->input('order_status', '0');
        $to_buyer = $request->input('to_buyer', '');
        $where = [
            'id' => $id,
            'shop_id' => $shop_id
        ];
        // 判断订单是否存在
        $orderInfo = OrderInfoService::getOrderInfoByWhere($where);
        if (!empty($orderInfo)) {
            $data = [
                'id' => $id,
                'order_status' => $order_status,
                'to_buyer' => $to_buyer,
                'confirm_time' => Carbon::now()
            ];
            $re = OrderInfoService::modify($data);
            if (!empty($re)) {
                return $this->success('修改成功', url('/seller/order/list'));
            }
        } else {
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
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modifyGoodsInfo(Request $request)
    {
        $id = $request->input('id');
        $currentPage = $request->input('currentPage');
        $orderGoods = OrderInfoService::getOrderGoodsByOrderid($id);

        return $this->display('seller.order.goods',[
            'orderGoods'=>$orderGoods,
            'currentPage'=>$currentPage,
            'id'=>$id
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
}
