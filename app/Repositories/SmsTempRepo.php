<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-14
 * Time: 15:17
 */
namespace App\Repositories;

class SmsTempRepo
{
    use CommonRepo;

    public static function getTemp($where)
    {
        $model = self::getBaseModel();
        $temp = $model::where('supplier_id',$where['supplier_id'])
                        ->where('type_code','like',$where['type_code'])
                        ->first();
        if ($temp){
            return $temp->toArray();
        }
        return [];
    }
}
