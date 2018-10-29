<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-29
 * Time: 16:55
 */
namespace App\Services;

use App\Repositories\InvoiceGoodsRepo;
use App\Repositories\OrderGoodsRepo;
use App\Repositories\OrderInfoRepo;

class InvoiceGoodsService
{
    use CommonService;

    /**
     * 多条件查询开票商品
     * @param $condition
     * @return array
     */
    public static function getInfoBySearch($condition)
    {
        $info =  InvoiceGoodsRepo::getList($condition);

        if (!empty($info)){
            foreach ($info as $k=>$v){
                $order_id = OrderGoodsRepo::getInfo($v['order_goods_id'])['order_id'];
                $info[$k]['order_sn'] = OrderInfoRepo::getInfo($order_id)['order_sn'];
            }
            return $info;
        }
    }
}
