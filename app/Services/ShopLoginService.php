<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-19
 * Time: 14:42
 */
namespace App\Services;

use App\Repositories\ShopRepo;
use App\Repositories\ShopUserRepo;
use Carbon\Carbon;

class ShopLoginService
{
    use CommonService;

    public static function Register($data)
    {

        try {
//            $shop = ShopRepo::getInfoByFields([]);
            dd($data);


        } catch (\Exception $e) {
            throwException($e);
        }
    }

    /**
     * 发送注册短信
     * @param $mobile
     * @return mixed|\stdClass
     * @throws \Exception
     */
    public static function sendRegisterCode($mobile)
    {
        $type = 'sms_signup';

        $code = SmsService::getRandom(6);

        session()->put('register_code', $code);

        return SmsService::sendSms($mobile, $type, $code);
    }

    /**
     * 获取商户管理者基本信息
     * @param $id
     * @return array
     */
    public static function getInfo($id)
    {
        $user_info = ShopUserRepo::getInfo($id);
        unset($user_info['password']);
       return $user_info;
    }

    /**
     * 检查店铺名是否存在
     * @param $ShopName
     * @return bool
     */
    public static function checkShopNameExists($ShopName)
    {
       if (ShopRepo::getTotalCount(['shop_name'=>$ShopName])){
           return true;
       }
       return false;
    }

}
