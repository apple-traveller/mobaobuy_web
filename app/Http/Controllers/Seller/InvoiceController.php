<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-29
 * Time: 10:47
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\InvoiceGoodsService;
use App\Services\InvoiceService;
use App\Services\OrderInfoService;
use App\Services\UserService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function list(Request $request)
    {
        $shop_id = session()->get('_seller_id')['shop_id'];
        $currentPage = $request->input('currentPage',1);
        $condition = [];
        $condition['shop_id'] = $shop_id;
        $pageSize = 10;
        $list = InvoiceService::getListBySearch([['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['add_time' => 'desc']]],$condition);
        if (!empty($list['list'])){
            foreach ($list['list'] as $k=>$v){
                $list['list'][$k]['user_name'] = UserService::getInfo($v['user_id'])['nick_name'];
            }
        }
        return $this->display('seller.invoice.list',[
            'list' => $list['list'],
            'total' => $list['total'],
            'pageSize' => $pageSize,
            'currentPage' => $currentPage
        ]);
    }

    /**
     * 详情页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $currentPage = $request->input('currentPage','');
        $invoice_id = $request->input('invoice_id','');
        $invoiceInfo = InvoiceService::getInfoById($invoice_id);
        // 开票商品
        $orderInfo = InvoiceGoodsService::getInfoBySearch(['invoice_id'=>$invoice_id]);
        return $this->display('seller/invoice/detail', [
            'invoiceInfo' => $invoiceInfo,
            'orderInfo' =>$orderInfo,
            'currentPage' => $currentPage
        ]);
    }

    /**
     * 选择快递页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function choseExpress(Request $request)
    {
        $invoice_id = $request->input('invoice_id');
        //查询所有的快递信息
        $shipPings = OrderInfoService::getShippingList();
        return $this->display('seller.invoice.choseExpress',[
            'shipPings'=>$shipPings,
            'invoice_id'=>$invoice_id
        ]);
    }

    /**
     * 审核发票 并保存快递信息
     * @param Request $request
     * @return InvoiceController|\Illuminate\Http\RedirectResponse
     */
    public function verifyInvoice(Request $request)
    {
       $shipping_id = $request->input('shopping_id','');
       $shipping_name = $request->input('shipping_name','');
       $shipping_billno = $request->input('shipping_billno','');
       $invoice_id = $request->input('invoice_id','');
       if (empty($invoice_id)){
           return $this->error('参数错误');
       }
        // 生成唯一开票号
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $invoice_numbers = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
       $data = [
           'invoice_numbers' => $invoice_numbers,
           'shipping_id' => $shipping_id,
           'shipping_name' => $shipping_name,
           'shipping_billno' => $shipping_billno,
           'status' => 2
       ];

       $re = InvoiceService::verifyInvoice($invoice_id,$data);

       if ($re){
           return $this->success('操作成功');
       } else {
           return $this->error('操作失败');
       }
    }

    /**
     * 作废开票申请
     * @param Request $request
     * @return InvoiceController|\Illuminate\Http\RedirectResponse
     */
    public function cancelInvoice(Request $request)
    {
        $invoice_id = $request->input('invoice_id','');
        if (empty($invoice_id)){
            return $this->error('参数错误');
        }
        $data = [
            'status' => 0
        ];
        $re = InvoiceService::verifyInvoice($invoice_id,$data);
        if ($re){
            return $this->success('操作成功');
        } else {
            return $this->error('操作失败');
        }
    }
}
