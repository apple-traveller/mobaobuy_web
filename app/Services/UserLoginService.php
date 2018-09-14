<?php

namespace App\Services;

use App\Repositories\UserLogRepo;
use App\Repositories\UserRepo;
use App\Repositories\UserRealRepo;
use App\Repositories\FirmLogRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Repositories\FirmRepo;
use App\Repositories\FirmBlacklistRepo;
use Illuminate\Support\Facades\Storage;

class UserLoginService
{
    use CommonService;

    //用户注册
    public static function userRegister($data)
    {
//        if(empty(session('send_code')) || $data['mobile_code']!=session('send_code')){
//            exit('请求超时，请刷新页面后重试');
//        }

        $data['reg_time'] = Carbon::now();
        $data['password'] = bcrypt($data['password']);
        if ($data['is_firm']) {
            //企业
            //查找黑名单表是否存在
            $firmBlack = FirmBlacklistRepo::getInfoByFields(['firm_name' => $data['nick_name']]);
            if ($firmBlack) {
                throwBizError('');
                //return 'error';
            }
            $userReal = [];
            $userReal['license_fileImg'] = $data['license_fileImg'];
            $userReal['business_license_id'] = $data['business_license_id'];
            $userReal['taxpayer_id'] = $data['taxpayer_id'];
            $userReal['add_time'] = Carbon::now();

            $attorneyImgPath = Storage::putFile('public', $data['attorney_letter_fileImg']);
            $attorneyImgPath = explode('/', $attorneyImgPath);
            $data['attorney_letter_fileImg'] = '/storage/' . $attorneyImgPath[1];

            $licensePath = Storage::putFile('public', $data['license_fileImg']);
            $licensePath = explode('/', $licensePath);
            $userReal['license_fileImg'] = '/storage/' . $licensePath[1];

            unset($data['business_license_id']);
            unset($data['license_fileImg']);
            unset($data['taxpayer_id']);
            unset($data['mobile_code']);

            try {
                self::beginTransaction();
                $user = UserRepo::create($data);
                $userReal['user_id'] = $user['id'];
                $real = UserRealRepo::create($userReal);
                self::commit();
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }

        } else {
            //个人
            $data['nick_name'] = rand(10000, 99999);
            unset($data['mobile_code']);
            try{
                self::beginTransaction();
                $user = UserRepo::create($data);
                $userReal['user_id'] = $user['id'];
                $userReal['add_time'] = Carbon::now();
                $real = UserRealRepo::create($userReal);
                self::commit();
            }catch(\Exception $e){
                self::rollBack();
                throw $e;
            }
        }
    }

    //发送验证码
    public static function sendCode($mobile)
    {

//        $mobile = 18217232270;
        $type = 'sms_signup';

        //生成的随机数
        $mobile_code = rand(1000, 9999);

        session()->put('send_code', $mobile_code);


        return SmsService::sendSms($mobile,$type,$mobile_code);
    }

    //
    public static function getInfo($id)
    {
        return UserRepo::getInfo($id);
    }

    //用户登录
    public static function loginValidate($username, $psw, $other_params = [])
    {

        if(!preg_match("/^1[345789]{1}\\d{9}$/",$username)){
           self::throwBizError('用户名或密码不正确!');
        }
        //查用户表
        $info = UserRepo::getInfoByUserName($username);
        if(empty($info)){
            self::throwBizError('用户名或密码不正确！');
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwBizError('用户名或密码不正确！');
        }

        //查用户表
        $info = UserRepo::getInfoByUserName($username);
        if (empty($info)) {
            self::throwBizError('用户名或密码不正确！');
        }

        if (!Hash::check($psw, $info['password'])) {
            self::throwBizError('用户名或密码不正确！');
        }

        if ($info['is_freeze']) {
            self::throwBizError('用户名或密码不正确！');
        }
        unset($info['password']);

        //上次登录ip,时间,登陆访问次数

        $lastInfo = [
            'last_ip' => $other_params['ip'],
            'last_time' => Carbon::now(),
            'visit_count' => $info['visit_count'] + 1
        ];
        UserRepo::modify($info['id'],$lastInfo);

        //写入日志

        $userLog = array(
            'user_id' => $info['id'],
            'ip_address' => $other_params['ip'],
            'log_time' => Carbon::now(),
            'log_info' => '会员登陆'
        );
        UserLogRepo::create($userLog);
        return $info;
    }





    //完善信息
    public static function updateUserInfo($id, $data)
    {
        return UserRepo::modify($id, $data);
    }


    //管理员后台
    //获取日志列表（分页）
    public static function getLogs($user_id, $pageSize)
    {
        return UserLogRepo::getLogs($user_id, $pageSize);
    }

    //获取日志总条数
    public static function getLogCount($user_id)
    {
        return UserLogRepo::getLogCount($user_id);
        //return UserLogRepo::getTotalCount();
    }

}