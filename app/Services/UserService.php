<?php

namespace App\Services;
use App\Repositories\IndexRepo;
use App\Repositories\RegionRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    use CommonService;

    //更新收获地
    public static function updateShopAdderss(){

    }

    //新增收获地
    public static function addShopAddress(){

    }


    //获取省
    public static function provinceInfo($region_type){
        return RegionRepo::getProvince($region_type);
    }

    //获取市
    public static function getCity($regionId){
        return RegionRepo::getCity($regionId);
    }








    //后台
    //获取用户列表(导出excel表)
    public static function getUsers($fields)
    {
        $info = UserRepo::getUsers($fields);
        foreach($info as $key=>$item){
            if($item['sex']==1){
                $info[$key]['sex']="女";
            }else{
                $info[$key]['sex']="男";
            }
        }
        return $info;
    }

    //获取用户列表（分页）
    public static function getUserList($pageSize,$user_name)
    {
        $info = UserRepo::search($pageSize,$user_name);
        return $info;
    }


    //修改
    public static function modify($id,$data)
    {
        return UserRepo::modify($id,$data);
    }

    //查询一条数据
    public static function getInfo($id)
    {
        return UserRepo::getInfo($id);
    }


    //获取总条数
    public static function getCount($user_name)
    {
        return UserRepo::getCount($user_name);
    }
}