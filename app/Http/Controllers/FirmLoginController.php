<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserLoginService;

class FirmLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    //用户注册
    public function userRegister(Request $request){
        if($request->isMethod('get')){
            return view('default.user.register');
        }else{
            $rule = [
                'user_name'=>'required|numeric|min:11',
                'nick_name'=>'required',
                'password'=>'required|confirmed|min:6',
                'email'=>'required|unique:user|max:100'
            ];
            $data = $this->validate($request,$rule);
            $data['front_of_id_card'] = 123;
            $data['reverse_of_id_card'] = 100;
            $data['birthday'] = date('y-m-d',time());
            $data['password'] = bcrypt($data['password']);
            try{
                 UserLoginService::userRegister($data);
                return '1111';
//                return $this->success('注册成功，正在进入系统...',  $this->redirectTo);
            } catch (\Exception $e){
//                return $this->error($e->getMessage());
                print $e->getMessage();
                exit();
                return '222';
            }
        }

    }

    //用户登录

    public function showLoginForm($account='')
    {

//        if (!empty(session('_admin_user_info'))) {
//            return redirect('/login');
//        }
        return view('default.user.login');
    }

    public function login(Request $request)
    {
//       dump($request->all());
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
            session()->put('_admin_user_info', $user_info);
            return $this->redirect('/');
//            return $this->success('登录成功，正在进入系统...',  $this->redirectTo);
        }catch (\Exception $e){
//            return $this->error($e->getMessage());
        }
    }

    public function logout()
    {
        session()->forget('_admin_user_info');
        return $this->success('退出登录成功！', route('login'));
    }
}
