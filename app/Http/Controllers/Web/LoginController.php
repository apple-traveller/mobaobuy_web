<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-17
 * Time: 10:53
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //用户登录页面
    public function index()
    {
        if (!empty(session('_web_user_id'))) {
            return redirect('/');
        }
        return $this->display('web.login');
    }

    //用户登录提交
    public function login(Request $request)
    {
        $username = $request->input('user_name');
        $password = base64_decode($request->input('password'));

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
            $user_id = UserService::loginValidate($username, $password, $other_params);
            session()->put('_web_user_id', $user_id);
            return $this->success('登录成功，正在进入系统...');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
    /**
     * 第三方qq登录
     */
    public function qqLogin()
    {
        require (app_path() . '/QQConnect/qqConnectAPI.php');
        $qc = new \QC();
        $qc->qq_login();
        die();
    }

    public function qqCallBack()
    {
//        require (app_path() . '/QQConnect/qqConnectAPI.php');
//        $qc = new \QC();
//        $access_token = $qc->qq_callback();
//        $openid = $qc->get_openid();
//        if(empty($openid)){
//            echo "抱歉，腾讯服务器繁忙，请关掉窗口后重新再试，若多次出现同样的问题，请联系塑米城客服(4)";
//            die();
//        }
//
//        $qc = new \QC($access_token,$openid);
//        $user = $qc->get_user_info();
//        $user['openid'] = $openid;
//        #判断是否是新qq用户
//        $res = UserService::getAppUserInfo(['open_id'=>$openid]);
//
//        if($res){
//            #登录更新
//            session()->put('_web_user_id', $res['user_id']);
//            return Redirect::to("/");
//        }else{
            $type = 'Q';
            $user['third_type'] = $type;
            session()->put('third_info',$user);
            $title ="账号绑定";
            return $this->display('web.user.register.third',compact('type','title'));//返回第三方登录类型参数$type 标记Q:qq W:微信
//        }
    }


    public function wxLogin()
    {
        $wx = new \WeiXin(array(
            'appid'=>$this->_appId,
            'appsecret'=>$this->_appSecret
        ));
        $OauthRedirect = $wx->getOpenOauthRedirect($this->_redirect, md5(time()), $this->_scope);
        return redirect($OauthRedirect);
    }
}
