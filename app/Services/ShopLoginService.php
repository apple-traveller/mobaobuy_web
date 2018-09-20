<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-19
 * Time: 14:42
 */
namespace App\Services;

use App\Repositories\ShopRepo;
use Carbon\Carbon;

class ShopLoginService
{
    use CommonService;

    public static function Register($data)
    {

        try{
//            $shop = ShopRepo::getInfoByFields([]);
            dd($data);


        }catch (\Exception $e){
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

        session()->put('register_code',$code);

        return SmsService::sendSms($mobile,$type,$code);
    }

}
