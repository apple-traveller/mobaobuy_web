<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class SysConfigRepo
{
    use CommonRepo;

    //根据parent_id获取配置信息
    public static function getInfo($parent_id)
    {
        $model = self::getBaseModel();
        $info = $model::where('parent_id',$parent_id)->get();
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //修改
    public static function modify($code,$data)
    {

        $model = self::getBaseModel();
        $info = $model::where('code',$code)->first(); //模型实例
        if ($info) {
            foreach ($data as $k => $v) {
                $info->$k = $v;
            }
            $info->save();
            return $info->toArray();
        }
        return false;
    }


    public static function search($paper=[],$where)
    {
        $clazz = self::getBaseModel();
        return self::getListBySearch($paper,[]);
    }

}