<?php
namespace App\Services;
use App\Repositories\ShopGoodsQuoteRepo;

class ShopGoodsQuoteService
{
    use CommonService;
    //获取报价列表
    public static function goodsQuoteList(){
        return ShopGoodsQuoteRepo::goodsQuoteList();
    }

}