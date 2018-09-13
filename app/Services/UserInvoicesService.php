<?php
namespace App\Services;

use App\Repositories\UserInvoicesRepo;
class UserInvoicesService
{
    use CommonService;

    //根据user_id获取发票信息
    public static function getInfoByUserId($user_id)
    {
        return UserInvoicesRepo::getInfoByFields(['user_id'=>$user_id]);
    }


}