<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class CartRepo
{
    use CommonRepo;
     //购物车列表
    public static function cartList($userId){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('user_id',$userId)->paginate(10);
    }
}