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

    /**
     * 获取店铺已报价产品数据
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

    //根据条件获取符合条件的报价分类
    public static function getQuoteCategory($condition){
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b');
        $query = self::setCondition($query, $condition);
        $cats = $query->join('goods as g', 'b.goods_id', '=', 'g.id')->groupBy('g.cat_id')->select('g.cat_id')->pluck('cat_id');
        if (!empty($cats)){
            return $cats->toArray();
        }
        return [];
    }

    //根据条件获取符合条件的报价品牌
    public static function getQuoteBrand($condition){
        $clazz_name = self::getBaseModel();
        $clazz = new $clazz_name();
        $query = \DB::table($clazz->getTable().' as b');
        $query = self::setCondition($query, $condition);
        $rs = $query->join('goods as g', 'b.goods_id', '=', 'g.id')->groupBy('g.brand_id')->select('g.brand_id')->pluck('brand_id');
        if (!empty($rs)){
            return $rs->toArray();
        }
        return [];
    }

    //根据条件获取符合条件的报价发货地
    public static function getQuoteCity($condition){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        $query = self::setCondition($query, $condition);
        $rs = $query->groupBy('place_id')->pluck('place_id');
        if (!empty($rs)){
            return $rs->toArray();
        }
        return [];
    }
}

