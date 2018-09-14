<?php

/**
 * Created by PhpStorm.
 * User: kery
 * Date: 2018/9/11
 * Time: 9:31
 */
interface SmsInterface{

    public static function getConfigParams();

    public function setConfig($config);

    public function sendSms($phoneNumbers, $temp_id, $signName, $templateParam, $outId = 0);

    public function sendBatchSms($phoneNumbers, $temp_id, $signName, $templateParam);
}
