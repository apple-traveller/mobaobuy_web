<?php

namespace App\Services\Admin;

use App\Services\CommonService;
use App\Repositories\UserRepo;
use Illuminate\Foundation\Auth\User;

class UserService extends CommonService
{
    //获取用户列表(导出excel表)
    public static function getUsers($fields)
    {
        $info = UserRepo::getUsers($fields);
        foreach($info as $key=>$item){
            if($item['sex']==1){
                $info[$key]['sex']="女";
            }else{
                $info[$key]['sex']="男";
            }
        }
        return $info;
    }

    //获取用户列表（分页）
    public static function getUserList($pageSize,$user_name)
    {
        $info = UserRepo::search($pageSize,$user_name);
        return $info;
    }


    //修改
    public static function modify($id,$data)
    {
        return UserRepo::modify($id,$data);
    }

    //查询一条数据
    public static function getInfo($id)
    {
        return UserRepo::getInfo($id);
    }


    //获取总条数
    public static function getCount($user_name)
    {
        return UserRepo::getCount($user_name);
    }



}