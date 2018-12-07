<?php
namespace App\Services;
use App\Repositories\OrderContractRepo;
class OrderContractService
{
    use CommonService;

    public static function create($data)
    {
        return OrderContractRepo::create($data);
    }

    //根据order_id获取最新一条合同
    public static function getInfoByOrderId($order_id)
    {
        $condition = [
            'order_id'=>$order_id,
            'is_delete'=>0,
        ];
        $order_contact = OrderContractRepo::getList(['add_time'=>'desc'],$condition);
        if(!empty($order_contact)){
            return $order_contact[0];
        }else{
            return "";
        }
    }
}