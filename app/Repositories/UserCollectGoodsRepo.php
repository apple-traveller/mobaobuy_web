<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class UserCollectGoodsRepo
{
    use CommonRepo;
    //获取收藏列表
    public static function userCollectGoodsList($id){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('user_id',$id)->paginate(1);
    }

}