<?php


ini_set("display_errors", "on");


class SmsObj implements \App\Plugins\SMS\SmsInterface
{

    protected $username;
    protected $password;
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
     * 组合秘钥
     * @param array $params
     * @return array
     */
    protected function createParams(array $params)
    {
        $timestamps = time()*1000;
        $params = array_merge([
            'account' => $this->username,
            'password' => md5($this->password.$params['mobile'].$timestamps),
            'timestamps'  => $timestamps,
        ], $params);

        return $params;
    }

    /**
     * 发送短信
     * @return stdClass
     */
    public function sendSms($phoneNumbers, $temp_id, $signName, $templateParam, $outId = 0)
    {
        if (!empty($templateParam['code'])){
            $content = str_replace('code:验证码',$templateParam['code'],$templateParam['content']);
        }
    }


    /**
     * 批量发送短信
     * @return stdClass
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

    /**
     * Curl
     * @param $curlPost
     * @param $url
     * @return mixed
     */
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
