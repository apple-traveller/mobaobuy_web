<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
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

            $adminLog=[
                'admin_id'=>1,
                'real_name'=>$user_info['real_name'],
                'log_time'=>Carbon::now(),
                'ip_address'=>$request->getClientIp()
            ];
            //print_r($adminLog);die;
            $flag = AdminLogService::create($adminLog);

            if(!$flag){
                return $this->result('','0',"登录失败");
            }
            session()->put('_admin_info', $user_info);
            session()->put('theme', 'default');
        }catch(\Exception $e){
            return $this->result('','0',$e->getMessage());
        }



        return $this->result('',1,'登录成功');
    }
}
