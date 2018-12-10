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
use App\Repositories\UserRepo;
use Illuminate\Support\Carbon;
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
        $user_info = UserRepo::getInfo($info['user_id']);
        $info['address_str'] = RegionService::getRegion($info['country'],$info['province'],$info['city'],$info['district']);
        $info['is_firm'] = $user_info['is_firm'];
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
        if($data['status']==2){
            $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
            $invoice_numbers = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
            $data['invoice_numbers'] = $invoice_numbers;
        }
        $data['updated_at'] = Carbon::now();
        return InvoiceRepo::modify($id,$data);
    }


    /**
     * 审核发票
     * @param $invoice_id
     * @param $data
     * @return int
     * @throws \Exception
     */
    public static function verifyInvoice($invoice_id,$data)
    {
        $data['updated_at'] = Carbon::now();
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
                   $changed[] =  OrderInfoRepo::modify($v2['id'],['order_status'=>4]);
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

    /**
     *  保存开票商品  更改订单状态已完成
     * @param $invoice_data
     * @param $goodsList
     * @return bool
     * @throws \Exception
     */
    public static function applyInvoice($invoice_data,$goodsList)
    {
        try{
            $invoice_data['created_at'] = Carbon::now();
            $invoice_data['updated_at'] = Carbon::now();
            self::beginTransaction();
            $invoice = InvoiceRepo::create($invoice_data);

            if ($invoice){
                $res = [];
                $order_ids = []; // 用来存取订单id
                foreach ($goodsList as $k=>$v){
                                // 遍历获取订单id
                    if(!isset($order_ids[$v['order_id']])){
                        $order_ids[$v['order_id']] = $v['order_id'];
                    }
                    $goods_data = [
                        'invoice_id' => $invoice['id'],
                        'order_goods_id' => $v['id'],
                        'goods_id' => $v['goods_id'],
                        'goods_name' => $v['goods_name'],
                        'goods_price' => $v['goods_price'],
                        'invoice_num' => $v['goods_number'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $res[] = InvoiceGoodsRepo::create($goods_data);
                }
                // 判断存入的数量和商品数量是否相同
                if (count($res) == count($goodsList)){
                    foreach ($order_ids as $k2=>$v2){
                        // 更改订单状态已完成
                        OrderInfoService::modify(['id'=>$v2,'order_status'=>6]);
                    }
                    self::commit();
                    return $invoice;
                }
            }
        }catch (\Exception $e){
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    /**
     * 开票详情
     * @param $invoice_id
     * @return array
     * @throws \Exception
     */
    public static function getInvoiceDetail($invoice_id)
    {
        try{
            $invoiceInfo = self::getInfoById($invoice_id);
            $invoiceInfo['address_str'] = RegionService::getRegion($invoiceInfo['country'],$invoiceInfo['province'],$invoiceInfo['city'],$invoiceInfo['address']);
            // 开票商品
            $orderInfo = InvoiceGoodsService::getListBySearch(['invoice_id'=>$invoice_id]);
            return ['invoiceInfo'=>$invoiceInfo,'invoiceGoods'=>$orderInfo];
        }catch (\Exception $e){
            self::throwBizError($e->getMessage());
        }
    }

    /**
     * 发票各状态数量
     * @param $info
     * @return mixed
     */
    public static function getStatusCount($info)
    {
     // 待开票数量
        $status['waitInvoice'] = InvoiceRepo::getTotalCount(['user_id'=>$info['firm_id'],'status'=>1]);
     // 已开票数量
        $status['Completed'] = InvoiceRepo::getTotalCount(['user_id'=>$info['firm_id'],'status'=>2]);

        return $status;
    }

    /**
     * 发票列
     * @param $condition
     * @return mixed
     */
    public static function getList($condition)
    {
        return InvoiceRepo::getList([],$condition);
    }
}
