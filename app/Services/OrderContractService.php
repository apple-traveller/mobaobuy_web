<?php
namespace App\Services;
use App\Repositories\OrderContractRepo;
class OrderContractService
{
    use CommonService;

    public static function getList($order, $condition)
    {
        return OrderContractRepo::getList($order, $condition);
    }

    public static function getListBySearch($pager, $condition)
    {
        $res = OrderContractRepo::getListBySearch($pager, $condition);
        if($res['total'] > 0){
            foreach ($res['list'] as $k=>$v){
                #获取订单编号
//                $order_info =
                #获取来源用户信息
            }
        }

        return $res;
    }
}