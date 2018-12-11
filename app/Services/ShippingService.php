<?php
namespace App\Services;

use App\Repositories\ShippingRepo;

class ShippingService
{
    use CommonService;
    //获取所有的信息
    public static function getList()
    {
        return ShippingRepo::getList();
    }

    public static function getListBySearch($pager, $condition)
    {
        return ShippingRepo::getListBySearch($pager, $condition);
    }
    //根据id获取一条信息
    public static function getInfo($id)
    {
        return ShippingRepo::getInfo($id);
    }

    public static function modify($data)
    {
       return ShippingRepo::modify($data['id'],$data);
    }

    public static function getInfoByType($type)
    {
        return ShippingRepo::getInfoByFields(['type'=>$type]);
    }

    public static function create($data)
    {
        return ShippingRepo::create($data);
    }

}