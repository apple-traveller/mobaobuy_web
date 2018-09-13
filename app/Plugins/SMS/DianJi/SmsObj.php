<?php
namespace App\Plugins\SMS\DianJi;
ini_set("display_errors", "on");


/**
 * Class SmsDemo
 *
 * 这是短信服务API产品的DEMO程序，直接执行此文件即可体验短信服务产品API功能
 * (只需要将AK替换成开通了云通信-短信服务产品功能的AK即可)
 * 备注:Demo工程编码采用UTF-8
 */
class SmsObj implements \App\Plugins\SMS\SmsInterface
{

    public $_config = null;

    public static function getConfigParams()
    {
        return ['AccessKeyID' => '用户AccessKey ID', 'AccessKeySecret' => 'Access Key Secret'];
    }

    public function setConfig($config)
    {
        $this->_config = $config;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public function sendSms($phoneNumbers, $temp_id, $signName, $templateParam, $outId = 0)
    {

        //短信接口地址
        $target = "http://ip:port/msgHttp/json/mt";

        //生成的随机数
        $timestamps = rand(1000,9999);


        $post_data = "account={$this->_config['AccessKeyID']}&password={$this->_config['AccessKeySecret']}&mobile=$phoneNumbers&content=$templateParam&tamps=$timestamps";
        return  self::Post($post_data,$target);
//        return \Aliyun\Core\Http\HttpHelper::curl($target,'POST',$post_data);
    }


    /**
     * 批量发送短信
     * @return stdClass
     */
    public function sendBatchSms($phoneNumbers, $temp_id, $signName, $templateParam)
    {
            //短信接口地址
        $target = "http://ip:port/msgHttp/json/mt";

        //生成的随机数
        $timestamps = rand(1000,9999);
        if (is_array($phoneNumbers)){
            foreach ($phoneNumbers as $k=>$v){
                $post_data = "account={$this->_config['AccessKeyID']}&password={$this->_config['AccessKeySecret']}&mobile=$v&content=$templateParam&tamps=$timestamps";
                return  self::Post($post_data,$target);
                return \Aliyun\Core\Http\HttpHelper::curl($target,'POST',$post_data);
            }
        }
    }

    public static function Post($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }


}
