<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class NavRepo
{
    use CommonRepo;

    //列表(分页)
    public static function getList($pageSize)
    {
        $model = self::getBaseModel();
        $info = $model::orderBy('sort_order','asc')->paginate($pageSize);
        if($info){
            return $info;
        }

        return [];
    }

    //获取总数
    public static function getCount()
    {
        $model = self::getBaseModel();
        $count = $model::count();
        return $count;
    }

    //存在验证
    public static function exist($name)
    {
        $model = self::getBaseModel();
        return $model::where('name',$name)->exists();
    }





}