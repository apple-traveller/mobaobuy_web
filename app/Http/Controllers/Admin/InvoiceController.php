<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\InvoiceService;
use App\Services\InvoiceGoodsService;
use App\Services\OrderInfoService;
class InvoiceController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $add_time = $request->input("add_time","");
        $currpage = $request->input('currpage',1);
        $status = $request->input('status',-1);
        $pageSize = 10;
        $condition = [];
        if($status!=-1){
            $condition['status'] = $status;
        }
        if(!empty($add_time)){
            $begin_time = trim(substr($add_time , 0 , 10));
            $end_time = trim(substr($add_time , -10));
            $condition['created_at|<'] = $end_time;
            $condition['created_at|>'] = $begin_time;
        }
        $invoices = InvoiceService::getListBySearch(['page_size'=>$pageSize,'page'=>$currpage,'orderType'=>['created_at'=>'desc']],$condition);
        return $this->display('admin.invoice.list',[
            'invoices'=>$invoices['list'],
            'total'=>$invoices['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'status'=>$status,
            'add_time'=>$add_time
        ]);
    }

    //发票商品
    public function goodsList(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $invoice_id = $request->input('invoice_id');
        $status = $request->input('status',-1);
        $invoice_goods = InvoiceGoodsService::getListBySearch(['invoice_id'=>$invoice_id]);
        //dd($invoice_goods);
        return $this->display('admin.invoice.goodslist',[
            'invoice_goods' => $invoice_goods,
            'currpage'=>$currpage,
            'status'=>$status
        ]);
    }


    //查看详细信息
    public function detail(Request $request)
    {
        $id = $request->input("id");
        $currpage = $request->input("currpage",1);
        $status = $request->input("status",-1);
        $invoiceInfo = InvoiceService::getInfoById($id);
        // 开票商品
        $orderInfo = InvoiceGoodsService::getListBySearch(['invoice_id'=>$id]);
        $sum = 0;
        foreach($orderInfo as $k=>$v){
            $sum +=$v['goods_price']*$v['invoice_num'];
        }
        //查询所有的快递信息
        $shippings = OrderInfoService::getShippingList();
        return $this->display('admin.invoice.detail',[
            'invoiceInfo'=>$invoiceInfo,
            'orderInfo'=>$orderInfo,
            'shippings'=>$shippings,
            'currpage'=>$currpage,
            'status'=>$status,
            'sum'=>$sum
        ]);
    }



    //保存优惠活动
    public function save(Request $request)
    {
        $data = $request->all();
        try{
            $flag = InvoiceService::updateInvoiceAdmin($data['id'],$data);
            return $this->success("保存成功");
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }




}
