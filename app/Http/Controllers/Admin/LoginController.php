<?php

namespace App\Http\Controllers\Admin;

use App\Services\AdminService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    //登录
    public function loginForm()
    {
        if (!empty(session('_admin_user_id'))) {
            return redirect($this->redirectTo);
        }
        return $this->display('admin.login');
    }
    /*
     * 登录逻辑
     *
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $errorMsg = array();
        if(empty($username)){
            $errorMsg[] = '管理员不能为空';
        }
        if(empty($password)){
            $errorMsg[] = '密码不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        
        try{
            $user_id = AdminService::loginValidate($username, $password, [ 'ip'  => $request->getClientIp()]);
            session()->put('_admin_user_id', $user_id);
            return $this->success('登录成功，正在进入系统...');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session()->forget('_admin_user_id');
        session()->forget('_admin_user_info');
        return $this->success('退出登录成功！', route('admin_login'));
    }
}
