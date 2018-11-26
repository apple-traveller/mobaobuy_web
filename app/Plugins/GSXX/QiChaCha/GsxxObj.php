<?php
require_once dirname(__DIR__) . '/GSXXInterface.php';

/**
 * 企查查接口服务类
 * Class GsxxObj
 */
class GsxxObj implements GSXXInterface {
    protected $apikey;
    protected $url = 'http://i.yjapi.com/ECIV4/GetDetailsByName';
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

        $params = array(
            "key" => $this->apikey,
            "keyword" => $company_name,
            "dtype" => $this->data_type,
        );
        $url = $this->url . '?' . http_build_query($params);
        $rs = file_get_contents($url);
        if ($rs){
            return $rs;
        }
    }
}
