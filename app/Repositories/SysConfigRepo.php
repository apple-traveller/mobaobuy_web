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


    //修改 （我的）
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

    //叶鹏的
    public static function search($paper=[],$where)
    {
        $clazz = self::getBaseModel();
        return self::getListBySearch($paper,[]);
    }

}