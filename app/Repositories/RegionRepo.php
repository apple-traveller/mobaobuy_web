<?php

namespace App\Repositories;

class RegionRepo
{
    use CommonRepo;

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

    //批量删除
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

    //获取省
    public static function getProvince($region_type){
        $model = self::getBaseModel();
        $info = $model::where('parent_id',$region_type)->get();
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //获取市，县
    public static function getCity($regionId){
        $model = self::getBaseModel();
        $info = $model::where('parent_id',$regionId)->get();
        $cityInfo = $info->toArray();
//        $cityInfo[0]['region_id']
        $countyClass = $model::where('parent_id',$cityInfo[0]['region_id'])->get();
        $countyInfo = $countyClass->toArray();

        if($info && $countyClass){
            return ['city'=>$cityInfo,'county'=>$countyInfo];
        }
        return [];
    }
    //获取县
    public static function getCounty($cityId){
        $model = self::getBaseModel();
        $info = $model::where('parent_id',$cityId)->get();
        if($info){
            return $info->toArray();
        }
        return [];
    }




}
