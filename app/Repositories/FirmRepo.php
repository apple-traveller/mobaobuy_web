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

    //获取所有数据，导出excel表,无分页
    public static function getFirms($fields)
    {
        $clazz = self::getBaseModel();
        $info = $clazz::get($fields);
        if($info){
            return $info->toArray();
        }
        return [];
    }

    //获取用户总条数
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



}