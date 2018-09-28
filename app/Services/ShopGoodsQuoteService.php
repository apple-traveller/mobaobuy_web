<?php
namespace App\Services;
use App\Repositories\ShopGoodsQuoteRepo;
class ShopGoodsQuoteService
{
    use CommonService;

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

}