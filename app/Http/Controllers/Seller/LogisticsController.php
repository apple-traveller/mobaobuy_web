<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-12-10
 * Time: 9:07
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\LogisticsService;
use Illuminate\Http\Request;

class LogisticsController extends Controller
{
    public function listView(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $shop_id = session('_seller_id')['shop_id'];
        $shipping_billno = $request->input('shipping_billno','');
        $order_id = $request->input('order_id','');
        $condition['is_delete']= 0;
        $condition['shop_id']= $shop_id;
        if (!empty($shipping_billno)){
            $condition['shipping_billno'] = $shipping_billno;
        }

        if (!empty($order_id)){
            $condition['order_id'] = $order_id;
        }
        $pageSize =5;
        $list = LogisticsService::getListWithPage(['pageSize'=>$pageSize,'page'=>$currentPage],$condition);
        return $this->display('seller.shopSalesman.list',[
            'total'=>$list['total'],
            'list'=>$list['list'],
            'currentPage'=>$currentPage,
            'shipping_billno' => $shipping_billno,
            'order_id' => $order_id,
            'pageSize'=>$pageSize
        ]);
    }

}
