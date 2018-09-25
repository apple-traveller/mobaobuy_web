<?php
namespace App\Services;
use App\Repositories\ShopRepo;
use App\Repositories\UserRepo;
class ShopService
{
    use CommonService;

    //查询分页
    public static function getShopList($pager,$condition)
    {
        return ShopRepo::getListBySearch($pager,$condition);
    }

    //查询用户
    public static function getUserList($condition)
    {
        return UserRepo::getListBySearch([],$condition);
    }


}