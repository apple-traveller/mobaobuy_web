<?php

namespace App\Http\Controllers\Api;

use App\Repositories\OrderInfoRepo;
use App\Services\GoodsCategoryService;
use App\Services\OrderInfoService;
use App\Services\UserRealService;
use Illuminate\Http\Request;

class FlowController extends ApiController
{

    public function toPay(Request $request){
        $userId = $this->getUserID($request);
        $order_id = $request->input('order_id');
        if(empty($order_id)){
            return $this->error('缺少参数,order_id');
        }
        $order_info = OrderInfoService::getOrderInfoById($order_id);
        if(!$order_info){
            return $this->error('传入的订单id有误');
        }
        $sellerInfo  = UserRealService::getUserRealInfoByUserId($userId);
        return $this->success(compact('order_info','sellerInfo'),'success');
    }

    public function toPayDeposit(Request $request){
        $userId = $this->getUserID($request);
        $order_id = $request->input('order_id');
        $order_info = OrderInfoService::getOrderInfoById($order_id);
        if(!$order_info){
            return $this->error('传入的订单id有误');
        }
        $sellerInfo  = UserRealService::getUserRealInfoByUserId($userId);
        return $this->success(compact('order_info','sellerInfo'),'success');
    }

    //上传凭证
    public function payVoucherSave(Request $request){
        $orderSn = $request->input('orderSn');
        $payVoucher = $request->input('payVoucher');
        //$deposit 1 为支付定金 0为支付款
        $deposit = $request->input('deposit');
        try{
            $flag = OrderInfoService::payVoucherSaveApi($orderSn,$payVoucher,$deposit);
            if($flag){
                return $this->success('','success');
            }
            return $this->error('订单信息不存在');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //我的订单
    /*public function orderList(Request $request){
        $tab_code = $request->input('tab_code', '');
        if($request->isMethod('get')){
            return $this->display('web.user.order.list', compact('tab_code'));
        }else{
            $page = $request->input('start', 0) / $request->input('length', 10) + 1;
            $page_size = $request->input('length', 10);
            $firm_id = session('_curr_deputy_user')['firm_id'];
            $order_no = $request->input('order_no');

            $condition['status'] = $tab_code;
            //
            /*if(session('_curr_deputy_user')['is_firm']){
                $condition['firm_id'] = $firm_id;
            }else{
                $condition['user_id'] = $firm_id;
                $condition['firm_id'] = 0;
            }*/
            /*if(!empty($order_no)){
                $condition['order_sn'] = '%'.$order_no.'%';
            }

            $rs_list = OrderInfoService::getWebOrderList($condition, $page, $page_size);

            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $rs_list['total'], //数据总行数
                'recordsFiltered' => $rs_list['total'], //数据总行数
                'data' => $rs_list['list']
            ];

            return $this->success('', '', $data);
        }
    }*/

}
