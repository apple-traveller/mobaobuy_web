<?php

namespace App\Http\Controllers\Api;

use App\Services\OrderInfoService;
use Illuminate\Http\Request;
use Logistics\Client;

class KuaidiController extends ApiController
{
    public function searchWaybill(Request $request){
        require_once app_path('Plugins/Logistics/autoload.php');
        $delivery_id = $request->input('delivery_id');
        $delivery_info = OrderInfoService::getDeliveryInfo($delivery_id);
        $type = 'kdniao';
        try {
            switch ($type){
                case 'kdniao':
                    $kdniao_tr = [
                        '1' => \Logistics\Config::KDN_CHANNEL_YTO,
                        '2' => \Logistics\Config::KDN_CHANNEL_STO,
                        '3' => \Logistics\Config::KDN_CHANNEL_ZTO,
                        '4' => \Logistics\Config::KDN_CHANNEL_SF,
                        '5' => \Logistics\Config::KDN_CHANNEL_YZPY
                    ];
                    $ShipperCode = $kdniao_tr[$delivery_info['shipping_id']] ?? '';
                    if(!isset($ShipperCode) || empty($ShipperCode) || empty($delivery_info['shipping_billno'])){
                        return $this->error('异常运单号'.$ShipperCode.'--'.$delivery_info['shipping_billno']);
                    }
                    $config = require_once app_path('Plugins/Logistics/kdniaoConfig.php');
                    // 订单信息
                    $request_data = [
                        'OrderCode'    => '',
                        'ShipperCode'    => $ShipperCode,
                        'LogisticCode'    => $delivery_info['shipping_billno'],
                        'IsHandleInfo' => 0
                    ];

                    $json = Client::run(\Logistics\Config::KDNIAO_WL, $config, $request_data);
                    break;
                default:
                    $json = '{}';
            }

            return $this->success(\GuzzleHttp\json_decode($json),'success');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
            exit;
        }
    }

}
