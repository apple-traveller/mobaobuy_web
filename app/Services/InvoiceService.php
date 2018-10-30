<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-29
 * Time: 10:44
 */
namespace App\Services;

use App\Repositories\InvoiceGoodsRepo;
use App\Repositories\InvoiceRepo;
use App\Repositories\OrderGoodsRepo;
use App\Repositories\OrderInfoRepo;
use phpDocumentor\Reflection\Types\Self_;

class InvoiceService
{
    use CommonService;

    /**
     * 带分页的列表
     * @param $page
     * @param $condition
     * @return mixed
     */
    public static function getListBySearch($page,$condition)
    {
        return InvoiceRepo::getListBySearch($page,$condition);
    }

    /**
     * 根据id查info
     * @param $id
     * @return array
     */
    public static function getInfoById($id)
    {
        $info =  InvoiceRepo::getInfo($id);
        $info['address_str'] = RegionService::getRegion($info['country'],$info['province'],$info['city'],$info['district']);
        return $info;
    }

    /**
     * 发票更新
     * @param $id
     * @param $data
     * @return bool
     */
    public static function updateInvoice($id,$data)
    {
        return InvoiceRepo::modify($id,$data);
    }


    /**
     * 审核发票
     * @param $invoice_id
     * @param $data
     * @throws \Exception
     */
    public static function verifyInvoice($invoice_id,$data)
    {
        // 生成唯一开票号
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $invoice_numbers = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        $data['invoice_numbers'] = $invoice_numbers;
        $data['status'] = 2;
        try{
            // 查询订单商品id
            $goods_list = InvoiceGoodsRepo::getList([],['invoice_id'=>$invoice_id]);
            $goods_ids_str = '';
            foreach ($goods_list as $k=>$v){
                if ($k==0){
                    $goods_ids_str = $v['id'];
                } else {
                    $goods_ids_str .= '|'.$v['id'];
                }

            }
            // 获取订单id
            $order_goods_list = OrderGoodsRepo::getList([],['id'=>$goods_ids_str]);
            $order_ids_str = '';

            foreach ($order_goods_list as $k1=>$v1){
                if ($k1==0){
                    $order_ids_str = $v1['order_id'];
                } else {
                    $order_ids_str .= '|'.$v1['order_id'];
                }
            }
            // 开票的订单
            $order_list = OrderInfoRepo::getList([],['id'=>$order_ids_str]);

            self::beginTransaction();
            // 开票
            $re = self::updateInvoice($invoice_id,$data);
            // 变更订单状态 已完成
            if ($re){
                $changed = [];
                foreach ($order_list as $k2=>$v2){
                   $changed[] =  OrderInfoRepo::modify($v2['id'],['status'=>4]);
                }
                self::commit();
                if (count($changed) == count($order_goods_list)){
                    return 1;
                }
            }
        }catch (\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }


    }
}
