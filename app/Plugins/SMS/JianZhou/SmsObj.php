<?php

require_once dirname(__DIR__) . '/SmsInterface.php';
ini_set("display_errors", "on");

class SmsObj implements SmsInterface
{
    protected $url = 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage';

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
    public function sendSms($phoneNumbers, $temp_id, $signName, $templateParam, $outId = 0)
    {
        if (!empty($templateParam['code'])){
            $content = str_replace('${code}',$templateParam['code'],$templateParam['temp_content'])."【{$signName}】";
        } else {
            $content = $templateParam['temp_content'];
        }

        $this->sendContentSms($phoneNumbers,$content);
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
    public function sendBatchSms($phoneNumbers, $temp_id, $signName, $templateParam)
    {
        return 'sdfs';
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

    public function sendContentSms($phoneNumbers, $content)
    {
        $params = [
            'mobile'        => $phoneNumbers,
            'content'       => $content,
        ];
        $this->request($params);
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
