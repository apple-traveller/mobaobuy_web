<?php
require_once dirname(__DIR__) . 'GSXXInterface.php';

/**
 * 企查查接口服务类
 * Class GsxxObj
 */
class GsxxObj implements GSXXInterface {
    protected $apikey = '**************';
    protected $data_type = 'json';  //json|xml
    protected $db_recode = true;  //json|xml


    public static function getConfigParams()
    {

    }

    public function setConfig($config){

    }

    public function getBaseInfo($company_name)
    {

    }
    /**
     * 企业关键字模糊查询(精简)
     * @param $keyword
     * @return bool|string
     */
    public function simple_search($keyword){
        $base_url = 'http://i.yjapi.com/ECISimple/Search';
        if(empty($keyword)){
            return false;
        }

        $params = array(
            "key" => $this->apikey,
            "keyword" => $keyword,
            "dtype" => $this->data_type,
        );

        $url = $base_url . '?' . http_build_query($params);
        $rs = file_get_contents($url);
        if($this->db_recode){
            $this->recodeToDB($base_url, json_encode($params), $rs);
        }
        return $rs;
    }

    /**
     * 企业关键字模糊查询(精简)
     * @param $keyno
     * @return bool|string
     */
    public function simple_getDetails($keyno){
        $base_url = 'http://i.yjapi.com/ECISimple/GetDetails';
        if(empty($keyno)){
            return false;
        }

        $params = array(
            "key" => $this->apikey,
            "keyno" => $keyno,
            "dtype" => $this->data_type,
        );

        $url = $base_url . '?' . http_build_query($params);
        $rs = file_get_contents($url);
        if($this->db_recode){
            $this->recodeToDB($base_url, json_encode($params), $rs);
        }
        return $rs;
    }

    /**
     * 企业关键字模糊查询(精简)
     * @param $keyword
     * @return bool|string
     */
    public function simple_getDetailsByName($keyword){
        $base_url = 'http://i.yjapi.com/ECISimple/GetDetailsByName';
        if(empty($keyword)){
            return false;
        }

        $params = array(
            "key" => $this->apikey,
            "keyword" => $keyword,
            "dtype" => $this->data_type,
        );
        $url = $base_url . '?' . http_build_query($params);
        $res = $this->checkDB($keyword);
        if (empty($res)) {
            $rs = file_get_contents($url);
            if($this->db_recode){
                $this->recodeToDB($base_url, json_encode($params), $rs);
            }
            $rs = json_decode($rs);

            if($rs->Status === '200') {
                $data = [
                    'KeyNo' => $rs->Result->KeyNo,
                    'Name' => $rs->Result->Name,
                    'No' => $rs->Result->No,
                    'BelongOrg' => $rs->Result->BelongOrg,
                    'OperName' => $rs->Result->OperName,
                    'StartDate' => $rs->Result->StartDate,
                    'EndDate' => $rs->Result->EndDate,
                    'Status' => $rs->Result->Status,
                    'Province' => $rs->Result->Province,
                    'UpdatedDate' => $rs->Result->UpdatedDate,
                    'CreditCode' => $rs->Result->CreditCode,
                    'RegistCapi' => $rs->Result->RegistCapi,
                    'EconKind' => $rs->Result->EconKind,
                    'Address' => $rs->Result->Address,
                    'Scope' => $rs->Result->Scope,
                    'TermStart' => $rs->Result->TermStart,
                    'TeamEnd' => $rs->Result->TeamEnd,
                    'CheckDate' => $rs->Result->CheckDate,
                ];
                if ($this->db_recode) {
                    $rep = new GsxxCompany();
                    $res = $rep->create($data);
                }
                return $res;
            }else{
                if(!empty($rs->Message)){
                    return false;
                }
            }
            return "";
        }
        return $res;
    }

    /**
     * 查询企业经营异常信息
     * @param $keyno
     * @return bool|string
     */
    public function getOpException($keyno){
        $base_url = 'http://i.yjapi.com/ECIException/GetOpException';
        if(empty($keyno)){
            return false;
        }

        $params = array(
            "key" => $this->apikey,
            "keyno" => $keyno,
            "dtype" => $this->data_type,
        );

        $url = $base_url . '?' . http_build_query($params);
        $rs = file_get_contents($url);
        if($this->db_recode){
            $this->recodeToDB($base_url, json_encode($params), $rs);
        }
        return $rs;
    }

    /**
     * 数据存储到数据库
     * @param $url
     * @param $url,$params,$result_info
     * @param $result_info
     */
    protected function recodeToDB($url, $params, $result_info){
        $data = [
            'url'   => $url,
            'params'   => $params,
            'result_info'   => $result_info,
            'created_at'   => date('Y-m-d H:i:s', time()),
            'updated_at'   => date('Y-m-d H:i:s', time()),
        ];
        $rep = new GsxxLog();
        $rep->create($data);
    }

    protected function checkDB($keyword){
        $rep = new GsxxCompany();
        $res = $rep->where('Name',$keyword)->first();
        return $res;

    }
}
