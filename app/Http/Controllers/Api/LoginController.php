<?php
namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
class LoginController extends ApiController
{
    public function getOpenId(Request $request){
        $code = $request->input('code');
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wxd4c991d54f0db276&secret=e19401e2fb006a7f4305ade7f6ce026f&js_code=' . $code . '&grant_type=authorization_code';
        //yourAppid为开发者appid.appSecret为开发者的appsecret,都可以从微信公众平台获取；
        $info = file_get_contents($url);//发送HTTPs请求并获取返回的数据，推荐使用curl
        $json = json_decode($info);//对json数据解码
        $arr = get_object_vars($json);
        $data = [
            'openid' => $arr['openid'],
            'session_key' => $arr['session_key']
        ];
        return $this->success($data);
    }

    public function getNewOpenId(Request $request){
        $code = $request->input('code');
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wxb936150f08e31321&secret=b329babee031fd2a9f18d0dc8366c1b0&js_code=' . $code . '&grant_type=authorization_code';
        //yourAppid为开发者appid.appSecret为开发者的appsecret,都可以从微信公众平台获取；
        $info = file_get_contents($url);//发送HTTPs请求并获取返回的数据，推荐使用curl
        $json = json_decode($info);//对json数据解码
        $arr = get_object_vars($json);
        $data = [
            'openid' => $arr['openid'],
            'session_key' => $arr['session_key']
        ];
        return $this->success($data);
    }

    public function login(Request $request)
    {
        $openid = $request->input('openid');
        if(empty($openid)){
            return $this->error('缺少openid');
        }
        #判断是否是新qq用户
        $res = UserService::getAppUserInfo(['open_id'=>$openid]);
        if($res){
            #获取用户信息
            $userInfo = UserService::getUserInfoApi($res['user_id']);
            $uuid = \Illuminate\Support\Str::uuid();
            Cache::put($uuid, $userInfo['id'], 60*24*7);
            unset($userInfo['id']);
            $userInfo['token']=$uuid;
            $rs = [
                'is_login'=>1,
                'userInfo'=>$userInfo,
            ];
            #登录更新 返回userInfo
            return $this->success($rs);
        }else{//没有绑定过账户
            $rs = [
                'is_login'=>0
            ];
            return $this->success($rs);
        }
    }

