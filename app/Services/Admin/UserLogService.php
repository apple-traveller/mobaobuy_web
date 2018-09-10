<?php

namespace App\Services\Admin;

use App\Services\CommonService;
use App\Repositories\UserLogRepository;

class UserLogService extends CommonService
{
    //获取日志列表（分页）
    public static function getLogs($user_id,$pageSize)
    {
        return UserLogRepository::getLogs($user_id,$pageSize);
    }

    //获取日志总条数
    public static function getLogCount($user_id)
    {
        return UserLogRepository::getLogCount($user_id);
    }





}