<?php
namespace App\Services;

use App\Repositories\UserAddressRepo;
class UserAddressService
{
    use CommonService;

    //获取用户收货地址列表
    public static function getInfoByUserId($userid)
    {

        return UserAddressRepo::getList(['id'=>'desc'],['user_id'=>$userid]);
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
