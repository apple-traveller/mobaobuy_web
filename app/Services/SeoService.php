<?php
namespace App\Services;
use App\Repositories\SeoRepo;
class SeoService
{
    use CommonService;
    //获取所有的配置信息
    public static function getList()
    {
        return SeoRepo::getList();
    }

    //根据id获取一条信息
    public static function getInfo($id)
    {
        return SeoRepo::getInfo($id);
    }

    public static function modify($data)
    {
       return SeoRepo::modify($data['id'],$data);
    }


}