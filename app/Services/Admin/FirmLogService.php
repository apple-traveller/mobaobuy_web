<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\FirmLogRepository;
class FirmLogService extends BaseService
{
    //获取日志信息
    public static function getLogInfo($id,$pageSize)
    {
        return FirmLogRepository::getLogInfo($id,$pageSize);
    }

    //获取日志总条数
    public static function getLogCount($id)
    {
        return FirmLogRepository::getLogCount($id);
    }
   


}