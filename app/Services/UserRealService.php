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

    //修改(后台方法)
    public static function modify($data)
    {
        return UserRealRepo::modify($data['user_id'],$data);
    }

    //实名认证保存
    public static function saveUserReal($data,$is_self,$user_id)
    {
        //is_self 1 个人  2企业
        $userRealInfo = UserRealRepo::getInfoByFields(['user_id'=>$user_id]);
        if($is_self == 2){
            $GxInfo = GsxxService::GsSearch($data['real_name_firm']);
        }

        if(empty($GxInfo)){
            self::throwBizError('公司信息不存在，请检查');
        }

        $userRealArr = [];
        //修改
        if($userRealInfo){
            if($is_self == 1){
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name'];
//                $userRealArr['sex'] = $data['sex'];
//                $userRealArr['birthday'] = $data['birthday'];
                $userRealArr['front_of_id_card'] = $data['front_of_id_card'];
                $userRealArr['reverse_of_id_card'] = $data['reverse_of_id_card'];
                $userRealArr['add_time'] = Carbon::now();
            }else{
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name_firm'];
                $userRealArr['tax_id'] = $GxInfo['No'];
                $userRealArr['attorney_letter_fileImg'] = $data['attorney_letter_fileImg'];
                $userRealArr['invoice_fileImg'] = $data['invoice_fileImg'];
                $userRealArr['license_fileImg'] = $data['license_fileImg'];
                $userRealArr['company_name'] = $data['real_name_firm'];
//                $userRealArr['bank_of_deposit'] = $data['bank_of_deposit'];
//                $userRealArr['bank_account'] = $data['bank_account'];
//                $userRealArr['company_address'] = $data['company_address'];
//                $userRealArr['company_telephone'] = $data['company_telephone'];
                $userRealArr['add_time'] = Carbon::now();
            }
            return UserRealRepo::modify($userRealInfo['user_id'],$userRealArr);
        }else{
            //新增
            if($is_self == 1){
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name'];
//                $userRealArr['sex'] = $data['sex'];
//                $userRealArr['birthday'] = $data['birthday'];
                $userRealArr['front_of_id_card'] = $data['front_of_id_card'];
                $userRealArr['reverse_of_id_card'] = $data['reverse_of_id_card'];
                $userRealArr['add_time'] = Carbon::now();
            }else{
                $userRealArr['is_firm'] = 1;
                $userRealArr['user_id'] = $user_id;
                $userRealArr['real_name'] = $data['real_name_firm'];
                $userRealArr['tax_id'] = $GxInfo['No'];
                $userRealArr['attorney_letter_fileImg'] = $data['attorney_letter_fileImg'];
                $userRealArr['invoice_fileImg'] = $data['invoice_fileImg'];
                $userRealArr['license_fileImg'] = $data['license_fileImg'];
                $userRealArr['company_name'] = $data['real_name_firm'];
//                $userRealArr['bank_of_deposit'] = $data['bank_of_deposit'];
//                $userRealArr['bank_account'] = $data['bank_account'];
//                $userRealArr['company_address'] = $data['company_address'];
//                $userRealArr['company_telephone'] = $data['company_telephone'];
                $userRealArr['add_time'] = Carbon::now();
            }
            return UserRealRepo::create($userRealArr);
        }

    }

    //修改审核状态
    public static function modifyReviewStatus($data)
    {
        try{
                self::beginTransaction();
                $user_real = UserRealRepo::modify($data['user_id'],$data);
                if($data['is_firm']==1 && $data['review_status']==1){
                    //如果企业用户实名认证通过，user表里面的is_firm字段也要改
                    $user = UserRepo::modify($user_real['user_id'],['is_firm'=>1]);
                }
                self::commit();
                return $user_real;
        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }



}