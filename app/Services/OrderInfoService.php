<?php
namespace App\Services;
use App\Repositories\ActivityPromoteRepo;
use App\Repositories\ActivityWholesaleRepo;
use App\Repositories\CartRepo;
use App\Repositories\FirmStockFlowRepo;
use App\Repositories\FirmStockRepo;
use App\Repositories\OrderInfoRepo;
use App\Repositories\OrderGoodsRepo;
use App\Repositories\RegionRepo;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\ShopRepo;
use App\Repositories\UserAddressRepo;
use App\Repositories\UserInvoicesRepo;
use App\Repositories\OrderActionLogRepo;
use App\Repositories\ShippingRepo;
use App\Repositories\OrderDeliveryRepo;
use App\Repositories\OrderDeliveryGoodsRepo;
use App\Repositories\UserRealRepo;
use App\Repositories\UserRepo;
use App\Repositories\OrderContractRepo;
use Carbon\Carbon;
use League\Flysystem\Exception;

class OrderInfoService
{
    use CommonService;

    //列表（分页）
    public static function getOrderInfoList($pager, $condition)
    {
        if (isset($condition['tab_code'])){
            $condition = array_merge($condition,self::setStatueCondition($condition['tab_code']));
            unset($condition['tab_code']);
        }
        $re = OrderInfoRepo::getListBySearch($pager, $condition);
        foreach ($re['list'] as $k=>$v){
            $re['list'][$k]['_status'] = self::getOrderStatusName($v['order_status'],$v['pay_status'],$v['shipping_status'],$v['deposit_status'],$v['extension_code']);
            if($v['user_id'] > 0 && $v['firm_id'] > 0){
                $real_user_id = $v['firm_id'];
            }else{
                $real_user_id = $v['user_id'];
            }
            $re['list'][$k]['trade_user'] = UserService::getInfo($real_user_id);
        }
        return $re;
    }

    //企业修改订单是否审批 订单检测
    public static function checkApprovalByOrderCount($userId){
        $orderStatus = OrderInfoRepo::getTotalCount(['firm_id'=>$userId,'order_status'=>1]);
        if($orderStatus > 0){
            return true;
        }
        return false;
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
            $needApproval = UserRepo::getInfo($currUser['firm_id'])['need_approval'];
            if($condition['firm_id'] && $currUser['is_self'] == 0){
                $currUserAuth = FirmUserService::getAuthByCurrUser($condition['firm_id'],$currUser['user_id']);
                $currUserAuth[0]['need_approval'] = $needApproval;
            }
        }

        foreach ($orderList['list'] as $k=>&$item){
            $item['status'] = self::getOrderStatusName($item['order_status'],$item['pay_status'],$item['shipping_status'],$item['deposit_status'],$item['extension_code']);
            $item['goods'] = self::getOrderGoodsByOrderId($item['id']);
            $item['deliveries'] = OrderDeliveryRepo::getList([], ['order_id'=>$item['id'], 'status'=>1], ['id','shipping_name','shipping_billno']);
            if(!empty($item['contract'])){
                $item['contract'] = getFileUrl($item['contract']);
            }

            //区分待确认的订单
            //取消需要返库
            if($item['order_status'] > 2){
                $waitAffirm = "''";
            }else{
               // 取消不需要返库
                $waitAffirm = "'waitAffirm'";
            }
            //企业
            if(($currUser['is_self'] == 1) && $currUser['is_firm']){
                if($item['order_status'] == 0){
                    $orderList['list'][$k]['auth'][] = 'can_del';
                    $orderList['list'][$k]['auth_desc'][] = '删除';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderDel('.$item['id'].')"';
                }
                if($item['order_status'] == 1){
                    if($needApproval){
                        $orderList['list'][$k]['auth'][] = 'can_approval';
                        $orderList['list'][$k]['auth_desc'][] = '审批';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderApproval('.$item['id'].')"';
                    }

                    $orderList['list'][$k]['auth'][] = 'can_cancel';
                    $orderList['list'][$k]['auth_desc'][] = '取消';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].','.$waitAffirm.')"';
                }
                if ($item['order_status'] == 2) {
                    if ($item['deposit_status'] == 1) {
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth'][] = 'wait_Confirm';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_desc'][] = '待商家确认';
                        $orderList['list'][$k]['auth_html'][] = 'style="" onclick="orderCancel(' . $item['id'] . ',' . $waitAffirm . ')"';
                        $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc"';
                    } elseif ($item['deposit_status'] == 0) {
                        $orderList['list'][$k]['auth'][] = 'can_pay';
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '支付订金';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_html'][] = 'href="http://' . $_SERVER['SERVER_NAME'] . '/toPayDeposit?order_id=' . $item['id'] . '"';
                        $orderList['list'][$k]['auth_html'][] = 'style="" onclick="orderCancel(' . $item['id'] . ',' . $waitAffirm . ')"';
                    }

                }

                if($item['order_status'] == 3){
                    if($item['pay_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_pay';
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '去支付';
                        $orderList['list'][$k]['auth_desc'][] = '取消';  //toPay
                        $orderList['list'][$k]['auth_html'][] = 'href="http://'.$_SERVER['SERVER_NAME'].'/toPay?order_id='.$item['id'].'"';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].','.$waitAffirm.')"';
                    }
//                    elseif($item['pay_status'] == 1){
//                        $orderList['list'][$k]['auth'][] = 'can_confirm';
//                        $orderList['list'][$k]['auth_desc'][] = '确认收货';
//                        $orderList['list'][$k]['auth_html'][] = 'onclick="confirmTake('.$item['id'].')"';
//                    }
                    //未发货
                    if($item['pay_status'] == 1 && $item['shipping_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_confirm';
                        $orderList['list'][$k]['auth_desc'][] = '待卖家发货';
                        $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc;"';
                    }
                    if($item['pay_status'] == 1 && $item['shipping_status'] == 1){
                            $orderList['list'][$k]['auth'][] = 'can_confirm';
                            $orderList['list'][$k]['auth_desc'][] = '确认收货';
                            $orderList['list'][$k]['auth_html'][] = 'onclick="confirmTake('.$item['id'].')"';
                    }
                }
            }

            //企业会员

