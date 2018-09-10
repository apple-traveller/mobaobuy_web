<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class ArticleCatRepo
{
    use CommonRepo;

    //根据parent_id获取所有的分类
    public static function getList($parent_id)
    {
        $model = self::getBaseModel();
        $info = $model::where('parent_id',$parent_id)->orderBy('sort_order','asc')->get();
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //获取所有的分类
    public static function getCates()
    {
        $model = self::getBaseModel();
        $info = $model::get();
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //存在验证
    public static function exist($cat_name)
    {
        $model = self::getBaseModel();
        return $model::where('cat_name',$cat_name)->exists();
    }

    //删除
    public static function delete($ids)
    {
        $model = self::getBaseModel();
        $flag = $model::whereIn('id',$ids)->delete();
        return $flag;
    }


}