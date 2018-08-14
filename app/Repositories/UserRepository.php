<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/4/18
 * Time: 14:56
 */

namespace App\Repositories;

class UserRepository
{
    use CommonRepository;


    //获取所有用户信息
    public static function getUsers($fields)
    {
        $model = self::getBaseModel($fields);
        $info = $model::get($fields);
        if ($info) {
            return $info->toArray();
        }
        return [];
    }


    public static function getInfoByUserName($user_name){
        $model = self::getBaseModel();
        $info = $model::where('user_name', $user_name)->first();
        if ($info) {
            return $info->toArray();
        }
        return [];
    }


    public static function createLog($userLog){
        $clazz = new UserLogModel();
        foreach ($userLog as $k => $v) {
            $clazz->$k = $v;
        }
        $clazz->save();
        return $clazz->toArray();
    }

    //获取日志信息
    public static function getLogInfo($user_id,$pageSize)
    {
        $clazz = new UserLogModel;
        $info = $clazz::where('user_id',$user_id)->paginate($pageSize);
        if($info)
        {
            return $info;
        }
        return [];
    }

    //获取列表数据
    public static function search($pageSize,$user_name)
    {
        $clazz = self::getBaseModel();
        $info = '';
        if($user_name){
            $info = $clazz::where('user_name','like',"%".$user_name."%")->orderBy('reg_time','desc')->paginate($pageSize);
        }else{
            $info = $clazz::orderBy('reg_time','desc')->paginate($pageSize);
        }

        if($info)
        {
            return $info;
        }
        return [];

    }


    public static function create($data)
    {
        $clazz = self::getBaseModel();
        $info = new $clazz();
        foreach ($data as $k => $v) {
            $info->$k =$v;
        }
        $info->save();

        return $info->toArray();
    }








}