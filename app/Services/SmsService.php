<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-11
 * Time: 20:30
 */
namespace App\Services;
use App\Repositories\SmsSendTypeRepo;
use App\Repositories\SmsSupplierRepo;
use App\Repositories\SmsTempRepo;


class SmsService
{
    use CommonService;


    public static function sendSms($phoneNumbers, $type, $params, $outId = 0)
    {
        // 取得配置的服务商Code
        $smsSupplier = SmsSupplierRepo::getInfoByFields(['is_checked'=>1]);
        $Code = $smsSupplier['supplier_code'];
        $sms_dir = dirname(__DIR__) . "/Plugins/SMS/{$Code}/SmsObj.php";

        // 判断配置是否存在
        if (file_exists($sms_dir)){
            require_once $sms_dir;
            $sms = new \SmsObj();
        } else {
            return json_encode(['code'=>404,'msg'=>'']);
        }

        $config = json_decode($smsSupplier['supplier_config'],true);

        $sms->setConfig($config);

        $send_type = SmsSendTypeRepo::getInfoByFields(['type_code'=>'sms_signup']);
        dd($send_type);
        $where = [
            'supplier_id'=>$smsSupplier['id'],
            'type_code'=> $type
        ];

        // 取得模板内容
        $tempInfo = SmsTempRepo::getTemp($where);

        $templateParam = [
            'code' => $params,
//            're_code' =>
            'temp_content' => $tempInfo['temp_content']
        ];

        return $sms->sendSms($phoneNumbers, $tempInfo['id'], $tempInfo['set_sign'], $templateParam, $outId = 0);
    }


    /**
     * @param $phoneNumbers
     * @param $temp_id
     * @param $signName
     * @param $templateParam
     * @return DianJi\stdClass
     */
    public static function sendBatchSms($phoneNumbers, $temp_id, $signName, $templateParam)
    {
        // 取得配置的服务商Code
        $smsSupplier = SmsSupplierRepo::getInfoByFields(['is_checked'=>1]);
        $Code = $smsSupplier['supplier_code'];

        // 判断配置是否存在
        if (file_exists(dirname(__DIR__) . "/Plugins/SMS/{$Code}/SmsObj.php")){
            require_once dirname(__DIR__) . "/Plugins/SMS/{$Code}/SmsObj.php";
            $sms = new \SmsObj();
        } else {

            return json_encode(['code'=>404,'msg'=>'不存在相关配置']);
        }

        return $sms->sendBatchSms($phoneNumbers, $temp_id, $signName, $templateParam);
    }
}
