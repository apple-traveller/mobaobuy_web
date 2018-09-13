<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class UserAccountLogRepo
{
    use CommonRepo;





    public static function getInfoByUserName($user_name){
        $model = self::getBaseModel();
        $info = $model::where('user_name', $user_name)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }




    public static function create($data)
    {
        $clazz = self::getBaseModel();
        $info = new $clazz();
        foreach ($data as $k => $v) {
            $info->$k =$v;
        }
        $info->save();

        return $info->toArray();
    }



}