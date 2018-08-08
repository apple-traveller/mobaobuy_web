<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

use App\Models\UserModel;
use App\Models\UserLogModel;


class UserRepository
{
    use CommonRepository;


    public static function getInfoByLoginName($login_name){
        $model = self::getBaseModel();
        $info = $model::where('user_name', $login_name)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }

    public static function createLog($userLog){
        $clazz = new UserLogModel();
        foreach ($userLog as $k => $v) {
            $clazz->$k = $v;
        }
        $clazz->save();
        return $clazz->toArray();
    }






}