<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use App\Services\OrderInfoService;
use Illuminate\Http\Request;
use Logistics\Client;

class KuaidiController extends Controller
{
    public function searchWaybill(Request $request){
        require_once app_path('Plugins/Logistics/autoload.php');
        $id = $request->input('id');
        $search_type = $request->input('search_type','order');

        switch ($search_type){
            case 'order':
                $delivery_info = OrderInfoService::getDeliveryInfo($id);
                break;
            case 'invoice':
                $delivery_info = InvoiceService::getInfoById($id);
                break;
            default:
                $delivery_info = [];
        }
//        dd($delivery_info);
        if(empty($delivery_info)){
            return $this->error('获取物流信息失败');
        }
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
//                    $ShipperCode = $kdniao_tr['3'] ?? '';
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
//                    $request_data['LogisticCode'] = '75111968305523';
                    $json = Client::run(\Logistics\Config::KDNIAO_WL, $config, $request_data);
                    break;
                default:
                    $json = '{}';
            }
            return $this->success('', '', \GuzzleHttp\json_decode($json));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
            exit;
        }
    }

}
