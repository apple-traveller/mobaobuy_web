<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class FirmLogRepo
{
    use CommonRepo;

    //获取日志信息
    public static function getLogInfo($firm_id,$pageSize)
    {
        $clazz = self::getBaseModel();
        $info = $clazz::where('firm_id',$firm_id)->orderBy('log_time','desc')->paginate($pageSize);
        if($info)
        {
            return $info;
        }
        return [];
    }

    //获取日志总条数
    public static function getLogCount($firm_id)
    {
        $clazz = self::getBaseModel();
        $count = $clazz::where('firm_id',$firm_id)->count();
        return $count;
    }

    //获取上一次ip信息
    public static function getLogsInfo($firm_id)
    {
        $clazz = self::getBaseModel();
        $info = $clazz::where('firm_id',$firm_id)->select('ip_address')->orderBy('log_time','desc')->first()->toArray();
        if($info)
        {
            return $info;
        }
        return [];
    }
}