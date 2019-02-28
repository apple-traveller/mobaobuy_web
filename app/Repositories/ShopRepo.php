<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-19
 * Time: 14:40
 */
namespace App\Repositories;

class ShopRepo
{
    use CommonRepo;

    public static function addVisitCount($shop_id)
    {
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('id',$shop_id)->increment('visit_count');
    }
}
