<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\UserLoginService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class UserLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public function __construct(){
        session()->put('theme','default');
    }

    //用户注册
    public function userRegister(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.user.register');
        }else{
            if(session('send_code') != $request->input('mobile_code')){
                return $this->error('验证码有误');exit;
            }
            $is_firm = $request->input('is_firm');
            if($is_firm){
                //企业
                $rule = [
                    'user_name'=>'required|regex:/^1[34578][0-9]{9}$/|unique:user',
                    'password'=>'required|confirmed|min:6',
                    'nick_name'=>'required',
                    'attorney_letter_fileImg'=>'file',
                    'license_fileImg'=>'file',
                    'business_license_id'=>'required',
                    'taxpayer_id'=>'required',
                    'is_firm'=>'required|numeric',
                    'mobile_code'=>'required|numeric'
                ];
                $data = $this->validate($request,$rule);
                $data['attorney_letter_fileImg'] = $request->file('attorney_letter_fileImg');
                $data['license_fileImg'] = $request->file('license_fileImg');
            }else{
                //个人
                $rule = [
                    'user_name'=>'required|regex:/^1[34578]\d{9}$/|numeric|unique:user|min:11',
                    'password'=>'required|confirmed|min:6',
                    'is_firm'=>'required|numeric',
                    'mobile_code'=>'required|numeric',
                ];
                $data = $this->validate($request,$rule);
            }

            try{
                UserLoginService::userRegister($data);
                $request->session()->forget('send_code');
                return $this->success('注册成功','/');
            } catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }

    }

    //用户登录
    public function showLoginForm($account='')
    {
        if (!empty(session('_web_info'))) {
            return redirect('/');
        }
        return view('default.web.login.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('user_name');
        $password = $request->input('password');

        $errorMsg = array();
        if(empty($username)){
            $errorMsg[] = '用户名不能为空';
        }
        if(empty($password)){
            $errorMsg[] = '密码不能为空';
        }

        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }

        $other_params = [
            'ip'  => $request->getClientIp()
        ];
        try{
            $user_info = UserLoginService::loginValidate($username, $password, $other_params);
            session()->put('_web_info', $user_info);
            return $this->success('登录成功，正在进入系统...',  $this->redirectTo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //注册获取手机验证码
    public function getMessageCode(Request $request){
        $type = $request->input('is_type');
//        $type = 'sms_signup';
        //生成的随机数
        $mobile_code = rand(1000, 9999);
        session()->put('send_code', $mobile_code);
        $mobile = $request->input('user_name');
        $code = UserLoginService::sendCode($mobile,$type,$mobile_code);
        if($code){
            echo json_encode(array('code'=>1,'msg'=>'success'));exit;
        }

        echo json_encode(array('code'=>0,'msg'=>'error'));exit;
    }


    //登出
    public function logout()
    {
        session()->forget('_web_info');
        return $this->success('退出登录成功！', route('login'));
    }
}
