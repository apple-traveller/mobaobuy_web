<?php
namespace App\Services;
use App\Repositories\RegionRepo;
use App\Repositories\UserAddressRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Repositories\UserRepo;
use App\Repositories\UserRealRepo;
class UserService
{
    use CommonService;

    //
    public static function shopAddressList($condi){
        return UserAddressRepo::getList($order=[],$condi);
    }

    //更新收获地
    public static function updateShopAdderss($id,$data){
        return UserAddressRepo::modify($id,$data);
    }

    //新增收获地
    public static function addShopAddress($data){
        return UserAddressRepo::create($data);
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
        return $info;
    }

    //获取用户列表（分页）
    public static function getUserList($pager,$condition)
    {
        //$info = UserRepo::search($pageSize,$user_name);
        $info = UserRepo::getListBySearch($pager,$condition);
        foreach($info['list'] as $k=>$v) {
            $userreal = UserRealRepo::getInfoByFields(['user_id'=>$v['id']]);
            if(!empty($userreal)){
                $info['list'][$k]['userreal']=$userreal['review_status'];
            }else{
                $info['list'][$k]['userreal']=0;
            }
        }
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