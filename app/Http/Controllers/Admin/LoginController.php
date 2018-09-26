<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Services\AdminLogService;
use Illuminate\Support\Facades\Cookie;

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
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $errorMsg = array();
        $adminLog = array();
        if(empty($username)){
            $errorMsg[] = '管理员不能为空';
        }
        if(empty($password)){
            $errorMsg[] = '密码不能为空';
        }
        if(!empty($errorMsg)){
            return $this->result('','0',implode('<br/>',$errorMsg));
        }

        try{
            $user_info = AdminService::loginValidate($username, $password);

            $adminLog=[
                'admin_id'=>1,
                'real_name'=>$user_info['real_name'],
                'log_time'=>Carbon::now(),
                'ip_address'=>$request->getClientIp(),
                'log_info'=>"登录"
            ];

            $flag = AdminLogService::create($adminLog);

            if(!$flag){
                return $this->result('','0',"登录失败");
            }
            session()->put('_admin_info', $user_info['id']);
            session()->put('theme', 'default');
            return $this->result('',1,'登录成功');
        }catch(\Exception $e){
            return $this->result('','0',$e->getMessage());
        }




    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session()->forget('_admin_info');
        //Cookie::forget('dscUrl');
        return $this->success('退出登录成功！', route('admin_login'));


    }
}
