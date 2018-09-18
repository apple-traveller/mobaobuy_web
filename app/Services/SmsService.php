<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-11
 * Time: 20:30
 */
namespace App\Services;
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
          self::throwBizError('配置文件不存在');
        }

        $config = json_decode($smsSupplier['supplier_config'],true);

        $sms->setConfig($config);

        $where = [
            'supplier_id'=>$smsSupplier['id'],
            'type_code'=> $type
        ];

        // 取得模板内容
        $tempInfo = SmsTempRepo::getTemp($where);
        if (empty($tempInfo)){
            self::throwBizError('没有模板信息');
        }

        $templateParam = [
            'code' => $params,
            'temp_content' => $tempInfo['temp_content']
        ];
        return $sms->sendSms($phoneNumbers, $tempInfo['id'], $tempInfo['set_sign'], $templateParam, $outId = 0);
    }

    /**
     * @param $phoneNumbers
     * @param $temp_id
     * @param $signName
     * @param $templateParam
     * @return \Aliyun\Core\Http\HttpResponse|mixed|\stdClass|string
     */
    public static function sendBatchSms($phoneNumbers, $type, $params)
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

        $where = [
            'supplier_id'=>$smsSupplier['id'],
            'type_code'=> $type
        ];

        // 取得模板内容
        $tempInfo = SmsTempRepo::getTemp($where);

        if (empty($tempInfo)){
            self::throwBizError('没有模板信息');
        }

        $templateParam = [
            'code' => $params,
            'temp_content' => $tempInfo['temp_content']
        ];

        return $sms->sendBatchSms($phoneNumbers, $tempInfo['id'], $tempInfo['set_sign'], $templateParam);
    }
}
