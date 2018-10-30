<?php
namespace App\Services;

use App\Repositories\UserRealRepo;
use App\Repositories\UserRepo;

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

    //保存
    public static function create($data)
    {
        return UserRealRepo::create($data);
    }

    //修改审核状态
    public static function modifyReviewStatus($data)
    {
        try{
            if(!empty($data['attorney_letter_fileImg'])){
                //企业用户
                unset($data['attorney_letter_fileImg']);
                self::beginTransaction();
                $data['is_firm']=1;
                $user_real = UserRealRepo::modify($data);
                $user = UserRepo::modify($user_real['user_id'],['is_firm'=>1]);
                self::commit();
                return $user;
            }else{
                //个人用户
                unset($data['attorney_letter_fileImg']);
                return UserRealRepo::modify($data);
            }

        }catch(\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }



}