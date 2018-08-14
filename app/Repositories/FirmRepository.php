<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

use App\Models\UserModel;
use App\Models\UserLogModel;


class FirmRepository
{
    use CommonRepository;

    public static function getInfoByUserName($login_name){
        $model = self::getBaseModel();
        $info = $model::where('user_name', $login_name)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }
<<<<<<< HEAD

    public static function createLog($userLog){
        $clazz = new UserLogModel();
        foreach ($userLog as $k => $v) {
            $clazz->$k = $v;
        }
        $clazz->save();
        return $clazz->toArray();
    }

    //获取企业列表，查询分页
    public static function search($pageSize,$firm_name)
    {
        $clazz = self::getBaseModel();
        $info = '';
        if($firm_name){
            $info = $clazz::where('firm_name','like',"%".$firm_name."%")->orderBy('reg_time','desc')->paginate($pageSize);
        }else{
            $info = $clazz::orderBy('reg_time','desc')->paginate($pageSize);
        }

        if($info)
        {
            return $info;
        }
        return [];

    }






=======
>>>>>>> 4639a564bad61f79a5689e4cefe58e25a48f73f7
}