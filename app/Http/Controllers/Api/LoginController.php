<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginController extends ApiController
{
    //用户注册
    public function register(Request $request){
        $accountName = $request->input('accountName', '');
        $password = base64_decode($request->input('password', ''));
        $messCode = $request->input('messCode', '');
        $type = 'sms_signup';

        if(empty($accountName)){
            return $this->error('用户账号不能为空');
        }

        if(empty($password)){
            return $this->error('密码不能为空');
        }

        if(empty($messCode)){
            return $this->error('验证码不能为空');
        }

        //手机验证码是否正确
        if(Cache::get($type.$accountName) != $messCode){
            return $this->error('手机验证码不正确');
        }

        $data=[
            'user_name' => $accountName,
            'password' => $password,
            'is_firm' => 0
        ];

        try{
            UserService::userRegister($data);
            if(getConfig('individual_reg_check')) {
                return $this->success(['need_check'=>1]);
            }else{
                return $this->success(['need_check'=>0]);
            }
        } catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $openid = $request->input('openid');
        #判断是否是新qq用户
        $res = UserService::getAppUserInfo(['open_id'=>$openid]);
        #获取用户信息
        $userInfo = UserService::getUserInfo($res['user_id']);

        if($res){
            $rs = [
                'is_login'=>1,
                'userInfo'=>$userInfo
            ];
            #登录更新 返回userInfo
            return $this->success($rs);
        }else{//没有绑定过账户
            $rs = [
                'is_login'=>0
            ];
            return $this->success($rs);
        }
    }

    //有账号 直接绑定
    public function bindThird(Request $request)
    {
        $username = $request->input('user_name');
        $password = base64_decode($request->input('password'));
        $openid = $request->input('openid');
        $nick_name = $request->input('nick_name');
        $avatar = $request->input('avatar');

        if(empty($username)){
            return $this->error('用户名不能为空');
        }
        if(empty($password)){
            return $this->error('密码不能为空');
        }

        $other_params = [
            'ip'  => $request->getClientIp()
        ];
        try{
            #先验证会员账号信息
            $user_id = UserService::loginValidate($username, $password, $other_params);
            #绑定账号
            UserService::bindThird($user_id,$openid,$nick_name,$avatar);
            $uuid = \Illuminate\Support\Str::uuid();
            Cache::put($uuid, $user_id, 60*24*7);
            return $this->success($uuid);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //没有账号 注册并绑定
    public function createThird(Request $request)
    {
        $username = $request->input('user_name');
        $password = base64_decode($request->input('password'));

        $openid = $request->input('openid');
        $nick_name = $request->input('nick_name');
        $avatar = $request->input('avatar');

        $data=[
            'user_name' => $username,
            'password' => $password,
            'is_firm' => 0,
            'nick_name'=>$nick_name,
            'avatar'=>$avatar
        ];
        try{
            #注册并绑定
            $user_id = UserService::createThird($openid,$data);
            $uuid = \Illuminate\Support\Str::uuid();
            Cache::put($uuid, $user_id, 60*24*7);
            return $this->success($uuid);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
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
            return $this->error('验证码不能为空');
        }
        if(empty($password)){
            return $this->error('密码不能为空');
        }
        //手机验证码是否正确
        if(Cache::get($type.$accountName) != $messCode){
            return $this->error('验证码有误');
        }

        try{
            UserService::userUpdatePwd($id, ['newPassword' => $password]);
            return $this->success('','修改密码成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }


    //注册新用户获取手机验证码
    public function sendRegisterSms(Request $request){
        $accountName = $request->input('accountName');
        $t = $request->input('t');
        if(UserService::checkNameExists($accountName)){
            return $this->error('手机号已经注册');
        }
        $type = 'sms_signup';
        //生成的随机数
        $mobile_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::add($type.$accountName, $mobile_code, 5);
        createEvent('sendSms', ['phoneNumbers'=>$accountName, 'type'=>$type, 'tempParams'=>['code'=>$mobile_code]]);
        return $this->success();
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
        return $this->success();
    }


}
