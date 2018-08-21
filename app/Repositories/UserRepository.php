<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class UserRepository
{
    use CommonRepository;

    //根据用户名称查
    public static function getInfoByUserName($user_name){
        $model = self::getBaseModel();
        $info = $model::where('user_name', $user_name)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }


}