<?php
namespace App\Services;
use App\Repositories\LogisticsRepo;
class LogisticsService
{
    use CommonService;

    //分页
    public static function getLogistics($pager,$condition)
    {
        return LogisticsRepo::getListBySearch($pager,$condition);
    }

    //获取一条数据
    public static function getLogisticInfo($id)
    {
        return LogisticsRepo::getInfo($id);
    }

}