<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\BaseService;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\Hash;
class AdminService extends BaseService
{

    public static function loginValidate($username, $psw)
    {
        $info = AdminRepository::getInfoByLoginName($username);
        if(empty($info)){
            self::throwError('用户名或密码不正确！');
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwError('用户名或密码不正确！');
        }

        if(!$info['is_super'] && !$info['is_freeze']){
            self::throwError('用户账号已冻结！');
        }
        unset($info['password']);

        return $info;
    }

}