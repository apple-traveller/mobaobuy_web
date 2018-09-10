<?php

namespace App\Services\Admin;

use App\Services\CommonService;
use App\Repositories\UserLogRepo;

class UserLogService extends CommonService
{
    //获取日志列表（分页）
    public static function getLogs($user_id,$pageSize)
    {
        return UserLogRepo::getLogs($user_id,$pageSize);
    }

    //获取日志总条数
    public static function getLogCount($user_id)
    {
        return UserLogRepo::getLogCount($user_id);
    }





}