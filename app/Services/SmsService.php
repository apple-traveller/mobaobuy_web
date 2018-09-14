<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-11
 * Time: 20:30
 */
namespace App\Services;

use App\Plugins\SMS\ALiDaYu;
use App\Plugins\SMS\DianJi;
use App\Repositories\SmsSupplierRepo;


class SmsService
{
    use CommonService;



    /**
     * @param $smsSupplier
     * @param $phoneNumbers
     * @param $temp_id
     * @param $signName
     * @param $templateParam
     * @param int $outId
     * @return DianJi\stdClass
     */
    public static function sendSms($phoneNumbers, $sms_type, $templateParam, $outId = 0)
    {
        $smsSupplier = SmsSupplierRepo::getInfoByFields(['is_checked'=>1]);

        if (!empty($smsSupplier))
        {
            $clazz = path();
            new $clazz

        }

        return $this->SMS->sendSms($phoneNumbers, $temp_id, $signName, $templateParam, $outId = 0);
    }


    /**
     * @param $phoneNumbers
     * @param $temp_id
     * @param $signName
     * @param $templateParam
     * @return DianJi\stdClass
     */
    public function sendBatchSms($phoneNumbers, $temp_id, $signName, $templateParam)
    {
        return $this->SMS->sendBatchSms($phoneNumbers, $temp_id, $signName, $templateParam);
    }
}
