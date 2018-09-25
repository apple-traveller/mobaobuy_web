<?php

require_once dirname(__DIR__) . '/SmsInterface.php';
ini_set("display_errors", "on");

class SmsObj implements SmsInterface
{
    protected $url = 'http://139.129.128.71:8086/msgHttp/json/mt';

    public $_config = null;

    public static function getConfigParams()
    {
        return ['AccessKeyID' => 'AccessKeyID', 'AccessKeySecret' => 'Access Key Secret'];
    }


    /**
     * @param $config
     */
    public function setConfig($config)
    {
        $this->_config = $config;
    }

    /**
     * 发送短信
     * @param $phoneNumbers
     * @param $temp_id
     * @param $signName
     * @param $templateParam
     * @param int $outId
     */
    public function sendSms($phoneNumbers, $temp_id, $temp_content, $templateParam, $signName, $outId = 0)
    {
        foreach ($templateParam as $k => $v){
            $temp_content = str_replace('${'.$k.'}', $v ,$temp_content);
        }

        $temp_content .= "【".$signName."】";

        return $this->sendContentSms($phoneNumbers,$temp_content);
    }

    /**
     * 批量发送短信
     * @param $phoneNumbers
     * @param $temp_id
     * @param $signName
     * @param $templateParam
     * @return \Aliyun\Core\Http\HttpResponse|mixed|string
     * @throws \Aliyun\Core\Exception\ClientException
     */
    public function sendBatchSms($phoneNumbers, $temp_id, $temp_content, $templateParam, $signName)
    {
        foreach ($templateParam as $k => $v){
            $temp_content = str_replace('${'.$k.'}', $v ,$temp_content);
        }

        $temp_content .= "【".$signName."】";

        if (is_array($phoneNumbers)){
            $phoneNumbers = implode(',',$phoneNumbers);
        }

        return $this->sendContentSms($phoneNumbers, $temp_content);

    }

    /**
     * 组合参数
     * @param $phoneNumbers
     * @param $content
     */
    public function sendContentSms($phoneNumbers, $content)
    {
        $params = [
            'mobile'        => $phoneNumbers,
            'content'       => $content,
        ];
       return $this->request($params);
    }


    /**
     * 组合秘钥
     * @param array $params
     * @return array
     */
    protected function createParams(array $params)
    {
        $timestamps = time()*1000;
        $params = array_merge([
            'account' => $this->_config['account'],
            'password' => md5($this->_config['password'].$params['mobile'].$timestamps),
            'timestamps'  => $timestamps,
        ], $params);

        return $params;
    }

    /**
     *  发送
     * @param $params
     * @return mixed
     */
    protected function request($params)
    {
        $url = $this->url;
        $params = $this->createParams($params);
        return $this->Post($url,$params);
    }

    /**
     * Curl
     * @param $curlPost
     * @param $url
     * @return mixed
     */
    public function Post($url,$params){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }


}
