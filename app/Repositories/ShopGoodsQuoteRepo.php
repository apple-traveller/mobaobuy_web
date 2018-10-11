<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class ShopGoodsQuoteRepo
{
    use CommonRepo;
    //获取报价列表
    public static function goodsQuoteList(){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->paginate(5);
    }

}