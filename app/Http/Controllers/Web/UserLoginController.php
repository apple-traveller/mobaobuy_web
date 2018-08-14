<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\Web\UserLoginService;
use App\Http\Controllers\Controller;

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
            $rule = [
                'user_name'=>'required|regex:/^1[34578]\d{9}$/|numeric|unique:user|unique:firm|min:11',
                'nick_name'=>'required',
                'password'=>'required|confirmed|min:6',
                'email'=>'nullable|email|unique:user',
                'mobile_code'=>'required|numeric'
            ];
            $data = $this->validate($request,$rule);
            $data['front_of_id_card'] = '123';
            $data['reverse_of_id_card'] = '666';
            try{
                UserLoginService::userRegister($data);
                return $this->success('注册成功，正在进入系统...',  $this->redirectTo);
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

    //获取手机验证码
    public function getMessageCode(Request $request){
        echo json_encode(array('code'=>1,'msg'=>'success'));exit;
        $mobile = $request->input('user_name');
        $code = UserLoginService::sendCode($mobile);
        if($code){
            echo json_encode(array('code'=>1,'msg'=>'success'));exit;
        }
        echo json_encode(array('code'=>0,'msg'=>'error'));exit;
    }

    public function logout()
    {
        session()->forget('_web_info');
        return $this->success('退出登录成功！', route('login'));
    }
}
