<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class FriendLinkRepo
{
    use CommonRepo;

    //获取列表数据(带分页)
    public static function search($pageSize)
    {
        $model = self::getBaseModel();
        $info = $model::orderBy('sort_order','asc')->paginate($pageSize);
        if($info)
        {
            return $info;
        }
        return [];
    }

    //根据linkname获取数据，唯一性验证
    public static function getInfoBylinkname($link_name)
    {
        $model = self::getBaseModel();
        $info = $model::where('link_name',$link_name)->get(['id']);
        if($info){
            return $info->toArray();
        }
        return [];
    }

}