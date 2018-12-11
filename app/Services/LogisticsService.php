<?php
namespace App\Services;

use App\Repositories\LogisticsRepo;
use App\Repositories\OrderDeliveryRepo;

class LogisticsService
{
    use CommonService;

    /**
     * 分页列表
     * @param $pager
     * @param $condition
     * @return mixed
     */
    public static function getLogistics($pager,$condition)
    {
        return LogisticsRepo::getListBySearch($pager,$condition);
    }

    public static function getList($order, $condition)
    {
        return LogisticsRepo::getList($order, $condition);
    }
    //获取一条数据
    public static function getLogisticInfo($id)
    {
        return LogisticsRepo::getInfo($id);
    }


    //编辑
    public static function modify($data)
    {
        return LogisticsRepo::modify($data['id'],$data);
    }

    //保存
    public static function create($data)
    {
        return LogisticsRepo::create($data);
    }

    //验证
    public static function validateShippingNo($shipping_billno)
    {
        $flag = OrderDeliveryRepo::getInfoByFields(['shipping_billno'=>$shipping_billno]);
        if(!empty($flag)){
            self::throwBizError('该运单号已存在');
        }else{
            return true;
        }
    }

}



