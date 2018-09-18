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
use App\Models\FirmLogModel;

class FirmRepo
{
    use CommonRepo;

    public static function getInfoByUserName($login_name){
        $model = self::getBaseModel();
        $info = $model::where('user_name', $login_name)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }


    //更新积分
    public static function updatePoints($id,$type,$points){
        $model = self::getBaseModel();
        $info = $model::find($id); //模型实例
        if ($info) {
            if($type == 2){
                $firmInfo = $info->toAarray();
                $info->points = $firmInfo['points'] - $points;
                $info->save();
            }elseif ($type == 1){
                $firmInfo = $info->toAarray();
                $info->points = $firmInfo['points'] + $points;
                $info->save();
            }else{
                return false;
            }
            return $info->toArray();
        }
        return false;
    }







}