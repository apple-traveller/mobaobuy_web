<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-11
 * Time: 20:30
 */
namespace App\Services;
use App\Repositories\SmsSendLogRepo;
use App\Repositories\SmsSupplierRepo;
use App\Repositories\SmsTempRepo;
use Carbon\Carbon;


class SmsService
{
    use CommonService;


    /**
     * @param $phoneNumbers
     * @param $type
     * @param $params
     * @param int $outId
     * @throws \Exception
     */
    public static function sendSms($phoneNumbers, $type, $params, $outId = 0)
    {
        if (empty($phoneNumbers)){
            self::throwBizError('手机号不能为空');
        }
        // 取得配置的服务商Code
        $smsSupplier = SmsSupplierRepo::getInfoByFields(['is_checked'=>1]);
        $Code = $smsSupplier['supplier_code'];
        $sms_dir = dirname(__DIR__) . "/Plugins/SMS/{$Code}/SmsObj.php";

        // 判断配置是否存在
        if (file_exists($sms_dir)){
            require_once $sms_dir;
        } else {
            self::throwBizError('配置文件不存在');
        }

        $config = json_decode($smsSupplier['supplier_config'],true);

        $sms = new \SmsObj();
        $sms->setConfig($config);

        // 取得模板内容
        $where = [
            'supplier_id'=>$smsSupplier['id'],
            'type_code'=> $type
        ];
//        dd($where);
        $tempInfo = SmsTempRepo::getInfoByFields($where);
        if (empty($tempInfo)){
            self::throwBizError('没有模板信息');
        }

        $rs = $sms->sendSms($phoneNumbers, $tempInfo['temp_id'], $tempInfo['temp_content'], $params, $tempInfo['set_sign'], $outId = 0);

        $log_info = [
            'template_id' => $tempInfo['id'],
            'phone_numbers' => $phoneNumbers,
            'params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'sms_rs' => $rs,
            'sent_time' => Carbon::now()
        ];

        SmsSendLogRepo::create($log_info);
    }

    /**
     * @param $phoneNumbers
     * @param $type
     * @param $params
     * @return \Aliyun\Core\Http\HttpResponse|false|mixed|\stdClass|string
     * @throws \Exception
     */
    public static function sendBatchSms($phoneNumbers, $type, $params)
    {
        if (empty($phoneNumbers)){
            self::throwBizError('手机号不能为空');
        }
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
        try{
        $re =  $sms->sendBatchSms($phoneNumbers, $tempInfo['id'], $tempInfo['set_sign'], $templateParam);
            if ($re){
                if (is_array($phoneNumbers)){
                    $phone_numbers = implode(',',$phoneNumbers);
                } else {
                    $phone_numbers = $phoneNumbers;
                }
                $_params = str_replace('${code}',$templateParam['code'],$templateParam['temp_content'])."【{$tempInfo['set_sign']}】";
                $log_data = [
                    'template_id'=>$tempInfo['id'],
                    'phone_numbers'=>$phone_numbers,
                    'params'=>$_params,
                    'sms_rs'=>$re,
                    'sent_time'=>Carbon::now()
                ];
                SmsSendLogRepo::create($log_data);
                return $re;
            } else {
                throwException('发送失败');
            }

        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * 获取一个自定义长度的随机数
     * @param int $length
     * @param string $content
     * @return string
     */
    public static function getRandom($length=6,$content='123456789'){
        $string = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            $string .= $content[mt_rand(0, strlen($content) - 1)];
        }
        return $string;
    }
}