    //有账号直接绑定
    public function bindThird(Request $request)
    {
        $username = $request->input('mobile');
        $password = $request->input('password');
        $openid = $request->input('openid');
        $nick_name = $request->input('nick_name');
        $avatar = $request->input('avatar');

        if(empty($username)){
            return $this->error('用户名不能为空');
        }

        if(empty($password)){
            return $this->error('密码不能为空');
        }

        if(empty($openid)){
            return $this->error('openid不能为空');
        }

        $other_params = [
            'ip'  => $request->getClientIp()
        ];

        try{
            //验证会员是否已经存在
            $flag = UserService::checkNameExists($username);
            if(!$flag){
                return $this->error("您未注册，请前去注册");
            }
            #先验证会员账号信息
            $user_id = UserService::loginValidate($username, $password, $other_params);
            #绑定账号
            UserService::bindThird($user_id,$openid,$nick_name,$avatar);
            $uuid = \Illuminate\Support\Str::uuid();
            Cache::put($uuid, $user_id, 60*24*7);
            $userInfo = UserService::getUserInfoApi($user_id);
            unset($userInfo['id']);
            $userInfo['token']=$uuid;
            $rs = [
                'is_login'=>1,
                'userInfo'=>$userInfo,
            ];
            return $this->success($rs);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //没有账号 注册并绑定
    public function createThird(Request $request)
    {
        $username = $request->input('mobile');
        $password = $request->input('password');
        $messCode = $request->input('messCode', '');
        $openid = $request->input('openid');
        $nick_name = $request->input('nick_name');
        $avatar = $request->input('avatar');

        if(empty($openid)){
            return $this->error('缺少openid');
        }
        if(empty($messCode)){
            return $this->error('手机验证码不能为空');
        }

        $type = 'sms_signup';

        //手机验证码是否正确
        if(Cache::get($type.$username) != $messCode){
            return $this->error('手机验证码不正确');
        }

        $data=[
            'user_name' => $username,
            'password' => $password,
            'is_firm' => 0,
            'nick_name'=>$nick_name,
            'avatar'=>$avatar
        ];

        try{
            #注册并绑定
            $user_id = UserService::createThird($openid,$data);
            $this->sms_listen_register($username);
            $uuid = \Illuminate\Support\Str::uuid();
            Cache::put($uuid, $user_id, 60*24*7);
            $userInfo = UserService::getUserInfoApi($user_id);
            unset($userInfo['id']);
            $userInfo['token']=$uuid;
            $rs = [
                'is_login'=>1,
                'userInfo'=>$userInfo,
            ];
            return $this->success($rs);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
    //短信通知
    public function sms_listen_register($accountName){
        if(!empty(getConfig('remind_mobile'))){
            createEvent('sendSms', ['phoneNumbers'=>getConfig('remind_mobile'), 'type'=>'sms_listen_register', 'tempParams'=>['code'=>$accountName]]);
        }
    }

    //解绑操作
    public function untying(Request $request)
    {
        $openid = $request->input('openid');
        $uuid = $request->input('token');
        $userid = $this->getUserID($request);
        if(empty($openid)){
            return $this->error('缺少参数，openid');
        }
        //删除app_user表里面的一条数据
        try{
            Cache::forget($uuid);
            Cache::forget('_api_user_'.$userid);
            Cache::forget('_api_deputy_user_'.$userid);
            UserService::deleteThird($openid);
            return $this->success([],'success');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //忘记密码
    public function updatePass(Request $request)
    {
        $accountName = $request->input('mobile', '');
        //$password = base64_decode($request->input('password', ''));
        $password = $request->input('password', '');
        $messCode = $request->input('messCode', '');
        $type = 'sms_find_signin';

        //手机验证码是否正确
        if(Cache::get($type.$accountName) != $messCode){
            return $this->error('手机验证码不正确');
        }

        try{
            UserService::userFindPwd($accountName, $password);
            return $this->success('','修改密码成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //重置密码
    public function resetPass(Request $request)
    {
        $accountName = $request->input('mobile', '');
        $password = $request->input('password', '');
        $messCode = $request->input('messCode', '');
        $uuid = $request->input('token');
        $userid = $this->getUserID($request);
        $type = 'sms_find_signin';

        //手机验证码是否正确
        if(Cache::get($type.$accountName) != $messCode){
            return $this->error('手机验证码不正确');
        }

        try{
            UserService::resetPwd($accountName, $password);
            Cache::forget($uuid);
            Cache::forget('_api_user_'.$userid);
            Cache::forget('_api_deputy_user_'.$userid);
            return $this->success('','修改密码成功');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //注册新用户获取手机验证码
    public function sendRegisterSms(Request $request){
        $accountName = $request->input('accountName');
        $t = $request->input('t');
        if(UserService::checkNameExists($accountName)){
            return $this->error('手机号已经注册');
        }
        $type = 'sms_signup';
        //生成的随机数
        $mobile_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::add($type.$accountName, $mobile_code, 5);
        createEvent('sendSms', ['phoneNumbers'=>$accountName, 'type'=>$type, 'tempParams'=>['code'=>$mobile_code]]);
        return $this->success('','success');
    }

    //忘记密码获取手机验证码
    public function sendFindPwdSms(Request $request){
        $accountName = $request->input('accountName');
        $t = $request->input('t');
        if(!UserService::checkNameExists($accountName)){
            return $this->error('手机号未注册');
        }
        $type = 'sms_find_signin';
        //生成的随机数
        $mobile_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put($type.$accountName, $mobile_code, 5);
        createEvent('sendSms', ['phoneNumbers'=>$accountName, 'type'=>$type, 'tempParams'=>['code'=>$mobile_code]]);
        return $this->success('','success');
    }

    //登出
    public function logout(Request $request)
    {
        $uuid = $request->input('token');
        $userid = $this->getUserID($request);
        Cache::forget($uuid);
        Cache::forget('_api_user_'.$userid);
        Cache::forget('_api_deputy_user_'.$userid);
        return $this->success('','退出登录成功！');
    }


}
