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
    public static function search($pageSize,$condition)
    {
        $clazz = self::getBaseModel();
        $info = "";
        if(!empty($condition['real_name'])){
            $info = $clazz::where("real_name","like","%".$condition['real_name']."%")->where("review_status",$condition['review_status'])->orderBy('add_time','desc')->paginate($pageSize);
        }else{
            $info = $clazz::where("review_status",$condition['review_status'])->orderBy('add_time','desc')->paginate($pageSize);
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

    //获取用户总条数
    public static  function  getCount($condition)
    {
        $model = self::getBaseModel();
        $count = 0;

        $count = $model::where($condition)->count();

        return $count;
    }


}