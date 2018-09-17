<?php
namespace App\Services;
use App\Repositories\BrandRepo;
class BrandService
{
    use CommonService;

    //分页
    public static function getBrandList($pager,$condition)
    {
        return BrandRepo::getListBySearch($pager,$condition);
    }

    //修改
    public static function modify($id,$data)
    {
        return BrandRepo::modify($id,$data);
    }

    //获取一条数据
    public static function getBrandInfo($id)
    {
        return BrandRepo::getInfo($id);
    }

}