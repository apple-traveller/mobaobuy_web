<?php

namespace App\Http\Controllers\Web;

use App\Services\GoodsCategoryService;
use App\Services\OrderInfoService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlowController extends Controller
{

    public function toPay(Request $request){
        $order_id = $request->input('order_id');
        $order_info = OrderInfoService::getOrderInfoById($order_id);
        return $this->display('web.flow.payment', compact('order_info'));
    }

    //我的订单
    public function orderList(Request $request){
        $tab_code = $request->input('tab_code', '');
        if($request->isMethod('get')){
            return $this->display('web.user.order.list', compact('tab_code'));
        }else{
            $page = $request->input('start', 0) / $request->input('length', 10) + 1;
            $page_size = $request->input('length', 10);
            $firm_id = session('_curr_deputy_user')['firm_id'];
            $order_no = $request->input('order_no');

            $condition['status'] = $tab_code;
            //todo 测试看数据，暂查询所有数据，不带订单用户ID条件
            /*if(session('_curr_deputy_user')['is_firm']){
                $condition['firm_id'] = $firm_id;
            }else{
                $condition['user_id'] = $firm_id;
                $condition['firm_id'] = 0;
            }*/
            if(!empty($order_no)){
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
    }

}
