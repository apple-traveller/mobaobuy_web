<?php
namespace App\Services;

use App\Repositories\UserLogRepo;

class UserLogService
{
    use CommonService;

    public static function create($data)
    {
        return UserLogRepo::create($data);
    }

}