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

    public static function getTopShopWidthUpdate($condition, $top = 10){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $query = self::setCondition($query, $condition);
        $rs = $query->orderBy('add_time','desc')->groupBy('shop_id')->take($top)->get(['shop_id']);
        if($rs){
            return $rs->toArray();
        }
        return [];
    }

    //获取报价列表
    public static function goodsQuoteList(){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->paginate(5);
    }

    /**
     * 获取商家报价列表-没有分页
     * @param $shop_id
     * @return mixed
     */
    public static function getQuoteGoods($shop_id)
    {
        $model = self::getBaseModel();
        $list = $model::where('shop_id',$shop_id)->groupBy('goods_id')->get();
        if (!empty($list)){
            return $list->toArray();
        }
    }
}

