<?php

namespace App\Repositories;
class GoodsRepo
{
    use CommonRepo;

    //通过id获取商品信息
    public static function userCollectGoodsList($goodsId){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->whereIn('id',$goodsId)->paginate(10);
    }

    //获取商品列表
    public static function goodsList(){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->paginate(3);
    }


}
