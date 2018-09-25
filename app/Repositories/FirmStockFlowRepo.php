<?php

namespace App\Repositories;

class FirmStockFlowRepo
{
    use CommonRepo;
    //入库列表查询
    public static function search($goods_name,$start_time,$end_time){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->whereBetween('flow_time',[$start_time,$end_time])
              ->where('goods_name',$goods_name)->paginate(1);

    }

    //入库列表
    public static function getLists($id){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('firm_id',$id)
            ->where('flow_type',2)->paginate(1);
    }

    //出库列表
    public static function getListByStockOut($id){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
        return $query->where('firm_id',$id)
            ->where('flow_type',3)->paginate(1);
    }
}
