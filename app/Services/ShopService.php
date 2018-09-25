<?php
namespace App\Services;
use App\Repositories\ShopRepo;
class ShopService
{
    use CommonService;

    //查询分页
    public static function getShopList($pager,$condition)
    {
        return ShopRepo::getListBySearch($pager,$condition);
    }


}