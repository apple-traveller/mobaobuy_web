<?php

namespace App\Services;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;

class UserLoginService extends BaseService
{
    //用户注册
    public static function userRegister($data){
        return UserRepository::create($data);
    }

    public static function loginValidate($username, $psw, $other_params = [])
    {
        $info = UserRepository::getInfoByLoginName($username);
        //dd($info);
        if(empty($info)){
            self::throwError('用户名或密码不正确！');
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwError('用户名或密码不正确！');
        }

//        if(!$info['is_super'] && !$info['is_active']){
//            self::throwError('用户账号已冻结！');
//        }
        unset($info['password']);

        //写入日志
        $userLog = array(
            'user_id'=>$info['id'],
            'user_name'=>$info['user_name'],
            'ip_address'=>$other_params['ip'],
            'log_info'=>'登陆日志'
        );
        UserRepository::createLog($userLog);
        return $info;
    }




}