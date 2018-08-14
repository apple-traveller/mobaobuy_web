<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\User;

class UserService extends BaseService
{
    //获取用户列表
    public static function getUsers($fields)
    {
        $info = UserRepository::getUsers($fields);
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
        $info = UserRepository::search($pageSize,$user_name);
        return $info;
    }

    //添加
    public static function create($data)
    {
        $flag = UserRepository::create($data);
        return $flag;
    }

    //修改
    public static function modify($id,$data)
    {
        return UserRepository::modify($id,$data);
    }

    //查询一条数据
    public static function getInfo($id)
    {
        return UserRepository::getInfo($id);
    }

    //获取日志信息
    public static function getLogInfo($id,$pageSize)
    {
        return UserRepository::getLogInfo($id,$pageSize);
    }


}