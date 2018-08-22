<?php

namespace App\Repositories;

class FirmBlacklistRepository
{
    use CommonRepository;

    //获取企业黑名单列表，查询分页
    public static function search($pageSize,$firm_name)
    {
        $clazz = self::getBaseModel();
        $info = '';
        if($firm_name){
            $info = $clazz::where('firm_name','like',"%".$firm_name."%")->orderBy('add_time','desc')->paginate($pageSize);
        }else{
            $info = $clazz::orderBy('add_time','desc')->paginate($pageSize);
        }
        if($info){
            return $info;
        }
        return [];
    }

    //获取所有数据，导出excel表,无分页
    public static function getBlacklists($fields)
    {
        $clazz = self::getBaseModel();
        $info = $clazz::get($fields);
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //获取黑名单总条数
    public static  function  getCount($firm_name)
    {
        $model = self::getBaseModel();
        $count = 0;
        if($firm_name){
            $count = $model::where('firm_name','like','%'.$firm_name.'%')->count();
        }else{
            $count = $model::count();
        }
        return $count;
    }

    //删除
    public static function delete($id)
    {
        $model = self::getBaseModel();
        $flag = false;
        if(is_array($id)){
            $flag = $model::whereIn('id',$id)->delete();
        }else{
            $flag = $model::where('id',$id)->delete();
        }

        return $flag;
    }

}