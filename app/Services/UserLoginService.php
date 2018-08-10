<?php

namespace App\Services;
use App\Repositories\UserLogRepository;
use App\Repositories\UserRepository;
use App\Repositories\FirmLogRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Repositories\FirmRepository;

class UserLoginService extends BaseService
{
    //用户注册
    public static function userRegister($data){
        $data['reg_time'] = Carbon::now();
        $data['password'] = bcrypt($data['password']);
        return UserRepository::create($data);
    }

    //用户登录
    public static function loginValidate($username, $psw, $other_params = [])
    {
        if(!preg_match("/^1[345789]{1}\\d{9}$/",$username)){
           self::throwError('用户名或密码不正确!');
        }
        //查用户表
        $info = UserRepository::getInfoByUserName($username);
        if(empty($info)){
            //查企业表
            $info = FirmRepository::getInfoByUserName($username);
            if(empty($info)){
                self::throwError('用户名或密码不正确！');
            }
            $info['flag'] = 1;
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwError('用户名或密码不正确！');
        }

        if($info['is_freeze']){
            self::throwError('用户名或密码不正确！');
        }
        unset($info['password']);

        //写入日志
        if(!isset($info['flag'])){
            $userLog = array(
                'user_id'=>$info['id'],
                'user_name'=>$info['user_name'],
                'ip_address'=>$other_params['ip'],
                'log_time'=>Carbon::now(),
                'log_info'=>'个人会员登陆'
            );
            UserLogRepository::create($userLog);
        }else{
            $firmLog = array(
                'firm_id'=>$info['id'],
                'firm_name'=>$info['user_name'],
                'ip_address'=>$other_params['ip'],
                'log_time'=>Carbon::now(),
                'log_info'=>'企业会员登陆'
            );
            FirmLogRepository::create($firmLog);
        }
        return $info;
    }

}