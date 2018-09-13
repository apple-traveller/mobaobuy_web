<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-12
 * Time: 11:16
 */
namespace App\Repositories;

class SmsSupplierRepo
{
    use CommonRepo;

    public static function getSupplier($where)
    {
        $model = self::getBaseModel();
        $info = $model::getInfoByFields($where);
        if ($info){
            return $info->toArray();
        }
        return [];
    }

}
