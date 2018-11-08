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
        $member_phone = $request->input('member_phone','');
        $status = $request->input('status','');
        $condition = [];
        $condition['shop_id'] = $shop_id;
        if (!empty($member_phone)){
            $condition['member_phone'] = $member_phone;
        }
        if (!empty($status)){
            $condition['status'] = $status;
        }
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
            'currentPage' => $currentPage,
            'status' => $status,
            'member_phone' => $member_phone
        ]);
    }

    /**
     * 开票详情页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function detail(Request $request)
    {
        $currentPage = $request->input('currentPage','');
        $invoice_id = $request->input('invoice_id','');
        $invoiceDetail = InvoiceService::getInvoiceDetail($invoice_id);

        return $this->display('seller.invoice.detail', [
            'invoiceInfo' => $invoiceDetail['invoiceInfo'],
            'orderInfo' => $invoiceDetail['invoiceGoods'],
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
     * @throws \Exception
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
        if (empty($shipping_name)){
            return $this->error('缺少物流信息');
        }
        if (empty($shipping_billno)){
            return $this->error('缺少物流单号');
        }
       $data = [
           'shipping_id' => $shipping_id,
           'shipping_name' => $shipping_name,
           'shipping_billno' => $shipping_billno,
       ];
        $re = InvoiceService::verifyInvoice($invoice_id,$data);
       if ($re == 1){
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
        $re = InvoiceService::updateInvoice($invoice_id,$data);
        if ($re){
            return $this->success('操作成功');
        } else {
            return $this->error('操作失败');
        }
    }
}
