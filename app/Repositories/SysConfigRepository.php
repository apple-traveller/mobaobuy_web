<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class SysConfigRepository
{
    use CommonRepository;
    public static function search($paper=[],$where){
        $clazz = self::getBaseModel();
        $query = $clazz::query();
//        if(isset($where['code'])){
//            $query = $query->where('code',$where['code']);
//        }
        return self::searchQuery($paper,$query);
    }

}