<?php
require_once dirname(__DIR__) . '/GSXXInterface.php';

/**
 * 企查查接口服务类
 * Class GsxxObj
 */
class GsxxObj implements GSXXInterface {
    protected $apikey;
    protected $secretKey;
//    protected $url = 'http://i.yjapi.com/ECIV4/GetDetailsByName';
    protected $url = 'http://api.qichacha.com/ECIV4/GetDetailsByName';
    protected $data_type = 'json';  //json|xml
    protected $db_recode = true;  //json|xml


    public static function getConfigParams()
    {

    }

    /**
     * 配置参数
     * @param $config
     */
    public function setConfig($config)
    {
        $this->apikey = $config['AccessID'];
        $this->secretKey = $config['secretKey'];
    }

    /**
     * 工商信息精简查询
     * @param $company_name
     * @return bool|string
     */
    public function getBaseInfo($company_name)
    {
        if(empty($company_name)){
            return false;
        }

        $timestamp = time();
        $token = strtoupper(md5($this->apikey.$timestamp.$this->secretKey));

        $headers = [
            'Token:'.$token,
            'Timespan:'.$timestamp,
        ];
        $url = $this->url.'?key='.$this->apikey.'&keyword='.$company_name;
          //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //执行命令
        $rs = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        if ($rs){
            return $rs;
        }
        return false;
    }
}
