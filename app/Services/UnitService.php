<?php
namespace App\Services;
use App\Repositories\UnitRepo;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class UnitService
{
    use CommonService;

    //获取列表
    public static function getUnitsList()
    {
        return UnitRepo::getListBySearch(['orderType'=>['sort_order'=>'asc']],[]);
    }

    //获取一条信息
    public static function getUnitById($id)
    {
        return UnitRepo::getInfo($id);
    }

    //修改
    public static function modify($data)
    {
        return UnitRepo::modify($data['id'],$data);
    }

    //添加
    public static function create($data)
    {
        return UnitRepo::create($data);
    }

    //删除
    public static function delete($id)
    {
        return UnitRepo::delete($id);
    }

}