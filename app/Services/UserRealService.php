<?php
namespace App\Services;

use App\Repositories\UserRealRepo;

class UserRealService
{
    use CommonService;



    //查询一条数据
    public static function getInfoByUserId($userid)
    {
        return UserRealRepo::getInfoByFields(['user_id'=>$userid]);
    }

    //查询一条数据
    public static function getInfo($id)
    {
        return UserRealRepo::getInfo($id);
    }

    //修改
    public static function modify($data)
    {
        return UserRealRepo::modify($data['id'],$data);
    }


}