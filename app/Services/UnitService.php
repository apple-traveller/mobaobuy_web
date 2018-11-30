<?php
namespace App\Services;
use App\Repositories\GoodsRepo;
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
        //检测单位是否被商品使用
        $res = GoodsRepo::getTotalCount(['unit_id'=>$id]);
        if($res > 0){
            self::throwBizError('存在商品使用此单位，无法删除');
            return false;
        }
        return UnitRepo::modify($id,['is_delete'=>1]);
    }

}