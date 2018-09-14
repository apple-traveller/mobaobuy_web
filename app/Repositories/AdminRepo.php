<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class AdminRepo
{
    use CommonRepo;

    public static function getInfoByLoginName($login_name)
    {
        $model = self::getBaseModel();
        $info = $model::where('user_name', $login_name)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }
}