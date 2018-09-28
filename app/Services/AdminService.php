<?php
namespace App\Services;
use App\Repositories\AdminRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
class AdminService
{
    use CommonService;

    public static function loginValidate($username, $psw, $other_params)
    {
        $info = AdminRepo::getInfoByFields(['user_name'=>$username]);
        if(empty($info)){
            self::throwBizError('用户名或密码不正确！');
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwBizError('用户名或密码不正确！');
        }

        if(!$info['is_super'] && $info['is_freeze']){
            self::throwBizError('用户账号已冻结！');
        }

        //登录成功后事件
        createEvent('adminUserLogin', ['user_id'=>$info['id'], 'client_ip'=>$other_params['ip']]);
        return $info['id'];
    }

    public static function getInfo($admin_id){
        $info = AdminRepo::getInfo($admin_id);
        unset($info['password']);
        return $info;
    }


    //获取所有数据
    public static function getAdminList($pager,$condition)
    {
        return AdminRepo::getListBySearch($pager, $condition);
    }

    public static function updateLoginField($id, $data){
        $info = AdminRepo::getInfo($id);
        //修改用户登录次数
        $lastInfo = [
            'last_ip' => $data['client_ip'],
            'last_time' => Carbon::now(),
            'visit_count' => $info['visit_count'] + 1
        ];
        AdminRepo::modify($id, $lastInfo);

    }
}