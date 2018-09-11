<?php

namespace App\Services;
use App\Repositories\FirmLogRepo;
class FirmLogService
{
    use CommonService;
    //获取日志信息
    public static function getLogInfo($id,$pageSize)
    {
        return FirmLogRepo::getLogInfo($id,$pageSize);
    }

    //获取日志总条数
    public static function getLogCount($id)
    {
        return FirmLogRepo::getLogCount($id);
    }
   


}