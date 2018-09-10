<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class SeoRepo
{
    use CommonRepo;

    public static function getList()
    {
        $model = self::getBaseModel();
        $info = $model::get();
        if($info){
            return $info->toArray();
        }
        return [];

    }


}