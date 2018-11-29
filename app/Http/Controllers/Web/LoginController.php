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
use Illuminate\Filesystem\Cache;
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
        if(1){
            $type = 'sms_signin';
            $a = Cache::get(session()->getId().$type.$username);
            dump($a);
        }

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

    //短信登陆
    public function messageLogin(Request $request){
        $username = $request->input('user_name');
        try{
            $user_id = UserService::loginByMessage($username);
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
        require (app_path() . '/QQConnect/qqConnectAPI.php');
        $qc = new \QC();
        $access_token = $qc->qq_callback();
        $openid = $qc->get_openid();
        if(empty($openid)){
            echo "抱歉，腾讯服务器繁忙，请关掉窗口后重新再试，若多次出现同样的问题，请联系塑米城客服(4)";
            die();
        }

        $qc = new \QC($access_token,$openid);
        $user = $qc->get_user_info();
        $user['openid'] = $openid;
        #判断是否是新qq用户
        $res = UserService::getAppUserInfo(['open_id'=>$openid]);

        if($res){
            #登录更新
            session()->put('_web_user_id', $res['user_id']);
            return Redirect::to("/");
        }else{
            $type = 'Q';
            $user['third_type'] = $type;
            session()->put('third_info',$user);
            $title ="账号绑定";
            return $this->display('web.user.register.third',compact('type','title'));//返回第三方登录类型参数$type 标记Q:qq W:微信
        }
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

    public function wxCallBack()
    {
        $code = empty($_REQUEST['code']) ? 0 :$_REQUEST['code'];
        $state = empty($_REQUEST['state']) ? 0 :$_REQUEST['state'];

        $wx = new \WeiXin(array(
            'appid'=>$this->_appId,
            'appsecret'=>$this->_appSecret
        ));
        //根据CODE 获取 token
        $getAccessToken = $wx->getOauthAccessToken();
        $access_token = $getAccessToken['access_token'];
        $openid = $getAccessToken['openid'];
        $refresh_token = $getAccessToken['refresh_token'];

        $user = $wx->getOauthUserinfo($access_token,$openid);
        $user['openid'] = $openid;

        #判断是否是新微信用户
        $res = UserService::getAppUserInfo(['open_id'=>$openid]);
        if(!empty($res)){
            #登录更新
            session()->put('_web_user_id', $res['user_id']);
            return Redirect::to("/");
        }else{
            $type = 'W';
            $user['third_type'] = $type;
            session()->put('third_info',$user);
            $title ="账号绑定";
            return view('web.user.register.third',compact('type','title'));//返回第三方登录类型参数$type 标记Q:qq W:微信
        }
    }

    /**
     * 有账号，绑定第三方账号
     * createbanding
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function createThird(Request $request)
    {
        $username = $request->input('username','');
        $password = $request->input('password','');

        $source_type = $request->get('third_type','');//登录来源 Q：qq W：微信
        $third_info = session('third_info');
        if(empty($username) || empty($password)){
            return $this->error('用户名或密码参数错误！');
        }
        #检测账号密码是否正确
        $user_id =  UserService::loginValidate($username,$password);
        #认证成功 绑定qq或微信
        $app_data = [
            'app_id' => $third_info['openid'],
            'source_type' => $source_type,
            'user_id' => $user_id['id']
        ];
        $result = UserService::createAppUserInfo($app_data);
        if($result){
            #登录更新
            session()->put('_web_user_id', $user_id);
            return Redirect::to("/");
        }else{
            return $this->error('绑定失败！请联系客服处理。');
        }
    }
    /**
     * 没有账号创建新账号
     * createuser
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function createNewUser(Request $request)
    {
        $source_type = $request->get('third_type','');//登录来源 Q：qq W：微信
        $third_info = session('third_info');
        $username = $request->get('username','');
        $password = base64_decode($request->input('password', ''));
        $messCode = $request->input('messCode', '');

        $type = 'sms_signup';

        //手机验证码是否正确
        if(Cache::get(session()->getId().$type.$username) != $messCode){
            return $this->error('手机验证码不正确');
        }

        $data=[
            'user_name' => $username,
            'password' => $password,
            'is_firm' => 0
        ];

        $user_id = UserService::userRegister($data);
        if($user_id){
            $app_data = [
                'app_id' => $third_info['openid'],
                'source_type' => $source_type,
                'user_id' => $user_id
            ];
            $result = UserService::createAppUserInfo($app_data);
            if($result){
                if(getConfig('individual_reg_check')) {
                    return $this->success('提交成功，请等待审核！', url('/verifyReg'));
                }else{
                    #登录更新
                    session()->put('_web_user_id', $user_id);
                    return Redirect::to("/");
                }
            }
        }
        return $this->error('注册失败！');
    }
}
