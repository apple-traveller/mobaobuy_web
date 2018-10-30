<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class UserRealRepo
{
    use CommonRepo;


//    public static function modify($data)
//    {
//        $model = self::getBaseModel();
//        $info = $model::where('id',$data['id'])->first(); //模型实例
//        if ($info) {
//            foreach ($data as $k => $v) {
//                if($info->getKeyName() !== $k){
//                    $info->$k = $v;
//                }
//            }
//            $info->save();
//            return $info->toArray();
//        }
//        return false;
//    }


}