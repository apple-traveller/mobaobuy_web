<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
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

    public static function productTrend(){
        $res = \DB::table('shop_goods_quote')
            ->select(
                '*',
                DB::raw('left(add_time,10) as t'),
                DB::raw('max(shop_price) as max_p'),
                DB::raw('min(shop_price) as min_p')
            )
            ->groupBy('t')->get()->toArray();
        return $res;
    }


}
