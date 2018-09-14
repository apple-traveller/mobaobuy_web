<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class UserLogRepo
{
    use CommonRepo;

    //获取日志信息
    public static function getLogs($user_id,$pageSize)
    {
        $clazz = self::getBaseModel();
        $info = $clazz::where('user_id',$user_id)->orderBy('log_time','desc')->paginate($pageSize);
        if($info)
        {
            return $info;
        }
        return [];
    }


    //获取上一次ip信息,登陆时间,日志条数
    public static function getLogsInfo($user_id)
    {
        $clazz = self::getBaseModel();
        $count = $clazz::where('user_id',$user_id)->count();
        if($count>0){
            $info = $clazz::where('user_id',$user_id)->select('ip_address','log_time')->orderBy('id','desc')->first()->toArray();
            if($info)
            {
                $info['count'] = $count;
                return $info;
            }
            return 'error';
        }
        return 'error';
    }

    //获取日志总条数
    public static function getLogCount($user_id)
    {
        $model = self::getBaseModel();
        $count = $model::where('user_id',$user_id)->count();
        return $count;
    }





}