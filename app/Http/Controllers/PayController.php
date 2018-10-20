<?php

namespace App\Http\Controllers;

use App\Services\OrderInfoService;
use Illuminate\Http\Request;
use Payment\Client\Charge;
use Payment\Common\PayException;
use Payment\Config;

class PayController extends Controller
{
    public function orderPay(Request $request){
        require_once app_path('Plugins/payment/autoload.php');
        $order_id = $request->input('order_id');
        $pay_type = $request->input('pay_type');
        $order_info = OrderInfoService::getOrderInfoById($order_id);
        try {
            switch ($pay_type){
                case 'alipay':
                    $payConfig = require_once app_path('Plugins/payment/examples/aliconfig.php');
                    // 订单信息
                    $orderNo = $order_info['order_sn'];
                    $payData = [
                        'body'    => '一批商品',
                        'subject'    => getConfig('shop_name').'在线购物支付',
                        'order_no'    => $orderNo,
                        'timeout_express' => time() + 600,// 表示必须 600s 内付款
                        'amount'    => $order_info['order_amount'],// 单位为元 ,最小为0.01
                        'return_param' => '',
                        // 'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',// 客户地址
                        'goods_type' => '1',// 0—虚拟类商品，1—实物类商品
                        'store_id' => '',
                        'qr_mod' => '',
                    ];
                    $url = Charge::run(Config::ALI_CHANNEL_WEB, $payConfig, $payData);
                    break;
                case 'wxpay':
                    $payConfig = require_once app_path('Plugins/payment/examples/wxconfig.php');
                    $orderNo = $order_info['order_sn'];
                    $payData = [
                        'body'    => '一批商品',
                        'subject'    => getConfig('shop_name').'在线购物支付',
                        'order_no'    => $orderNo,
                        'timeout_express' => time() + 600,// 表示必须 600s 内付款
                        'amount'    => $payConfig['use_sandbox'] ? '3.01' : $order_info['order_amount'],// 微信沙箱模式，需要金额固定为3.01
                        'return_param' => '123',
                        'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',// 客户地址
                        'openid' => 'ohQeiwnNrAsfdsdf9VvmGFIhba--k',
                        'product_id' => '123',

                        // 如果是服务商，请提供以下参数
                        'sub_appid' => '',//微信分配的子商户公众账号ID
                        'sub_mch_id' => '',// 微信支付分配的子商户号
                    ];
                    $url = Charge::run(Config::WX_CHANNEL_QR, $payConfig, $payData);
            }

            return $this->redirect($url);
        } catch (PayException $e) {
            echo $e->errorMessage();
            exit;
        }
    }

    //支付完事之后的事情
    public function webhooks(Request $request){

        /*$raw_data = file_get_contents('php://input');//这是在ping++设置的回调传回来的值
        $headers = \Pingpp\Util\Util::getRequestHeaders();
        $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
        $pub_key_path =__DIR__ . '/public_key.pem';//公钥
        $result = $this -> verify_signature($raw_data, $signature, $pub_key_path);//验证身份
        if ($result === 1) {
            // 验证通过
            $event = json_decode($raw_data, true);
            if ($event['type'] == 'charge.succeeded') {
                $charge = $event['data']['object'];
                $order_sn = $charge['order_no'];//订单号
                $return_num = $charge['id'];//付款成功后的回执
                //更改订单状态
                do something by myself

            }
        } elseif ($result === 0) {
            http_response_code(400);
            echo 'verification failed';
            exit;
        } else {
            http_response_code(400);
            echo 'verification error';
            exit;
        }*/
    }
}