            if(($currUser['is_self'] == 0) && $currUser['is_firm'] == 1){
                if($currUserAuth){
                    //已作废订单
//                    if($item['order_status'] == 0){
//                        $orderList['list'][$k]['auth'][] = 'can_del';
//                        $orderList['list'][$k]['auth_desc'][] = '删除';
//                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderDel('.$item['id'].')"';
//                    }

                    //待企业审核订单
                    if($item['order_status'] == 1){
                        if($currUserAuth[0]['need_approval']){
                            if($currUserAuth[0]['can_approval']){
                                $orderList['list'][$k]['auth'][] = 'can_approval';
                                $orderList['list'][$k]['auth_desc'][] = '审批';
                                $orderList['list'][$k]['auth_html'][] = 'onclick="orderApproval('.$item['id'].')"';
                            }else{
                                $orderList['list'][$k]['auth'][] = 'wait_approval';
                                $orderList['list'][$k]['auth_desc'][] = '待审批';
                                $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc;"';
                            }

                        }
//                        $orderList['list'][$k]['auth'][] = 'can_cancel';
//                        $orderList['list'][$k]['auth_desc'][] = '取消';
//                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].')"';
                    }




                    //待商家确认
                    if ($item['order_status'] == 2){
//                        $orderList['list'][$k]['auth'][] = 'can_cancel';
//                        $orderList['list'][$k]['auth_desc'][] = '取消';
//                        $orderList['list'][$k]['auth_html'][] = '';
                        if ($item['deposit_status'] == 1){
                            $orderList['list'][$k]['auth'][] = 'wait_Confirm';
                            $orderList['list'][$k]['auth_desc'][] = '待商家确认';
                            $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc;"';
                        } elseif ($item['deposit_status'] == 0) {
                            if($currUserAuth[0]['can_pay']){
                                $orderList['list'][$k]['auth'][] = 'can_pay';
//                                $orderList['list'][$k]['auth'][] = 'can_cancel';
                                $orderList['list'][$k]['auth_desc'][] = '支付订金';
//                                $orderList['list'][$k]['auth_desc'][] = '取消';
                                $orderList['list'][$k]['auth_html'][] = 'href="http://' . $_SERVER['SERVER_NAME'] . '/toPayDeposit?order_id=' . $item['id'] . '"';
//                                $orderList['list'][$k]['auth_html'][] = 'style="" onclick="orderCancel(' . $item['id'] . ',' . $waitAffirm . ')"';
                            }

                        }
                    }
                    //已确认
                    if($item['order_status'] == 3){
                        if($item['pay_status'] == 0 && $currUserAuth[0]['can_pay']){
//                            $orderList['list'][$k]['auth'][] = 'can_cancel';
                            $orderList['list'][$k]['auth'][] = 'can_pay';
//                            $orderList['list'][$k]['auth_desc'][] = '取消';
                            $orderList['list'][$k]['auth_desc'][] = '去支付';
//                            $orderList['list'][$k]['auth_html'][] = 'style="" onclick="orderCancel(' . $item['id'] . ',' . $waitAffirm . ')"';
                            $orderList['list'][$k]['auth_html'][] = 'href="http://'.$_SERVER['SERVER_NAME'].'/toPay?order_id='.$item['id'].'"';

                        }
                        //未发货
                        if($item['pay_status'] == 1 && $item['shipping_status'] == 0){
                                $orderList['list'][$k]['auth'][] = 'can_confirm';
                                $orderList['list'][$k]['auth_desc'][] = '待卖家发货';
                                $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc;"';
                        }elseif($item['pay_status'] == 1 && $item['shipping_status'] == 1){
                            if($currUserAuth[0]['can_confirm']){
                                $orderList['list'][$k]['auth'][] = 'can_confirm';
                                $orderList['list'][$k]['auth_desc'][] = '确认收货';
                                $orderList['list'][$k]['auth_html'][] = 'onclick="confirmTake('.$item['id'].')"';
                            }
                        }
                    }
                }
            }

