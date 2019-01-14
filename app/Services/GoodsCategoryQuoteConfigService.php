<?php
namespace App\Services;

use App\Repositories\GoodsCategoryQuoteConfigRepo;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\GoodsRepo;

class GoodsCategoryQuoteConfigService
{
    use CommonService;
    //分类添加
    public static function categoryCreate($data){
        return GoodsCategoryQuoteConfigRepo::create($data);
    }

    //编辑
    public static function categoryUpdate($id,$data){
        return GoodsCategoryQuoteConfigRepo::modify($id,$data);
    }

    //根据id获取一条数据
    public static function getInfo($id)
    {
        $res = GoodsCategoryQuoteConfigRepo::getInfo($id);
        return $res;
    }

    //获取列表
    public static function getListBySearch($pager,$condition)
    {
        $res = GoodsCategoryQuoteConfigRepo::getListBySearch($pager,$condition);
        return $res;
    }
    //获取列表
    public static function getList($order,$condition)
    {
        $res = GoodsCategoryQuoteConfigRepo::getList($order,$condition);
        return $res;
    }

    //添加
    public static function create($data)
    {
        return GoodsCategoryQuoteConfigRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return GoodsCategoryQuoteConfigRepo::modify($data['id'],$data);
    }


    //删除
    public static function delete($id)
    {
        return GoodsCategoryQuoteConfigRepo::delete($id);
    }

    public static function getTotalCount($where)
    {
        return GoodsCategoryQuoteConfigRepo::getTotalCount($where);
    }
}