<?php

namespace App\Services\Web;
use App\Repositories\UserLogRepository;
use App\Repositories\UserRepository;
use App\Repositories\FirmLogRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Repositories\FirmRepository;
use App\Services\BaseService;

class UserLoginService extends BaseService
{
    //用户注册
    public static function userRegister($data){
        $data['reg_time'] = Carbon::now();
        $data['password'] = bcrypt($data['password']);
        if(empty(session('send_code')) or $data['mobile_code']!=session('send_code')){
            exit('请求超时，请刷新页面后重试');
        }

        unset($data['mobile_code']);
        return UserRepository::create($data);
    }

    //发送验证码
    public static function sendCode($mobile){
        //短信接口地址
        $target = "http://xxxx.com/xxx.php?method=Submit";

        //生成的随机数
        $mobile_code = rand(1000,9999);

        session()->put('send_code',$mobile_code);

        $post_data = "account=用户名&password=密码&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
        return self::Post($post_data,$target);
    }

    //短信
     public static function Post($curlPost,$url){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
            $return_str = curl_exec($curl);
            curl_close($curl);
            return $return_str;
     }

     //
    public static function getInfo($id){
         return UserRepository::getInfo($id);
    }

    //用户登录
    public static function loginValidate($username, $psw, $other_params = [])
    {
        if(!preg_match("/^1[345789]{1}\\d{9}$/",$username)){
           self::throwError('用户名或密码不正确!');
        }
        //查用户表
        $info = UserRepository::getInfoByUserName($username);
        if(empty($info)){
            //查企业表
            $info = FirmRepository::getInfoByUserName($username);
            if(empty($info)){
                self::throwError('用户名或密码不正确！');
            }
            $info['flag'] = 1;
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwError('用户名或密码不正确！');
        }

        if($info['is_freeze']){
            self::throwError('用户名或密码不正确！');
        }
        unset($info['password']);

        //写入日志
        if(!isset($info['flag'])){
            $userLog = array(
                'user_id'=>$info['id'],
                'user_name'=>$info['user_name'],
                'ip_address'=>$other_params['ip'],
                'log_time'=>Carbon::now(),
                'log_info'=>'个人会员登陆'
            );
            UserLogRepository::create($userLog);
        }else{
            $firmLog = array(
                'firm_id'=>$info['id'],
                'firm_name'=>$info['user_name'],
                'ip_address'=>$other_params['ip'],
                'log_time'=>Carbon::now(),
                'log_info'=>'企业会员登陆'
            );
            FirmLogRepository::create($firmLog);
        }
        return $info;
    }


    //完善信息
    public static function updateUserInfo($id,$data){
        return UserRepository::modify($id,$data);
    }

}