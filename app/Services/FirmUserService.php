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
            if(in_array(1,$permi)){
                $userPermi['can_po'] = 1;
            }
            if(in_array(2,$permi)){
                $userPermi['can_pay'] = 1;
            }
            if(in_array(3,$permi)){
                $userPermi['can_confirm'] = 1;
            }
            if(in_array(4,$permi)){
                $userPermi['can_stock_in'] = 1;
            }
            if(in_array(5,$permi)){
                $userPermi['can_stock_out'] = 1;
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