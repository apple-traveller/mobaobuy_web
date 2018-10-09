<?php
namespace App\Services;
use App\Repositories\OrderInfoRepo;
class OrderInfoService
{
    use CommonService;

    //列表（分页）
    public static function getOrderInfoList($pager,$condition)
    {
        return OrderInfoRepo::getListBySearch($pager,$condition);
    }

    //查询一条数据
    public static function getOrderInfoById($id)
    {
        return OrderInfoRepo::getInfo($id);
    }
}