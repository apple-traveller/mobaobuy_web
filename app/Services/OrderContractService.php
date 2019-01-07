<?php
namespace App\Services;
use App\Repositories\OrderContractRepo;

use App\Repositories\OrderInfoRepo;
use Carbon\Carbon;

class OrderContractService
{
    use CommonService;
    public static function checkOrderContract($data){
        if($data['order_id'] == '' || $data['from_id'] == ''){
            self::throwBizError('上传出错，请重试');
        }
        $data['add_time'] = Carbon::now();
        $data['from'] = 1;
        $data['is_delete'] = 0;
        try{
            self::beginTransaction();
            OrderContractRepo::create($data);
            OrderInfoRepo::modify($data['order_id'],['contract'=>$data['contract']]);
            self::commit();
        }catch (\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }

    }

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
