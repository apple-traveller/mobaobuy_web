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

    protected $SMS;

    /**
     * 初始化 短信接口
     * SmsService constructor.
     */
    public function __construct()
    {
        $smsSupplier = SmsSupplierRepo::getInfoByFields(['is_checked'=>1]);

        if (!empty($smsSupplier))
        {
            switch ($smsSupplier['supplier_code'])
            {
                case 'ALiDaYu':

                    $this->SMS = new ALiDaYu\SmsObj();
                    break;

                case 'DianJi':

                    $this->SMS = new DianJi\SmsObj();
                    break;

                default: self::throwError('不存在该短信服务');
                    return;
            }
        }

    }

    /**
     * @param $smsSupplier
     * @param $phoneNumbers
     * @param $temp_id
     * @param $signName
     * @param $templateParam
     * @param int $outId
     * @return DianJi\stdClass
     */
    public function sendSms($phoneNumbers, $temp_id, $signName, $templateParam, $outId = 0)
    {

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
