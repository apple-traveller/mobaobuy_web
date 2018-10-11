<?php
namespace App\Services;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\ShopGoodsRepo;

class ShopGoodsQuoteService
{
    use CommonService;
    //获取报价列表
    public static function goodsQuoteList(){
        return ShopGoodsQuoteRepo::goodsQuoteList();
    }

    //分页
    public static function getShopGoodsQuoteList($pager,$condition)
    {
        $result = ShopGoodsQuoteRepo::getListBySearch($pager,$condition);
       /* foreach($result['list'] as $vo){

        }*/
       return $result;
    }

    //保存
    public static function create($data)
    {
        return ShopGoodsQuoteRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return ShopGoodsQuoteRepo::modify($data['id'],$data);
    }

    //获取一条数据
    public static function getShopGoodsQuoteById($id)
    {
        return ShopGoodsQuoteRepo::getInfo($id);
    }

    //删除
    public static function delete($id)
    {
        return ShopGoodsQuoteRepo::delete($id);
    }

    /**
     * 商户报价的商品
     * @param $shop_id
     * @return mixed
     */
    public static function getQuoteGoods($shop_id)
    {
        return ShopGoodsQuoteRepo::getQuoteGoods($shop_id);
    }
}

