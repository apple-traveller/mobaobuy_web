<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class AdminLogRepo
{
    use CommonRepo;

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