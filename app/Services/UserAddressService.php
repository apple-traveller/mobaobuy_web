<?php
namespace App\Services;

use App\Repositories\UserAddressRepo;
use App\Repositories\RegionRepo;
use League\Flysystem\Exception;

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
            if(!empty(RegionRepo::getInfo($vo['district']))){
                $user_address[$k]['district'] = RegionRepo::getInfo($vo['district'])['region_name'];
            }else{
                $user_address[$k]['district'] = "";
            }
            if(!empty($user_address[$k]['street'])){
                $user_address[$k]['street'] = RegionRepo::getInfo($vo['street'])['region_name'];
            }

        }
        return $user_address;
    }

    public static function getAddressInfo($address_id,$type='')
    {
        $info = UserAddressRepo::getInfo($address_id);
        if(empty($info)){
            return false;
        }
        if ($type){
            $address_names = RegionService::getRegion($info['country'], $info['province'], $info['city'], $info['district']);
        } else {
            $address_names = RegionService::getRegion($info['country'], $info['province'], $info['city'], $info['district'],$info['address']);
        }
        $str_address = $info['country'].'|'.$info['province'].'|'.$info['city'].'|'.$info['district'];
        $info['address_names'] = $address_names;
        $info['str_address'] = $str_address;
        return $info;
    }

    public static function getAddressInfoApi($address_id,$type='')
    {
        $info = UserAddressRepo::getInfo($address_id);
        if(empty($info)){
            return false;
        }

        $address_names = RegionService::getRegionApi($info['country'], $info['province'], $info['city'], $info['district']);

        $str_address = $info['country'].'|'.$info['province'].'|'.$info['city'].'|'.$info['district'];
        $info['address_names'] = $address_names;
        $info['str_address'] = $str_address;
        return $info;
    }

    public static function delete($id)
    {
        $user_info = session('_web_user');
        //先判断是否是默认地址
        try{
            self::beginTransaction();
            if($id == $user_info['address_id']){//是默认地址 清空user表的默认地址字段
                UserService::modify($user_info['id'],['address_id'=>0]);
            }
            $res = UserAddressRepo::delete($id);
            if(!$res){
                self::rollBack();
                self::throwBizError('删除失败');
            }
            self::commit();
            return true;
        }catch (Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }

    }

    public static function deleteApi($id,$user_info)
    {
        //先判断是否是默认地址
        try{
            self::beginTransaction();
            if($id == $user_info['address_id']){//是默认地址 清空user表的默认地址字段
                UserService::modify($user_info['id'],['address_id'=>0]);
            }
            $res = UserAddressRepo::delete($id);
            if(!$res){
                self::rollBack();
                self::throwBizError('删除失败');
            }
            self::commit();
            return true;
        }catch (Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }

    }

    //确认订单页 获取选中地址 有默认则为默认 没有默认任意选择一条
    public static function getOneAddressId()
    {
        $userInfo = session('_web_user');
        $info = session('_curr_deputy_user');
        //判断是否有默认地址如果有 则直接赋值 没有则取出一条
        //取地址信息的时候 要先判断是否是以公司职员的身份为公司下单 是则取公司账户的地址
        if($info['is_self'] == 0 && $info['is_firm'] == 1){
            if(isset($info['address_id']) && !empty($info['address_id'])){
                $address_id = $info['address_id'];
            }else{
                #取一条地址id
                $address_id = UserService::getOneAddressId($info['firm_id']);
            }
        }else{
            if($userInfo['address_id']){
                $address_id = $userInfo['address_id'];
            }else{
                #取一条地址id
                $address_id = UserService::getOneAddressId($userInfo['id']);
            }
        }
        return $address_id;
    }


    //确认订单页 获取选中地址 有默认则为默认 没有默认任意选择一条
    public static function getOneAddressIdApi($userInfo,$info)
    {

        //判断是否有默认地址如果有 则直接赋值 没有则取出一条
        if($info['is_self'] == 0 && $info['is_firm'] == 1){
            if(isset($info['address_id']) && !empty($info['address_id'])){
                $address_id = $info['address_id'];
            }else{
                #取一条地址id
                $address_id = UserService::getOneAddressId($info['firm_id']);
            }
        }else{
            if($userInfo['address_id']){
                $address_id = $userInfo['address_id'];
            }else{
                #取一条地址id
                $address_id = UserService::getOneAddressId($userInfo['id']);
            }
        }
        return $address_id;
    }

    public  static function  getInfoByConditions($data)
    {
        return UserAddressRepo::getInfoByFields($data);
    }


}
