<?php
namespace App\Services;
use App\Repositories\UserAccountLogRepo;
class UserAccountLogService
{
    use CommonService;

    public static function getInfoByUserId($pager,$condition)
    {
        return UserAccountLogRepo::getListBySearch($pager,$condition);
    }

}