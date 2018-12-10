<?php
namespace App\Services;

use App\Repositories\LogisticsRepo;

class LogisticsService
{
    use CommonService;

    /**
     * 分页列表
     * @param $pager
     * @param $condition
     * @return mixed
     */
    public static function getListWithPage($pager,$condition)
    {
        return LogisticsRepo::getListBySearch($pager,$condition);
    }

    /**
     * 获取详情
     * @param $where
     * @return array
     */
    public static function getDetailByWhere($where)
    {
        return LogisticsRepo::getInfoByFields($where);
    }


    //获取一条数据
    public static function getLogisticInfo($id)
    {
        return LogisticsRepo::getInfo($id);
    }

}

