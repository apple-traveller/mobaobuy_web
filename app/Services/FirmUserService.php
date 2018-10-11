<?php
namespace App\Services;
use App\Repositories\FirmUserRepo;
use App\Repositories\UserRepo;
class FirmUserService
{
    use CommonService;
    //企业用户列表
    public static function firmUserList($firmId){
        return FirmUserRepo::firmUserList($firmId);
    }

    //增加企业用户
    public static function create($firmId,$userId,$permi,$userName){
        //查询是否已绑定
        $firmUserInfo = FirmUserRepo::getInfoByFields(['firm_id'=>$firmId,'user_id'=>$userId]);
        if($firmUserInfo){
            self::throwBizError('企业用户已绑定!');
        }
        $userPermi = [];
        $userPermi['firm_id'] = $firmId;
        $userPermi['user_id'] = $userId;
        $userPermi['real_name'] = $userName;
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

    //企业根据手机号码查询需要绑定的员工
    public static function search($firmId,$name){
        if(!preg_match("/^1[345789]{1}\\d{9}$/",$name)){
            self::throwBizError('手机号码格式不正确!');
        }

        $userInfo = UserRepo::getInfoByFields(['user_name'=>$name]);
        if($userInfo){
            $firmUserInfo = FirmUserRepo::getInfoByFields(['firm_id'=>$firmId,'user_id'=>$userInfo['id']]);
            if($firmUserInfo){
                self::throwBizError('用户已经绑定过本企业了');
            }
            return $userInfo;
        }
        self::throwBizError('未找到该用户');
    }
}