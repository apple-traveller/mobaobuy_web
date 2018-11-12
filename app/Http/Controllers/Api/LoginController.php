<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
class LoginController extends Controller
{
    //用户注册
    public function register(Request $request){
        $accountName = $request->input('accountName', '');
        $password = base64_decode($request->input('password', ''));
        $messCode = $request->input('messCode', '');
        $type = 'sms_signup';

        if(empty($accountName)){
            return $this->result('',400,'用户账号不能为空');
        }

        if(empty($password)){
            return $this->result('',400,'密码不能为空');
        }

        if(empty($messCode)){
            return $this->result('',400,'验证码不能为空');
        }

        //手机验证码是否正确
        if(Cache::get($type.$accountName) != $messCode){
            return $this->result('',400,'手机验证码不正确');
        }

        $data=[
            'user_name' => $accountName,
            'password' => $password,
            'is_firm' => 0
        ];

        try{
            UserService::userRegister($data);
            if(getConfig('individual_reg_check')) {
                return $this->result('',200,'提交成功，请等待审核！');
            }else{
                return $this->result('',200,'注册成功！');
            }
        } catch (\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    //用户登录
    public function login(Request $request)
    {
        $username = $request->input('user_name');
        $password = base64_decode($request->input('password'));

        if(empty($username)){
            return $this->result('',400,'用户名不能为空');
        }
        if(empty($password)){
            return $this->result('',400,'密码不能为空');
        }

        $other_params = [
            'ip'  => $request->getClientIp()
        ];
        try{
            $user_id = UserService::loginValidate($username, $password, $other_params);
            return $this->result('',200,'登录成功');
        }catch (\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    //忘记密码
    public function updatePass(Request $request)
    {

        $password = base64_decode($request->input('password', ''));
        $accountName = $request->input('accountName', '');
        $messCode = $request->input('messCode', '');
        $id = $request->input('id');
        $type = 'sms_find_signin';
        if(empty($messCode)){
            return $this->result('',400,'验证码不能为空');
        }
        if(empty($password)){
            return $this->result('',400,'密码不能为空');
        }
        //手机验证码是否正确
        if(Cache::get($type.$accountName) != $messCode){
            return $this->result('',400,'验证码有误');
        }

        try{
            UserService::userUpdatePwd($id, ['newPassword' => $password]);
            return $this->result('',200,'修改密码成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }

    }


    //注册新用户获取手机验证码
    public function sendRegisterSms(Request $request){
        $accountName = $request->input('accountName');
        $t = $request->input('t');
        if(UserService::checkNameExists($accountName)){
            return $this->result('',400,'手机号已经注册');
        }
        $type = 'sms_signup';
        //生成的随机数
        $mobile_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::add($type.$accountName, $mobile_code, 5);
        createEvent('sendSms', ['phoneNumbers'=>$accountName, 'type'=>$type, 'tempParams'=>['code'=>$mobile_code]]);
        return $this->result('',200,'获取验证码成功');
    }

    //忘记密码获取手机验证码
    public function sendFindPwdSms(Request $request){
        $accountName = $request->input('accountName');
        $t = $request->input('t');
        if(!UserService::checkNameExists($accountName)){
            return $this->error('手机号未注册');
        }
        $type = 'sms_find_signin';
        //生成的随机数
        $mobile_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put($type.$accountName, $mobile_code, 5);
        createEvent('sendSms', ['phoneNumbers'=>$accountName, 'type'=>$type, 'tempParams'=>['code'=>$mobile_code]]);
        return $this->result('',200,'获取验证码成功');
    }


}
