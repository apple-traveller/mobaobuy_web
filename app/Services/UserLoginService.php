<?php

namespace App\Services;

use App\Repositories\UserLogRepo;
use App\Repositories\UserRepo;
use App\Repositories\UserRealRepo;
use App\Repositories\FirmLogRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Repositories\FirmRepo;
use App\Repositories\FirmBlacklistRepo;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class UserLoginService
{
    use CommonService;



    //
    public static function getInfo($id)
    {
        return UserRepo::getInfo($id);
    }







    //完善信息
    public static function updateUserInfo($id, $data)
    {
        return UserRepo::modify($id, $data);
    }


    //管理员后台
    //获取日志列表（分页）
    public static function getUserLogs($pager,$condition)
    {
        return UserLogRepo::getListBySearch($pager, $condition);
    }



}