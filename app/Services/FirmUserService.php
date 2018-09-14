<?php
namespace App\Services;
use App\Repositories\FirmUserRepo;
use App\Repositories\UserRepo;
class FirmUserService
{
    use CommonService;
    public static function firmUserList(){

    }

    //增加企业用户
    public static function create($firmId,$userId,$permi){
        $userPermi = [];
        $userPermi['firm_id'] = $firmId;
        $userPermi['user_id'] = $userId;
        foreach($permi as $v){
            if($v == 1){
                $userPermi['can_po'] = 1;
            }
            if($v == 2){
                $userPermi['can_pay'] = 1;
            }
            if($v == 3){
                $userPermi['can_confirm'] = 1;
            }
            if($v){
                $userPermi['can_stock_in'] = 1;
            }
            if($v){
                $userPermi['can_stock_out'] = 1;
            }
        }
        return FirmUserRepo::create($userPermi);
    }

    //
    public static function update($id,$data){
        return FirmUserRepo::modify($id,$data);
    }

    public static function delete($id){
        return FirmUserRepo::delete($id);
    }

    public static function search($name){
        if(!preg_match("/^1[345789]{1}\\d{9}$/",$name)){
            self::throwBizError('用户名或密码不正确!');
        }
        return UserRepo::getInfoByUserName($name);
    }

}