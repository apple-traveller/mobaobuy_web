<?php

namespace App\Services;
use App\Repositories\UserLogRepo;
use App\Repositories\UserRepo;
use App\Repositories\UserRealRepo;
use App\Repositories\FirmLogRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Repositories\FirmRepo;
use App\Repositories\FirmBlacklistRepo;
use Illuminate\Support\Facades\Storage;
class UserLoginService
{
    use CommonService;
    //用户注册
    public static function userRegister($data){
//        if(empty(session('send_code')) || $data['mobile_code']!=session('send_code')){
//            exit('请求超时，请刷新页面后重试');
//        }

        $data['reg_time'] = Carbon::now();
        $data['password'] = bcrypt($data['password']);
        if($data['is_firm']){
            //企业
            //查找黑名单表是否存在
            $firmBlack = FirmBlacklistRepo::getInfoByFields(['firm_name'=>$data['nick_name']]);
            if($firmBlack){
                return 'error';
            }
            $userReal = [];
            $userReal['license_fileImg'] = $data['license_fileImg'];
            $userReal['business_license_id'] = $data['business_license_id'];
            $userReal['taxpayer_id'] = $data['taxpayer_id'];
            $userReal['add_time'] = Carbon::now();

            $attorneyImgPath = Storage::putFile('public', $data['attorney_letter_fileImg']);
            $attorneyImgPath = explode('/',$attorneyImgPath);
            $data['attorney_letter_fileImg'] = '/storage/'.$attorneyImgPath[1];

            $licensePath = Storage::putFile('public', $data['license_fileImg']);
            $licensePath = explode('/',$licensePath);
            $userReal['license_fileImg'] = '/storage/'.$licensePath[1];

            unset($data['business_license_id']);
            unset($data['license_fileImg']);
            unset($data['taxpayer_id']);
            unset($data['mobile_code']);

            self::beginTransaction();
            $user = UserRepo::create($data);
            $userReal['user_id'] = $user['id'];
            $real = UserRealRepo::create($userReal);
            if($user && $real){
                self::commit();
            }else{
                self::rollBack();
                return 'error';
            }
        }else{
            //个人
            $data['nick_name'] = rand(10000, 99999);
            unset($data['mobile_code']);
            self::beginTransaction();
            $user = UserRepo::create($data);
            $userReal['user_id'] = $user['id'];
            $userReal['add_time'] = Carbon::now();
            $real = UserRealRepo::create($userReal);
            if($user && $real){
                self::commit();
            }else{
                self::rollBack();
                return 'error';
            }

        }


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
         return UserRepo::getInfo($id);
    }

    //用户登录
    public static function loginValidate($username, $psw, $other_params = [])
    {
        if(!preg_match("/^1[345789]{1}\\d{9}$/",$username)){
           self::throwError('用户名或密码不正确!');
        }
        //查用户表
        $info = UserRepo::getInfoByUserName($username);
        if(empty($info)){
            self::throwError('用户名或密码不正确！');
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwError('用户名或密码不正确！');
        }

        if($info['is_freeze']){
            self::throwError('用户名或密码不正确！');
        }
        unset($info['password']);

        //写入日志
        //上次登录ip,时间,登陆访问次数
        $logsInfo = UserLogRepo::getLogsInfo($info['id']);
        if($logsInfo != 'error'){
            $logMes = ['last_ip'=>$logsInfo['ip_address'],'last_time'=>$logsInfo['log_time'],'visit_count'=>$logsInfo['count']];
            UserRepo::modify($info['id'],$logMes);
        }
        $userLog = array(
            'user_id'=>$info['id'],
            'ip_address'=>$other_params['ip'],
            'log_time'=>Carbon::now(),
            'log_info'=>'会员登陆'
        );
        UserLogRepo::create($userLog);
        return $info;
    }


    //完善信息
    public static function updateUserInfo($id,$data){
        return UserRepo::modify($id,$data);
    }


    //管理员后台
    //获取日志列表（分页）
    public static function getLogs($user_id,$pageSize)
    {
        return UserLogRepo::getLogs($user_id,$pageSize);
    }

    //获取日志总条数
    public static function getLogCount($user_id)
    {
        return UserLogRepo::getLogCount($user_id);
        //return UserLogRepo::getTotalCount();
    }

}