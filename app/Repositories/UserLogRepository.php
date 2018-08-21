<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class UserLogRepository
{
    use CommonRepository;

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

    //获取日志总条数
    public static function getLogCount($user_id)
    {
        $clazz = self::getBaseModel();
        $count = $clazz::where('user_id',$user_id)->count();
        return $count;
    }
}