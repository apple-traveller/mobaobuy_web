<?php
namespace App\Services;

use App\Repositories\UserAddressRepo;
class UserAddressService
{
    use CommonService;

    //获取用户收货地址列表
    public static function getInfoByUserId($userid)
    {
        return UserAddressRepo::getList(['id'=>'desc'],['user_id'=>$userid]);
    }

}