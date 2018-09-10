<?php

namespace App\Repositories;

class RegionRepo
{
    use CommonRepo;

    //获取地区列表
    public static function getRegionList($parent_id)
    {
        $model = self::getBaseModel();
        $info = $model::where('parent_id',$parent_id)->get();
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //获取当前页面所属地区名字
    public static function getInfo($id)
    {
        $model = self::getBaseModel();
        $info = $model::where('region_id',$id)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }

    //获取当前地区所有的下级id
    public static function getids($region_id)
    {
        $model = self::getBaseModel();
        $info = $model::where('parent_id',$region_id)->get(['region_id','parent_id']);
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //删除
    public static function delete($data)
    {
        $model = self::getBaseModel();
        $flag = $model::whereIn('region_id',$data)->delete();
        return $flag;
    }

    //修改
    public static function modify($id, $data)
    {
        $model = self::getBaseModel();
        $info = $model::where('region_id',$id)->first(); //模型实例
        if ($info) {
            foreach ($data as $k => $v) {
                $info->$k = $v;
            }
            $info->save();
            return $info->toArray();
        }
        return false;
    }


}
