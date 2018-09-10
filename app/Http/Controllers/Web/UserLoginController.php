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
            $rule = [
                'user_name'=>'required|regex:/^1[34578]\d{9}$/|numeric|unique:user|unique:firm|min:11',
                'nick_name'=>'required',
                'password'=>'required|confirmed|min:6',
                'email'=>'nullable|email|unique:user',
                'mobile_code'=>'required|numeric'
            ];
            $data = $this->validate($request,$rule);
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
        DB::beginTransaction();
        try{
            $user_info = UserLoginService::loginValidate($username, $password, $other_params);
            session()->put('_web_info', $user_info);
            DB::commit();
            return $this->success('登录成功，正在进入系统...',  $this->redirectTo);
        }catch (\Exception $e){
            DB::rollBack();
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




    //完善用户信息
    public function userUpdate(Request $request){
        if(empty(session('_web_info'))){
            $this->error('登陆失效,请重新登陆');exit;
        }else if($request->method('post')){
            $rule = [
                'email'=>'nullable|email|unique:user',
                'sex'=>'nullable|numeric|max:1',
                'birthday'=>'nullable|numeric',
                'qq'=>'nullable|numeric',
                'avatar'=>'nullable|image',
                'id_card'=>'nullable|numeric',
                'front_of_id_card'=>'nullable|image',
                'reverse_of_id_card'=>'nullable|image'
            ];
            $data = $this->validate($request,$rule);
            if(empty($data)){
                return $this->error('');
            }
            try{
                UserLoginService::updateUserInfo(session('_web_info')['id'],$data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }

        }else if($request->method('get')){
                $userInfo = UserLoginService::getInfo(session('_web_info')['id']);
                return $this->display('web.user.info',compact('userInfo'));
        }
    }

    public function logout()
    {
        session()->forget('_web_info');
        return $this->success('退出登录成功！', route('login'));
    }
}