            //个人
            if ($currUser['is_firm'] == 0){
                //个人
                if ($item['order_status'] == 0){
                    $orderList['list'][$k]['auth'][] = 'can_del';
                    $orderList['list'][$k]['auth_desc'][] = '删除';
                    $orderList['list'][$k]['auth_html'][] = 'onclick="orderDel('.$item['id'].')"';
                }

                if ($item['order_status'] == 2){
                    if ($item['deposit_status'] == 1){
                        $orderList['list'][$k]['auth'][] = 'wait_Confirm';
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '待商家确认';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc;"';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].','.$waitAffirm.')"';
                    } elseif ($item['deposit_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_pay';
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '支付订金';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_html'][] = 'href="http://' . $_SERVER['SERVER_NAME'] . '/toPayDeposit?order_id=' . $item['id'] . '"';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].','.$waitAffirm.')"';
                    }
                }

                if ($item['order_status'] == 3){
                    if ($item['pay_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_pay';
                        $orderList['list'][$k]['auth'][] = 'can_cancel';
                        $orderList['list'][$k]['auth_desc'][] = '去支付';
                        $orderList['list'][$k]['auth_desc'][] = '取消';
                        $orderList['list'][$k]['auth_html'][] = 'href="http://'.$_SERVER['SERVER_NAME'].'/toPay?order_id='.$item['id'].'"';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="orderCancel('.$item['id'].','.$waitAffirm.')"';
                    }

                    //未发货
                    if($item['pay_status'] == 1 && $item['shipping_status'] == 0){
                        $orderList['list'][$k]['auth'][] = 'can_confirm';
                        $orderList['list'][$k]['auth_desc'][] = '待卖家发货';
                        $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc;"';
                    }
                    if($item['pay_status'] == 1 && $item['shipping_status'] == 1){
                        $orderList['list'][$k]['auth'][] = 'can_confirm';
                        $orderList['list'][$k]['auth_desc'][] = '确认收货';
                        $orderList['list'][$k]['auth_html'][] = 'onclick="confirmTake('.$item['id'].')"';
                    }
                }
            }

            if ($item['order_status'] == 4){
                $orderList['list'][$k]['auth'][] = 'finish';
                $orderList['list'][$k]['auth_desc'][] = '已完成';
                $orderList['list'][$k]['auth_html'][] = 'style="background-color:#ccc;"';
            }

            if ($item['order_status'] == 5){
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

    private static function getOrderStatusName($order_status, $pay_status, $shipping_status,$deposit_status,$extension_code = ''){
        $status = '';
        switch ($order_status){
            case 0: $status = '已作废';break;
            case 1: $status = '待审批';break;
            case 2: $status = '待确认';break;
            case 3: $status = '已确认';break;
            case 4: $status = '已完成';break;
            case 5: $status = '待开票';break;
            case 6: $status = '开票中';break;
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

            if($order_status == 2){
                if($extension_code == 'wholesale'){
                    switch ($deposit_status){
                        case 0: $status .= ', 未付定金';break;
                        case 1: $status .= ', 已付定金';break;
                    }
                }

            }
        }
        return $status;
    }

    private static function setStatueCondition($status_code){
        $condition = [];
        $condition['is_delete'] = 0;
        switch ($status_code){
            case 'allOrder':
                $condition['order_status|>'] = 0;
            case 'waitDeposit':
                $condition['order_status'] = 2;
                $condition['deposit_status'] = 0;break;
            case 'waitApproval':
                $condition['order_status'] = 1;break;
            case 'waitAffirm':
                $condition['order_status'] = 2;
                $condition['deposit_status'] = 1;break;
            case 'waitPay':
                $condition['order_status'] = 3;
                $condition['pay_status'] = '0|2';break;
            case 'waitSend':
                $condition['order_status'] = 3;
                $condition['pay_status'] = 1;
                $condition['shipping_status'] = '0|2';break;
            case 'waitConfirm':
                $condition['order_status'] = 3;
                $condition['pay_status'] = 1;
                $condition['shipping_status'] = 1;break;
            case 'waitInvoice':
                $condition['order_status'] = 5;
                $condition['pay_status'] = 1;
                break;
            case 'invoiceIng':
                $condition['order_status'] = 6;
                $condition['pay_status'] = 1;
                break;
            case 'finish':
                $condition['order_status'] = 4;break;
            case 'cancel':
                $condition['order_status'] = 0;break;
        }
        return $condition;
    }

    // web
    public static function getOrderStatusCount($user_id, $firm_id, $seller_id = 0){
        $condition['is_delete'] = 0;

        if($user_id > 0){
            $condition['user_id'] = $user_id;
        }
        if($user_id == ''){
            unset($condition['user_id']);
        }

        $condition['firm_id'] = $firm_id;


        // 商户后台
        if ($seller_id>0){
            $condition['shop_id'] = $seller_id;
            unset($condition['firm_id']);
        }


        $status = [
            'allOrder' => 0,
            'waitApproval' => 0,
            'waitAffirm' => 0,
            'waitPay' => 0,
            'waitSend' => 0,
            'waitConfirm' => 0,
            'waitInvoice'=> 0,
            'waitDeposit'=>0,
            'invoiceIng' => 0
        ];



        //待付定金
        $condition = array_merge($condition, self::setStatueCondition('waitDeposit'));
        $status['waitDeposit'] = OrderInfoRepo::getTotalCount($condition);

        //待审批数量
        $condition = array_merge($condition, self::setStatueCondition('waitApproval'));
        unset($condition['deposit_status']);
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

        //待开票
        $condition = array_merge($condition, self::setStatueCondition('waitInvoice'));
        unset($condition['pay_status']);
        unset($condition['shipping_status']);
        $condition['shipping_status|>'] =  0;
        $status['waitInvoice'] = OrderInfoRepo::getTotalCount($condition);

        //开票中
        $condition = array_merge($condition, self::setStatueCondition('invoiceIng'));
        $status['invoiceIng'] = OrderInfoRepo::getTotalCount($condition);

        //全部订单
        $condition = array_merge($condition, self::setStatueCondition('allOrder'));
        unset($condition['order_status']);
        unset($condition['deposit_status']);
        unset($condition['shipping_status']);
        unset($condition['shipping_status|>']);
        unset($condition['pay_status']);
        $status['allOrder'] = OrderInfoRepo::getTotalCount($condition);
        return $status;
    }

    //根据状态获取订单数量，用于管理员后台新订单提示
    public static function getOrderCountByStatus()
    {
        //待付定金
        $condition = self::setStatueCondition('waitDeposit');
        $status['waitDeposit'] = OrderInfoRepo::getTotalCount($condition);

        //待审批数量
        $condition = self::setStatueCondition('waitApproval');
        unset($condition['deposit_status']);
        $status['waitApproval'] = OrderInfoRepo::getTotalCount($condition);

        //待确认数量
        $condition = self::setStatueCondition('waitAffirm');
        $status['waitAffirm'] = OrderInfoRepo::getTotalCount($condition);

        //待付款数量
        $condition = self::setStatueCondition('waitPay');
        $status['waitPay'] = OrderInfoRepo::getTotalCount($condition);

        //待发货数量
        $condition = self::setStatueCondition('waitSend');
        $status['waitSend'] = OrderInfoRepo::getTotalCount($condition);

        //待收货
        $condition = self::setStatueCondition('waitConfirm');
        $status['waitConfirm'] = OrderInfoRepo::getTotalCount($condition);

        //待开票
        $condition = self::setStatueCondition('waitInvoice');
        unset($condition['pay_status']);

        $status['waitInvoice'] = OrderInfoRepo::getTotalCount($condition);

        $status['total'] = OrderInfoRepo::getTotalCount([]);

        return $status;
    }


    //查询一条数据
    public static function getOrderInfoById($id)
    {
        $order_info = OrderInfoRepo::getInfo($id);

        if(empty($order_info)){
            return false;
        }
        $order_info['region'] = RegionService::getRegion($order_info['country'],$order_info['province'],$order_info['city'],$order_info['district'],$order_info['address']);
        return $order_info;
    }

    //修改
    public static function modify($data, $contract_data=[])
    {
        if (!empty($contract_data)){
            try{
                // 如果确认订单上传合同 开启事务
                self::beginTransaction();
                $re = OrderContractService::create($contract_data);
                if ($re){
                    $rs = OrderInfoRepo::modify($data['id'],$data);
                    if ($rs){
                        self::commit();
                        return $rs;
                    }
                }
            }catch (\Exception $e){
                self::rollBack();
                self::throwBizError($e->getMessage());
            }
        } else {
            return OrderInfoRepo::modify($data['id'],$data);
        }
    }

    //修改收货地址
    public static function modifyConsignee($data)
    {
        try{
            self::beginTransaction();
            //修改支付状态
            $order_info = OrderInfoRepo::modify($data['id'], $data);
            //给管理员操作添加一条数据
            $logData = [
                'action_note'=>'修改收货地址',
                'action_user'=>session()->get('_admin_user_info')['real_name'],
                'order_id'=>$order_info['id'],
                'order_status'=>$order_info['order_status'],
                'shipping_status'=>$order_info['shipping_status'],
                'pay_status'=>$order_info['pay_status'],
                'log_time'=>Carbon::now()
            ];
            $flag_order_log = OrderActionLogRepo::create($logData);
            if(!empty($order_info) && !empty($flag_order_log)){
                self::commit();
                return $order_info;
            }
            return false;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    //修改支付状态
    public static function modifyPayStatus($data)
    {
        try{
            self::beginTransaction();
            //修改支付状态，和已付款金额字段
            if(isset($data['pay_status'])){
                $order_info = OrderInfoRepo::modify($data['id'], ['pay_status'=>$data['pay_status']]);
                OrderInfoRepo::modify($data['id'], ['money_paid'=>$order_info['order_amount']]);
            }
            //修改订金状态
            if(isset($data['deposit_status'])){
                OrderInfoRepo::modify($data['id'], ['deposit_status'=>$order_info['deposit_status']]);
            }
            //修改卖家确认时间
            OrderInfoRepo::modify($data['id'], ['confirm_time'=>Carbon::now()]);
            //给管理员操作添加一条数据
            $logData = [
                'action_note'=>'修改支付状态为已付款',
                'action_user'=>session()->get('_admin_user_info')['real_name'],
                'order_id'=>$order_info['id'],
                'order_status'=>$order_info['order_status'],
                'shipping_status'=>$order_info['shipping_status'],
                'pay_status'=>$order_info['pay_status'],
                'log_time'=>Carbon::now()
            ];
            $flag_order_log = OrderActionLogRepo::create($logData);
            if(!empty($order_info) && !empty($flag_order_log)){
                self::commit();
                return $order_info;
            }
            return false;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    //修改订单状态
    public static function modifyOrderStatus($data,$action_note)
    {
        try{
            self::beginTransaction();
            //获取订单信息
            $orderInfo = OrderInfoRepo::getInfo($data['id']);
            $orderGoodsInfo = OrderGoodsRepo::getList([],['order_id'=>$orderInfo['id']]);
            $order_info = "";
            //修改支付状态
            if($data['order_status']==2){ //企业审核订单通过
                if($orderInfo['order_status']>=2){
                    self::throwBizError("企业已审核");
                }
                $order_info = OrderInfoRepo::modify($data['id'], $data);
            }
            if($data['order_status']==0){//订单取消 waitAffirm
                //根据来源返回库存
                if($orderInfo['extension_code'] == 'promote'){//限时抢购
                    $activityPromoteInfo = ActivityPromoteRepo::getInfo($orderInfo['extension_id']);
                    ActivityPromoteRepo::modify($orderInfo['extension_id'],['available_quantity'=>$activityPromoteInfo['available_quantity'] + $orderGoodsInfo[0]['goods_number']]);
                }elseif ($orderInfo['extension_code'] == 'wholesale'){//集采火拼 这边要减去活动已参与的数量
                    //减去已参与数量
                    $activityWholesaleInfo = ActivityWholesaleRepo::getInfo($orderInfo['extension_id']);
                    ActivityWholesaleRepo::modify($orderInfo['extension_id'], ['partake_quantity' => $activityWholesaleInfo['partake_quantity'] - $orderGoodsInfo[0]['goods_number']]);
                }elseif ($orderInfo['extension_code'] == 'consign'){//清仓特卖 这边要返回清仓特卖的 库存
                    foreach ($orderGoodsInfo as $k=>$v){
                        $quoteInfo = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
                        ShopGoodsQuoteRepo::modify($v['shop_goods_quote_id'],['goods_number'=>$quoteInfo['goods_number']+$v['goods_number']]);
                    }
                }else{//购物车下单
                    foreach ($orderGoodsInfo as $k=>$v){
                        $quoteInfo = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
                        ShopGoodsQuoteRepo::modify($v['shop_goods_quote_id'],['goods_number'=>$quoteInfo['goods_number']+$v['goods_number']]);
                    }
                }
                $order_info = OrderInfoRepo::modify($data['id'],['order_status'=>0]);
            }
            if($data['order_status']==-1){ //删除订单
                $order_info = OrderInfoRepo::modify($data['id'], ['is_delete'=>1]);
            }
            if($data['order_status']==4){//确认收货
                //企业存库表
                //企业库存流水
                if($orderInfo['order_status'] == 3 && $orderInfo['shipping_status'] == 1){
                    $firmId = $orderInfo['firm_id'];
                    if($firmId==0){
                        $firmId = $orderInfo['user_id'];
                    }
                    foreach($orderGoodsInfo as $v){
                        $firmStockInfo = FirmStockRepo::getInfoByFields(['firm_id'=>$firmId,'goods_id'=>$v['goods_id']]);
                        $firmStockData = [];
                        $firmStockData['firm_id'] = $firmId;
                        $firmStockData['goods_id'] = $v['goods_id'];
                        $firmStockData['goods_name'] = $v['goods_name'];
                        $firmStockData['number'] = $v['goods_number'];
                        $firmStockData['flow_time'] = Carbon::now();
                        $firmStockData['order_sn'] = $orderInfo['order_sn'];
                        $firmStockData['created_by'] = $orderInfo['firm_id'];//管理员
                        $firmStockData['price'] = $v['goods_price'];
                        $firmStockData['partner_name'] = $orderInfo['shop_name'];
                        FirmStockFlowRepo::create($firmStockData);
                        if(!empty($firmStockInfo)){
                            FirmStockRepo::modify($firmStockInfo['id'],['number'=>$v['goods_number'] + $firmStockInfo['number']]);
                        }else{
                            $firmStockData = [];
                            $firmStockData['firm_id'] = $firmId;
                            $firmStockData['goods_id'] = $v['goods_id'];
                            $firmStockData['goods_name'] = $v['goods_name'];
                            $firmStockData['number'] = $v['goods_number'];
                            FirmStockRepo::create($firmStockData);
                        }
                    }
                    $order_info = OrderInfoRepo::modify($data['id'],['shipping_status'=>3,'order_status'=>5,'confirm_take_time'=>Carbon::now()]);
                }else{
                    self::throwBizError("订单未确认或发货状态有误");
                }
            }
            if($data['order_status']==3){ //商家确认
                $order_info = OrderInfoRepo::modify($data['id'], ['order_status'=>3, 'contract'=>$data["contract"]]);
                //保存订单合同
                $s_data['order_id'] = $data['id'];
                $s_data['contract'] = $data["contract"];
                $s_data['add_time'] = Carbon::now();
                $s_data['from_id'] = session('_admin_user_id');
                $s_data['from'] = 3;
                $s_data['ip'] = $data['ip'];
                $s_data['equipment'] = $data['equipment'];
                $s_data['is_delete'] = 0;
                OrderContractRepo::create($s_data);
            }
            //给管理员操作添加一条数据
            $logData = [
                'action_note'=>$action_note,
                'action_user'=>session()->get('_admin_user_info')['real_name'],
                'order_id'=>$orderInfo['id'],
                'order_status'=>$orderInfo['order_status'],
                'shipping_status'=>$orderInfo['shipping_status'],
                'pay_status'=>$orderInfo['pay_status'],
                'log_time'=>Carbon::now()
            ];
            $flag_order_log = OrderActionLogRepo::create($logData);
            if(!empty($order_info) && !empty($flag_order_log)){
                self::commit();
                return $order_info;
            }
            return false;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    //保存订单合同（编辑覆盖）
    public static function createOrderContract($data)
    {
        return OrderContractRepo::create($data);
    }

    //修改自动收货天数，添加日志信息
    public static function modifyAutoDeliveryTime($data)
    {
        try{
            self::beginTransaction();
            $order_flag = OrderInfoRepo::modify($data['id'], $data);
            //给管理员操作添加一条数据
            $logData = [
                'action_note'=>'修改自动收货天数为'.$order_flag['auto_delivery_time'].'天',
                'action_user'=>session()->get('_admin_user_info')['real_name'],
                'order_id'=>$order_flag['id'],
                'order_status'=>$order_flag['order_status'],
                'shipping_status'=>$order_flag['shipping_status'],
                'pay_status'=>$order_flag['pay_status'],
                'log_time'=>Carbon::now()
            ];
            $flag_order_log = OrderActionLogRepo::create($logData);
            if(!empty($order_flag) && !empty($flag_order_log)){
                self::commit();
                return $order_flag;
            }
            return false;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    //修改费用信息
    public static function modifyFee($data)
    {
        try{
            self::beginTransaction();
            //修改费用信息
            $order_Info = OrderInfoRepo::modify($data['id'], $data);
            //更新商品总金额
            $orderInfo = OrderInfoRepo::getInfo($order_Info['id']);
            $orderGoods = OrderGoodsRepo::getList([], ['order_id' => $orderInfo['id']]);//查询该订单的所有的商品
            $sum = 0;
            foreach ($orderGoods as $k => $v) {
                $sum += $v['goods_price'] * $v['goods_number'];
            }
            $order_amount = $sum+$orderInfo['shipping_fee']-$orderInfo['discount'];
            $flag_order_info = OrderInfoRepo::modify($order_Info['id'], ['goods_amount' => $sum,'order_amount'=>$order_amount]);

            //给管理员操作添加一条数据
            $logData = [
                'action_note'=>'修改运费为'.$order_Info['shipping_fee'].',修改折扣费用为'.$order_Info['discount'],
                'action_user'=>session()->get('_admin_user_info')['real_name'],
                'order_id'=>$order_Info['id'],
                'order_status'=>$order_Info['order_status'],
                'shipping_status'=>$order_Info['shipping_status'],
                'pay_status'=>$order_Info['pay_status'],
                'log_time'=>Carbon::now()
            ];
            $flag_order_log = OrderActionLogRepo::create($logData);
            if(!empty($order_Info) && !empty($flag_order_log) && !empty($flag_order_info)){
                self::commit();
                return $order_Info;
            }
            return false;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    //修改order_goods表的单价和数量,修改order_info订单总金额和商品总金额
    //{id: "456", goods_price: "300.00", goods_number: "120", order_id: "414"}
    public static function modifyOrderGoods($data)
    {
        try{
            self::beginTransaction();
            $order_goods_data = [
                'id'=>$data['id'],
                'goods_price'=>$data['goods_price'],
                'goods_number'=>$data['goods_number'],
            ];
            //修改order_goods表的单价和购买数量
            $order_goods = OrderGoodsRepo::modify($order_goods_data['id'], $order_goods_data);
            //修改order_info表的商品总金额
            $orderInfo = OrderInfoRepo::getInfo($data['order_id']);
            $orderGoods = OrderGoodsRepo::getList([], ['order_id' => $orderInfo['id']]);//查询该订单的所有的商品
            $sum = 0;
            foreach ($orderGoods as $k => $v) {
                $sum += $v['goods_price'] * $v['goods_number'];
            }
            $order_amount = $sum+$orderInfo['shipping_fee']-$orderInfo['discount'];
            $flag_order_info = OrderInfoRepo::modify($data['order_id'], ['goods_amount' => $sum,'order_amount'=>$order_amount]);

            //给管理员操作添加一条数据
            $logData = [
                'action_note'=>'商品'.$order_goods['goods_name'].'单价修改为'.$data['goods_price'].',数量修改为'.$data['goods_number'],
                'action_user'=>session()->get('_admin_user_info')['real_name'],
                'order_id'=>$data['order_id'],
                'order_status'=>$orderInfo['order_status'],
                'shipping_status'=>$orderInfo['shipping_status'],
                'pay_status'=>$orderInfo['pay_status'],
                'log_time'=>Carbon::now()
            ];
            $flag_order_log = OrderActionLogRepo::create($logData);
            if(!$order_goods || !$flag_order_info || !$flag_order_log){
                return false;
            }
            self::commit();
            return true;

        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }

    }

    //获取订单商品信息
    public static function getOrderGoodsByOrderId($order_id)
    {
        $order_goods = OrderGoodsRepo::getList([], ['order_id' => $order_id]);
        foreach ($order_goods as $k => $vo) {
            $good = GoodsRepo::getInfo($vo['goods_id']);
            $order_goods[$k]['brand_name'] = $good['brand_name'];
            $order_goods[$k]['packing_spec'] = $good['packing_spec'];
            $order_goods[$k]['goods_full_name'] = $good['goods_full_name'];
            $order_goods[$k]['unit_name'] = $good['unit_name'];
        }
        return $order_goods;
    }

    //获取商品信息(带总条数)
    public static function getOrderGoodsList($order_id)
    {
        $order_goods =  OrderGoodsRepo::getListBySearch([], ['order_id' => $order_id]);
        $order_info = OrderInfoRepo::getInfo($order_id);
        foreach ($order_goods['list'] as $k => $vo){
            $good = GoodsRepo::getInfo($vo['goods_id']);
            $order_goods['list'][$k]['brand_name'] = $good['brand_name'];
            $order_goods['list'][$k]['shop_name'] = $order_info['shop_name'];
            $order_goods['list'][$k]['packing_spec'] = $good['packing_spec'];
            $order_goods['list'][$k]['unit_name'] = $good['unit_name'];
            $order_goods['list'][$k]['goods_full_name'] = $good['goods_full_name'];
            $order_goods['list'][$k]['send_number_delivery'] = $vo['goods_number']-$vo['send_number'];
        }
        return $order_goods;
    }

    //判断orderid是否是user_id的
    public static function verifyOrderIds($order_ids,$user_id)
    {
        foreach ($order_ids as $k=>$v){
            $order_info = OrderInfoRepo::getList([],['id'=>$v,'user_id'=>$user_id]);
            if(empty($order_info)){
                return false;
            }
        }
        return true;
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
        $order_amount = $sum+$orderInfo['shipping_fee'] // 商品金额 运费
            +$orderInfo['insure_fee']+$orderInfo['pack_fee'] // 保费金额 包装费
            -$orderInfo['integral_money']-$orderInfo['bonus'] // 积分抵扣金额 红包抵扣金额
            -$orderInfo['bonus']-$orderInfo['discount']; // 红包抵扣金额 // 折扣金额
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

    public static function getOrderLogsByOrderidPagenate($pager,$condition)

    {
        return OrderActionLogRepo::getListBySearch($pager,$condition);
    }

    //查询操作日志信息
    public static function getOrderLogsByOrderid($order_id)
    {
        return OrderActionLogRepo::getList(['log_time'=>'desc'],['order_id'=>$order_id]);
    }

    //保存发货单相关信息
    public static function createDelivery($order_delivery_goods_data,$order_delivery_data,$action_name='')
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
                OrderInfoRepo::modify($orderDelivery['order_id'],['shipping_status'=>2,'shipping_time'=>Carbon::now()]);//部分发货
            }else{
                OrderInfoRepo::modify($orderDelivery['order_id'],['shipping_status'=>1,'shipping_time'=>Carbon::now()]);//全部发货
            }
            $order_Info = OrderInfoRepo::getInfo($orderDelivery['order_id']);
            //修改order_delivery的发货状态
            OrderDeliveryRepo::modify($orderDelivery['id'],['status'=>1]);
            //给管理员操作添加一条数据
            $logData = [
                'action_note'=>'生成发货单:'.$orderDelivery['delivery_sn'],
                'action_user'=>$action_name?$action_name:session()->get('_admin_user_info')['real_name'],
                'order_id'=>$order_Info['id'],
                'order_status'=>$order_Info['order_status'],
                'shipping_status'=>$order_Info['shipping_status'],
                'pay_status'=>$order_Info['pay_status'],
                'log_time'=>Carbon::now()
            ];
            OrderActionLogRepo::create($logData);
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
            $orderinfo = [];
            $orderinfo = OrderInfoRepo::getInfoByFields(['id'=>$v['order_id']]);
//            if (empty($orderinfo)){
////                self::throwBizError('订单不存在');
//                OrderDeliveryRepo::deleteByFields(['order_id'=>$v['order_id']]);
//            }
            if (!empty($orderinfo)){
                $delivery['list'][$k]['order_add_time'] = $orderinfo['add_time'];
            }
        }
        return $delivery;
    }

    //发货单详情
    public static function getDeliveryInfo($id)
    {
        $delivery = OrderDeliveryRepo::getInfo($id);
        $user = UserRepo::getList([],['id'=>$delivery['user_id']],['user_name'])[0];
        $order = OrderInfoRepo::getList([],['id'=>$delivery['order_id']],['add_time','shipping_fee'])[0];
        if (empty($order)){
            self::throwBizError('订单不存在');
        }
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
//            $shop_goods_quote = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
            //查询所属订单的商品信息
            $order_good = OrderGoodsRepo::getInfo($v['order_goods_id']);
            $deliveryGoods[$k]['goods_price'] = $order_good['goods_price']?$order_good['goods_price']:'';
            $deliveryGoods[$k]['goods_full_name'] = $order_good['goods_name']?$order_good['goods_name']:'';
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
                $data['update_time'] = Carbon::now();
                $order_delivery = OrderDeliveryRepo::modify($data['id'],$data);
                //修改发货时间
                OrderInfoRepo::modify($order_delivery['order_id'],['shipping_time'=>Carbon::now()]);
            self::commit();

            return $order_delivery;
        }catch(\Exception $e){
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

    //web 订单删除
    public static function orderDel($id){
        return OrderInfoRepo::modify($id,['is_delete'=>1]);
    }

    // 订单详情
    public static function orderDetails($id,$firmId){
        $orderInfo =  OrderInfoRepo::getInfoByFields(['order_sn'=>$id]);
        if($orderInfo['firm_id'] && $orderInfo['user_id']){
            if($firmId != $orderInfo['firm_id']){
                return '';
            }
        }else if($orderInfo['firm_id'] == 0 && $orderInfo['user_id']){
            if($firmId != $orderInfo['user_id']){
                return '';
            }
        }
        $goodsInfo = OrderGoodsRepo::getList([],['order_id'=>$orderInfo['id']]);

        $country = RegionRepo::getInfo($orderInfo['country']);
        $province = RegionRepo::getInfo($orderInfo['province']);
        $city = RegionRepo::getInfo($orderInfo['city']);
        $district = RegionRepo::getInfo($orderInfo['district']);

        $delivery_info = OrderDeliveryRepo::getList([],['order_id'=>$orderInfo['id']]);

        if($orderInfo['firm_id'] == 0){
            $userId  = $orderInfo['user_id'];
        }else{
            $userId  = $orderInfo['firm_id'];
        }
        //获取会员发票信息
        $userInvoceInfo = UserRealRepo::getInfoByFields(['user_id'=>$userId,'review_status'=>1]);
        return [
            'orderInfo'=>$orderInfo,
            'userInvoceInfo'=>$userInvoceInfo,
            'goodsInfo'=>$goodsInfo,
            'country'=>$country['region_name'],
            'province'=>$province['region_name'],
            'city'=>$city['region_name'],
            'district'=>$district['region_name'],
            'delivery_info'=>$delivery_info,
        ];
    }

    //企业订单审核通过操作
    public static function egis($id){
        return OrderInfoRepo::modify($id,['order_status'=>2]);
    }

    //根据shopid获取用户商家信息
    public static function getShopInfoByShopId($shopId){
        $shopInfo = ShopRepo::getInfo($shopId);
        if(empty($shopInfo) || $shopId <=0){
            self::throwBizError('商家信息不存在');
        }
        return $shopInfo;
    }


    //订单取消
    public static function orderCancel($id,$type){
        try{
            self::beginTransaction();
            //获取订单信息
            $orderInfo = self::getOrderInfoById($id);
            $orderGoodsInfo = OrderGoodsRepo::getList([],['order_id'=>$orderInfo['id']]);
            if(empty($orderInfo)){
                self::throwBizError('订单信息不存在');
            }

            //已确认订单取消返库存
            if($type != 'waitAffirm') {
                //根据来源返回库存
                if($orderInfo['extension_code'] == 'promote'){//限时抢购
                    $activityPromoteInfo = ActivityPromoteRepo::getInfo($orderInfo['extension_id']);
                    ActivityPromoteRepo::modify($orderInfo['extension_id'],['available_quantity'=>$activityPromoteInfo['available_quantity'] + $orderGoodsInfo[0]['goods_number']]);
                }elseif ($orderInfo['extension_code'] == 'wholesale'){//集采火拼 这边要减去活动已参与的数量
                    //减去已参与数量
                    $activityWholesaleInfo = ActivityWholesaleRepo::getInfo($orderInfo['extension_id']);
                    ActivityWholesaleRepo::modify($orderInfo['extension_id'], ['partake_quantity' => $activityWholesaleInfo['partake_quantity'] - $orderGoodsInfo[0]['goods_number']]);
                }elseif ($orderInfo['extension_code'] == 'consign'){//清仓特卖 这边要返回清仓特卖的 库存
                    foreach ($orderGoodsInfo as $k=>$v){
                        $quoteInfo = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
                        ShopGoodsQuoteRepo::modify($v['shop_goods_quote_id'],['goods_number'=>$quoteInfo['goods_number']+$v['goods_number']]);
                    }
                }else{//购物车下单

                    foreach ($orderGoodsInfo as $k=>$v){
                        $quoteInfo = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
                        ShopGoodsQuoteRepo::modify($v['shop_goods_quote_id'],['goods_number'=>$quoteInfo['goods_number']+$v['goods_number']]);
                    }

                }

            }
            OrderInfoRepo::modify($id,['order_status'=>0]);
            self::commit();
            return true;
        }catch (Exception $e){
            self::rollBack();
            throw $e;
        }
    }

    //订单确认收货
    public static function orderConfirmTake($id,$firmId,$userId){
        $flow_time = Carbon::now();
        $orderInfo = OrderInfoRepo::getInfo($id);
        if (empty($orderInfo)){
            self::throwBizError('订单信息不存在');
        }
        $orderGoodsInfo = OrderGoodsRepo::getList([],['order_id'=>$orderInfo['id']]);
        if(empty($orderGoodsInfo)){
            self::throwBizError('商品信息有误');
        }

        //企业存库表
        //企业库存流水
        if($orderInfo['order_status'] == 3 && $orderInfo['shipping_status'] == 1){
            try{
                self::beginTransaction();
                foreach($orderGoodsInfo as $v){
                    $firmStockInfo = FirmStockRepo::getInfoByFields(['firm_id'=>$firmId,'goods_id'=>$v['goods_id']]);
                    $firmStockData = [];
                    $firmStockData['firm_id'] = $firmId;
                    $firmStockData['goods_id'] = $v['goods_id'];
                    $firmStockData['goods_name'] = $v['goods_name'];
                    $firmStockData['number'] = $v['goods_number'];
                    $firmStockData['flow_time'] = $flow_time;
                    $firmStockData['order_sn'] = $orderInfo['order_sn'];
                    $firmStockData['created_by'] = $userId;
                    $firmStockData['price'] = $v['goods_price'];
                    $firmStockData['partner_name'] = $orderInfo['shop_name'];
                    FirmStockFlowRepo::create($firmStockData);
                    if(!empty($firmStockInfo)){
                        FirmStockRepo::modify($firmStockInfo['id'],['number'=>$v['goods_number'] + $firmStockInfo['number']]);
                    }else{
//                $goodsInfo = GoodsRepo::getInfo($v['goods_id']);
//                if(empty($goodsInfo)){
//                    self::throwBizError('商品信息不存在');
//                }
                        $firmStockData = [];
                        $firmStockData['firm_id'] = $firmId;
                        $firmStockData['goods_id'] = $v['goods_id'];
                        $firmStockData['goods_name'] = $v['goods_name'];
                        $firmStockData['number'] = $v['goods_number'];
                        FirmStockRepo::create($firmStockData);
                    }
                }
                 OrderInfoRepo::modify($id,['shipping_status'=>3,'order_status'=>5,'confirm_take_time'=>$flow_time]);
                 self::commit();
                 return true;
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }

        }
        self::throwBizError('订单状态有误!');
    }


    public static function createOrderSn()
    {
        return date('Ymd') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }


    //创建订单 type为cart 购物车下单    promote限时抢购
    public static function createOrder($cartInfo_session,$userId,$userAddressId,$words,$type,$smsType,$token="")
    {
        $addTime = Carbon::now();
        //生成的随机数
        $order_no = self::createOrderSn();
        $userAddressMes = UserAddressRepo::getInfo($userAddressId);
        try {
            self::beginTransaction();
            //订单表
            switch ($type) {
                case 'promote'://限时抢购
                    $order_status = 3;
                    $from = 'promote';
                    $extension_id = $cartInfo_session[0]['id'];
                    $deposit_status = 1;
                    $deposit = 0;
//                    $pay_type =  1;
                    break;
                case 'wholesale'://集采火拼
                    $order_status = 2;
                    $from = 'wholesale';
                    $extension_id = $cartInfo_session[0]['id'];
                    $deposit_status = 0;
                    $deposit = $cartInfo_session[0]['deposit'];
//                    $pay_type =  1;
                    break;
                case 'consign'://清仓特卖
                    $order_status = 2;
                    $from = 'consign';
                    $extension_id = $cartInfo_session[0]['id'];
                    $deposit_status = 1;
                    $deposit = 0;
//                    $pay_type =  1;
                    break;
                default://正常下单
                    $from = 'cart';
                    $extension_id = 0;
                    $deposit_status = 1;
                    $deposit = 0;
//                    $pay_type = $payType;
                    if (!$userId['firm_id']) {
                        $order_status = 2;
                    } else {
                        if(!$userId['need_approval']){
                            $order_status = 2;
                        }else{
                            $order_status = 1;
                        }
                    }
            }

            $orderInfo = [
                'order_sn' => $order_no,
                'user_id' => $userId['user_id'],
                'firm_id' => $userId['firm_id'],
                'order_status' => $order_status,
                'add_time' => $addTime,
                'address' => $userAddressMes['address'],
                'shop_id' => $cartInfo_session[0]['shop_id'],
                'shop_name' => $cartInfo_session[0]['shop_name'],
                'country' => 1,
                'zipcode' => $userAddressMes['zipcode'] ? $userAddressMes['zipcode'] : '',
                'mobile_phone' => $userAddressMes['mobile_phone'],
                'province' => $userAddressMes['province'],
                'city' => $userAddressMes['city'],
                'district' => $userAddressMes['district'],
                'consignee' => $userAddressMes['consignee'],
                'postscript' => $words ? $words : '',
                'extension_code' => $from,
                'extension_id' => $extension_id,
                'deposit_status' => $deposit_status,
                'deposit' => $deposit,
                'froms' => empty($token)?"pc":"weichat",
            ];

            $orderInfoResult = OrderInfoRepo::create($orderInfo);
            //订单总金额
            $goods_amount = 0;
            foreach ($cartInfo_session as $v) {
                $id = $v['id'];
                //购物车生成订单
                if ($type == 'promote') {
                    //限时抢购生产订单
                    $activityPromoteInfo = ActivityPromoteRepo::getInfo($id);
                    if (empty($activityPromoteInfo)) {
                        self::throwBizError('商品不存在！');
                    }
                    $orderGoods = [
                        'order_id' => $orderInfoResult['id'],
                        'goods_id' => $v['goods_id'],
                        'goods_name' => $v['goods_name'],
                        'shop_goods_quote_id' => $activityPromoteInfo['id'],
//                        'goods_sn'=>$cartInfo['goods_sn'],
                        'goods_number' => $v['goods_number'],
                        'goods_price' => $v['goods_price'],
                        'add_time' => Carbon::now()
                    ];
                    OrderGoodsRepo::create($orderGoods);
                    $goods_amount += $v['goods_number'] * $v['goods_price'];
                    //减去活动库存
                    ActivityPromoteRepo::modify($id, ['available_quantity' => $activityPromoteInfo['available_quantity'] - $v['goods_number']]);
                } elseif ($type == 'wholesale') {
                    //集采火拼生产订单
                    $activityWholesaleInfo = ActivityWholesaleRepo::getInfo($id);
                    if (empty($activityWholesaleInfo)) {
                        self::throwBizError('商品不存在！');
                    }
                    $orderGoods = [
                        'order_id' => $orderInfoResult['id'],
                        'goods_id' => $v['goods_id'],
                        'goods_name' => $v['goods_name'],
                        'shop_goods_quote_id' => $activityWholesaleInfo['id'],
//                        'goods_sn'=>$cartInfo['goods_sn'],
                        'goods_number' => $v['num'],
                        'goods_price' => $v['price'],
                        'add_time' => Carbon::now()
                    ];
                    OrderGoodsRepo::create($orderGoods);
                    $goods_amount += $v['num'] * $v['price'];
                    //增加已参与数量
//                    ActivityWholesaleRepo::modify($id, ['partake_quantity' => $activityWholesaleInfo['partake_quantity'] + $v['num']]);
                } elseif ($type == 'consign') {
                    $activityConsignInfo = ShopGoodsQuoteRepo::getInfo($id);
                    if (empty($activityConsignInfo)) {
                        self::throwBizError('商品不存在！');
                    }

                    $orderGoods = [
                        'order_id' => $orderInfoResult['id'],
                        'shop_goods_id' => $activityConsignInfo['goods_id'],
                        'shop_goods_quote_id' => $activityConsignInfo['id'],
                        'goods_id' => $activityConsignInfo['goods_id'],
                        'goods_name' => $activityConsignInfo['goods_name'],
                        'goods_sn' => $activityConsignInfo['goods_sn'],
                        'goods_number' => $activityConsignInfo['goods_number'],
                        'goods_price' => $activityConsignInfo['shop_price'],
                        'add_time' => Carbon::now()
                    ];
                    OrderGoodsRepo::create($orderGoods);
                    $goods_amount += $activityConsignInfo['goods_number'] * $activityConsignInfo['shop_price'];
                } else {
                    $cartInfo = CartRepo::getInfo($id);
                    if (empty($cartInfo)) {
                        self::throwBizError('商品不存在！');
                    }

                    $orderGoods = [
                        'order_id' => $orderInfoResult['id'],
                        'shop_goods_id' => $cartInfo['shop_goods_id'],
                        'shop_goods_quote_id' => $cartInfo['shop_goods_quote_id'],
                        'goods_id' => $cartInfo['goods_id'],
                        'goods_name' => $cartInfo['goods_name'],
                        'goods_sn' => $cartInfo['goods_sn'],
                        'goods_number' => $cartInfo['goods_number'],
                        'goods_price' => $cartInfo['goods_price'],
                        'add_time' => Carbon::now()
                    ];
                    OrderGoodsRepo::create($orderGoods);
                    $goods_amount += $cartInfo['goods_number'] * $cartInfo['goods_price'];

                    //删除购物车的此纪录
                    CartRepo::delete($id);
                }
            }
            //更新订单总金额
            $orderInfo_s = self::getOrderInfoById($orderInfoResult['id']);
            $saveOrderInfo = OrderInfoRepo::modify(
                $orderInfoResult['id'],
                [
                    'goods_amount' => $goods_amount,
                    'order_amount' => $goods_amount+$orderInfo_s['shipping_fee'] // 商品金额 运费
                                      +$orderInfo_s['insure_fee']+$orderInfo_s['pack_fee'] // 保费金额 包装费
                                      -$orderInfo_s['integral_money']-$orderInfo_s['bonus'] // 积分抵扣金额 红包抵扣金额
                                      -$orderInfo_s['bonus']-$orderInfo_s['discount'] // 红包抵扣金额 // 折扣金额

//                    'shop_name'=>$cartInfo['shop_name']
                ]
            );
            self::commit();
            self::sms_listen_order($userId['user_name'],$smsType,$saveOrderInfo['order_amount']);
            return $order_no;
        } catch (\Exception $e) {
            self::rollBack();
            throw $e;
        }
    }

    //短信通知订单
    public static function sms_listen_order($user_name,$type,$account)
    {
        if (!empty(getConfig('remind_mobile')) && getConfig('open_user_order')) {
            createEvent('sendSms', ['phoneNumbers' => getConfig('remind_mobile'), 'type' => 'sms_listen_order', 'tempParams' => ['phone' => $user_name, 'type' => $type, 'amount'=>$account]]);
        }
    }

    //获取当天订单总数
    public static function getOrdersCount()
    {
        //获取当日开始时间戳和结束时间戳
        $today_start=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $today_end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $condition['add_time|<'] = date("Y-m-d H:i:s",$today_end);
        $condition['add_time|>'] = date("Y-m-d H:i:s",$today_start);
        return OrderInfoRepo::getTotalCount($condition);
    }

    //查询当日销售总额
    public static function gettotalAccount()
    {
        $today_start=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $today_end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $condition['add_time|<'] = date("Y-m-d H:i:s",$today_end);
        $condition['add_time|>'] = date("Y-m-d H:i:s",$today_start);
        $orders = OrderInfoRepo::getList([],$condition,['goods_amount']);
        $sum = 0;
        foreach($orders as $k=>$v){
            $sum+=$v['goods_amount'];
        }
        return $sum;
    }

    //统计当月的订单量
    public static function getMonthlyOrders()
    {
        $a = date("Y-m-1"); //当月第一天
        $b = date("Y-m-d"); //当月当天
        $res = OrderInfoRepo::getEveryMonthOrderCount($a,$b);
        return $res;
    }


    //付款凭证提交
    public static function payVoucherSave($orderSn,$payVoucher,$deposit){
        $orderSn = decrypt($orderSn);
        $orderInfo = OrderInfoRepo::getInfoByFields(['order_sn'=>$orderSn]);
        if(empty($orderInfo)){
            self::throwBizError('订单信息不存在');
        }
        if($deposit){
            return OrderInfoRepo::modify($orderInfo['id'],['deposit_pay_voucher'=>$payVoucher]);
        }else{
            return OrderInfoRepo::modify($orderInfo['id'],['pay_voucher'=>$payVoucher]);
        }

    }

    //付款凭证提交
    public static function payVoucherSaveApi($orderSn,$payVoucher){
        $orderInfo = OrderInfoRepo::getInfoByFields(['order_sn'=>$orderSn]);
        if(empty($orderInfo)){
            return false;
        }
        return OrderInfoRepo::modify($orderInfo['id'],['pay_voucher'=>$payVoucher]);
    }

    /**
     * @param $seller_id
     * @return mixed
     */
    public static function getCharsData($seller_id)
    {
        $condition['shop_id'] = $seller_id;
        $b = date('Y');
        $e = date('Y-m-d H:i:s');
        $condition['shop_id']=$seller_id;
//        //待确认数量
//        $waitAffirm = array_merge($condition, self::setStatueCondition('waitAffirm'));
//        $data['waitAffirm'] = OrderInfoRepo::getCurrYearEveryMonth($b,$e,$waitAffirm);

        //待付款数量
        $waitPay = array_merge($condition, self::setStatueCondition('waitPay'));
        $data['waitPay'] = OrderInfoRepo::getCurrYearEveryMonth($b,$e,$waitPay);
        //待发货数量
        $waitSend = array_merge($condition, self::setStatueCondition('waitSend'));
        $data['waitSend'] = OrderInfoRepo::getCurrYearEveryMonth($b,$e,$waitSend);

        //已完成
        $finished = array_merge($condition, self::setStatueCondition('finish'));
        $data['finished'] = OrderInfoRepo::getCurrYearEveryMonth($b,$e,$finished);
        return $data;
    }

    /**
     * 检测报价是否存在订单
     * checkQuoteExistOrder
     * @param $quote_id
     * @return bool
     */
    public static function checkQuoteExistOrder($quote_id)
    {
        $res = OrderGoodsRepo::getTotalCount(['shop_goods_quote_id'=>$quote_id]);
        if($res>0){
            return true;
        }
        return false;
    }
    /**
     * 检测活动是否存在订单
     * checkActivityExistOrder
     * @param $extension_id
     * @param $extension_code
     * @return bool
     */
    public static function checkActivityExistOrder($extension_id,$extension_code)
    {
        $where = [
            'extension_id'=>$extension_id,
            'extension_code'=>$extension_code,
        ];
        $res = OrderInfoRepo::getTotalCount($where);
        if($res>0){
            return true;
        }
        return false;
    }


    /**
     * 获取时间段内订单数和成交金额
     * @param $start
     * @param $end
     * @param $shop_id
     * @return mixed
     */
    public static function getSalesVolumeOfTme($start,$end,$shop_id)
    {
        $condition = [
            'is_delete'=>0,
            'order_status'=>4,
            'shop_id'=>$shop_id
        ];
       $re = OrderInfoRepo::getCountAndSumPrice($start,$end,$condition);
       if (!empty($re)){
           return $re;
       }
    }

    /**
     * 更新订单状态
     * @param $order_data
     * @return bool
     * @throws Exception
     */
    public static function updateOrderStatus($order_data)
    {
        $orderInfo = OrderInfoService::getOrderInfoByWhere(['id'=>$order_data['order_id'],'shop_id'=>$order_data['shop_id']]);
        if (!empty($orderInfo)) {
            $data = ['id' => $order_data['order_id']];
            // 确认订单
            if ($order_data['order_status'] == 3) {
                if ($orderInfo['extension_code'] == 'cart' || $orderInfo['extension_code'] == 'consign') {
                    $re_rock = ShopGoodsQuoteService::updateStock($order_data['order_id']);
                    if (!$re_rock) {
                        self::throwBizError('库存不足，无法确认');
                    }
                }
                if ($orderInfo['order_status'] != 2) {
                    self::throwBizError('订单状态不符合执行该操作的条件');
                }
                $data['confirm_time'] = Carbon::now();
                $data['order_status'] = $order_data['order_status'];
                // 交货时间
                if (!empty($delivery_period)) {
                    if ($orderInfo['order_status'] != 2) {
                        self::throwBizError('订单状态不符合执行该操作的条件');
                    }
                    $data['delivery_period'] = $delivery_period;
                    if (empty($order_data['action_note'])) {
                        $order_data['action_note'] = "修改交货时间";
                    }
                }
            }
            // 取消订单
            if ($orderInfo['order_status']!='' && $orderInfo['order_status']==0 ) {
                $re = OrderInfoService::orderCancel($orderInfo['order_id'],$orderInfo['extension_code']);
                if ($re==true){
                    $data['order_status'] = $orderInfo['order_status'];
                    $data['to_buyer'] =$orderInfo['to_buyer'];
                    if (empty($order_data['action_note'])){
                        $action_note = "取消订单";
                    }
                }

            }
            $pay_error = '';
            // 付款
            if (!empty($order_data['pay_status']) && $order_data['pay_status']>0){
                if ($orderInfo['shipping_status']==3){
                    $data['order_status'] = 4;
                }
                $data['pay_status'] = $order_data['pay_status'];
                if ($order_data['pay_status']==1){
                    $data['money_paid'] = $orderInfo['order_amount'];
                }

//                if (!empty($pay_number)&&$pay_number>0) {
//                    // 剩余应付金额
//                    $paid = $orderInfo['goods_amount']+$orderInfo['shipping_fee']-$orderInfo['discount']-$orderInfo['money_paid'];
//                    if ($orderInfo['deposit_status']==1){
//                        $paid = $paid + $orderInfo['deposit'];
//                    }
//                    if ($paid<=0){
//                        return $this->error('款已收齐，请不要重复操作');
//                    }
//                    // 部分付款
//                    if ($pay_number<$paid){
//                        $data['money_paid'] = $orderInfo['money_paid']+$pay_number;
//                        $data['pay_status'] = 2;
//                    // 全款
//                    } else if ($pay_number==$paid){
//                        $data['money_paid'] = $orderInfo['money_paid']+$pay_number;
//                        $data['pay_status'] = 1;
//                        // 当款已收齐 检查是否已确认收货 则变更订单转态 5 待开票
//                        if ($orderInfo['shipping_status'] == 3) {
//                            $data['order_status'] = 5;
//                        }
//                    // 当付款金额大于订单金额时 为商家准备
//                    } else if ($pay_number>$paid){
//                        $data['money_paid'] = $orderInfo['goods_amount']+$orderInfo['shipping_fee']-$orderInfo['discount'];// 订单总金额
//                        $data['pay_status'] = 1;
//                        // 当款已收齐 检查是否已确认收货 则变更订单转态 5 待开票
//                        if ($orderInfo['shipping_status'] == 3) {
//                            $data['order_status'] = 5;
//                        }
//                        $pay_error = "填写的金额超过订单总金额，已自动调整";
//                    }
//                    // 已收款&&已收货 变更订单 待开票
                $data['pay_time'] = Carbon::now();
                $action_note = "商家确认收款";
            }
            // 收定金
            if (!empty($order_data['deposit_status'])){
                if ($orderInfo['order_status'] != 2) {
                    self::throwBizError('订单状态不符合执行该操作的条件');
                }
                if ($order_data['extension_code']=='wholesale'){
                    $rs = ActivityWholesaleService::addPartakeQuantity($orderInfo['order_id']);
                    if (!$rs){
                        self::throwBizError('参数错误');
                    }
                }
                $data['pay_time'] = Carbon::now();
                $data['deposit_status'] = $order_data['deposit_status']?$order_data['deposit_status']:1;
                $data['money_paid'] = $orderInfo['money_paid']+$orderInfo['deposit'];

                if (empty($order_data['action_note'])) {
                    $action_note = "确认收到定金";
                }
            }
            // 确认订单是上传合同
            if(array_key_exists('order_status',$data) && !empty($data['order_status']) && $data['order_status']==3){
                if (empty($order_data['contract'])){
                    self::throwBizError('合同不能为空');
                }
                $data['contract']=$order_data['contract'];
                $contract_data = [
                    'add_time'=>Carbon::now(),
                    'order_id'=> $order_data['order_id'],
                    'from_id'=> $order_data['shop_id'],
                    'from'=> 2,
                    'contract'=>$order_data['contract'],
                    'ip'=> $order_data['ip'],
                    'equipment'=>$order_data['userAgent'],
                ];
                // 开启事务
                $re = OrderInfoService::modify($data, $contract_data);
            } else {
                $re = OrderInfoService::modify($data);
            }

            if (!empty($re)) {
                if (empty($action_note)) {
                    $action_note = "修改订单状态";
                }
                //存储日志信息
                $logData = [
                    'action_note' => $action_note,
                    'action_user' => session('_seller')['user_name'],
                    'order_id' => $order_data['order_id'],
                    'order_status' => $re['order_status'],
                    'shipping_status' => $re['shipping_status'],
                    'pay_status' => $re['pay_status'],
                    'log_time' => Carbon::now()
                ];

                OrderInfoService::createLog($logData);
                if ($pay_error){
                    self::throwBizError($pay_error);
                }
               return $re;
            }
        } else {
            self::throwBizError('订单信息错误，或订单不存在');
        }
    }
}
