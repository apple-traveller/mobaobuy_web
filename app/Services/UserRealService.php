<?php
namespace App\Services;

use App\Repositories\UserRealRepo;
use App\Repositories\UserRepo;
use Carbon\Carbon;

class UserRealService
{
    use CommonService;



    //查询一条数据
    public static function getInfoByUserId($userid)
    {
        return UserRealRepo::getInfoByFields(['user_id'=>$userid]);
    }

    //查询一条数据
    public static function getInfo($id)
    {
        return UserRealRepo::getInfo($id);
    }

    //修改
    public static function modify($data)
    {
        return UserRealRepo::modify($data);
    }

    //实名认证保存
    public static function saveUserReal($data,$is_self,$user_id)
    {
        //is_self 1 个人  2企业
        $userRealInfo = UserRealRepo::getInfoByFields(['user_id'=>$user_id]);

        $userRealArr = [];
        //修改
        if($userRealInfo){
            if($is_self == 1){
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name'];
                $userRealArr['sex'] = $data['sex'];
                $userRealArr['birthday'] = $data['birthday'];
                $userRealArr['front_of_id_card'] = $data['front_of_id_card'];
                $userRealArr['reverse_of_id_card'] = $data['reverse_of_id_card'];
                $userRealArr['add_time'] = Carbon::now();
            }else{
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name_firm'];
                $userRealArr['tax_id'] = $data['tax_id'];
                $userRealArr['attorney_letter_fileImg'] = $data['attorney_letter_fileImg'];
                $userRealArr['invoice_fileImg'] = $data['invoice_fileImg'];
                $userRealArr['license_fileImg'] = $data['license_fileImg'];
                $userRealArr['company_name'] = $data['company_name'];
                $userRealArr['bank_of_deposit'] = $data['bank_of_deposit'];
                $userRealArr['bank_account'] = $data['bank_account'];
                $userRealArr['company_address'] = $data['company_address'];
                $userRealArr['company_telephone'] = $data['company_telephone'];
                $userRealArr['add_time'] = Carbon::now();
            }
            return UserRealRepo::modify($userRealInfo['user_id'],$userRealArr);
        }else{
            //新增
            if($is_self == 1){
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name'];
                $userRealArr['sex'] = $data['sex'];
                $userRealArr['birthday'] = $data['birthday'];
                $userRealArr['front_of_id_card'] = $data['front_of_id_card'];
                $userRealArr['reverse_of_id_card'] = $data['reverse_of_id_card'];
                $userRealArr['add_time'] = Carbon::now();
            }else{
                $userRealArr['is_firm'] = 1;
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name_firm'];
                $userRealArr['tax_id'] = $data['tax_id'];
                $userRealArr['attorney_letter_fileImg'] = $data['attorney_letter_fileImg'];
                $userRealArr['invoice_fileImg'] = $data['invoice_fileImg'];
                $userRealArr['license_fileImg'] = $data['license_fileImg'];
                $userRealArr['company_name'] = $data['company_name'];
                $userRealArr['bank_of_deposit'] = $data['bank_of_deposit'];
                $userRealArr['bank_account'] = $data['bank_account'];
                $userRealArr['company_address'] = $data['company_address'];
                $userRealArr['company_telephone'] = $data['company_telephone'];
                $userRealArr['add_time'] = Carbon::now();
            }
            return UserRealRepo::create($userRealArr);
        }

    }


}