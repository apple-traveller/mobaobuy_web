<?php
namespace Logistics\Charge\KDNiao;

/**
 * @author: helei
 * @createTime: 2016-07-14 18:20
 * @description: 支付宝移动支付接口
 * @link      https://www.gitbook.com/book/helei112g1/payment-sdk/details
 * @link      https://helei112g.github.io/
 */
class KDNiaoCharge
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    //调用查询物流轨迹

    /**
     * Json方式 查询订单物流轨迹
     */
    public function handle($request_data){
        $EBusinessID = $this->config['EBusinessID'];
        //电商加密私钥，快递鸟提供，注意保管，不要泄漏
        $AppKey= $this->config['ApiKey'];
        //请求url
        $ReqURL='http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
        $request_data = json_encode($request_data);
        $datas = array(
            'EBusinessID' => $EBusinessID,
            'DataType' => '2',
            'RequestType' => '1002',
            'RequestData' => urlencode($request_data) ,
        );
        $datas['DataSign'] = $this->encrypt($request_data, $AppKey);
        $result= $this->sendPost($ReqURL, $datas);
        //根据公司业务处理返回的信息......
        return $result;
    }

    /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
    function sendPost($url, $datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if(empty($url_info['port']))
        {
            $url_info['port']=80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
    function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
}
