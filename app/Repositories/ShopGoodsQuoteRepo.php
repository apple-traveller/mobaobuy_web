<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
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

    public static function getQuoteGoods($shop_id)
    {
        $model = self::getBaseModel();
        $list = $model::where('shop_id',$shop_id)->groupBy('goods_id')->get();
        if (!empty($list)){
            return $list->toArray();
        }
    }
}

