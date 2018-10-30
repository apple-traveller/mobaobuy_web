<?php
namespace App\Services;

use App\Repositories\UserAddressRepo;
use App\Repositories\RegionRepo;
class UserAddressService
{
    use CommonService;

    //获取用户收货地址列表
    public static function getInfoByUserId($userid)
    {

        $user_address = UserAddressRepo::getList(['id'=>'desc'],['user_id'=>$userid]);
        foreach($user_address as $k=>$vo)
        {
            $user_address[$k]['province'] = RegionRepo::getInfo($vo['province'])['region_name'];
            $user_address[$k]['country'] = RegionRepo::getInfo($vo['country'])['region_name'];
            $user_address[$k]['city'] = RegionRepo::getInfo($vo['city'])['region_name'];
            $user_address[$k]['district'] = RegionRepo::getInfo($vo['district'])['region_name'];
            if(!empty($user_address[$k]['street'])){
                $user_address[$k]['street'] = RegionRepo::getInfo($vo['street'])['region_name'];
            }

        }
        return $user_address;
    }

    public static function getAddressInfo($address_id)
    {
        $info = UserAddressRepo::getInfo($address_id);
        $address_names = RegionService::getRegion($info['country'], $info['province'], $info['city'], $info['district'] );
        $str_address = $info['country'].'|'.$info['province'].'|'.$info['city'].'|'.$info['district'];
        $info['address_names'] = $address_names;
        $info['str_address'] = $str_address;
        return $info;
    }

    public static function delete($id)
    {
        return UserAddressRepo::delete($id);
    }

}
