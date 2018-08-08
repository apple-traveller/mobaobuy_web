<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Services\Admin\AdminLogService;
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
        if (!empty(session('_admin_info'))) {
            return redirect($this->redirectTo);
        }
        session()->put('theme', 'default');
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
            session()->put('_admin_info', $user_info);
            session()->put('theme', 'default');
            $adminLog['admin_id'] = $user_info['id'];
            $adminLog['real_name'] = $user_info['real_name'];
            $adminLog['log_time'] = date("Y-m-d H:i:s",time());
            $adminLog['ip_address'] = $request->getClientIp();
            $flag = AdminLogService::create($adminLog);
            if(!$flag){
                return $this->result('','0',"登录失败");
            }
        }catch(\Exception $e){
            return $this->result('','0',$e->getMessage());
        }



        return $this->result('',1,'登录成功');
    }
}
