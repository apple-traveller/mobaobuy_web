<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-30
 * Time: 14:36
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use App\Services\OrderInfoService;
use App\Services\UserAddressService;
use App\Services\UserRealService;
use App\Services\UserService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    /**
     * 我的开票
     * @param Request $request
     * @return InvoiceController|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function myInvoice(Request $request)
    {
        if (isset(session('_curr_deputy_user')['can_invoice']) && session('_curr_deputy_user')['can_invoice']==0){
            return $this->error(trans('error.no_have_right_apply_invoice'));
        }
        $tab_code = $request->input('tab_code', '');
        if ($request->isMethod('get')){
            return $this->display('web.user.invoice.myInvoice',compact('tab_code'));
        } else {
            $page = $request->input('start', 0) / $request->input('length', 10) + 1;
            $begin_time = $request->input('begin_time','');
            $end_time = $request->input('end_time','');
            $page_size = $request->input('length', 10);
            $firm_id = session('_curr_deputy_user')['firm_id'];
            $invoice_numbers = $request->input('invoice_numbers','');
            $condition['user_id'] = $firm_id;

            if ($tab_code == 'waitInvoice'){
                $condition['status'] = 1;
            } elseif($tab_code == 'Completed'){
                $condition['status'] = 2;
            }

            if (!empty($begin_time)){
                $condition['created_at|>'] = $begin_time . ' 00:00:00';
            }
            if (!empty($end_time)){
                $condition['created_at|<'] = $end_time . ' 23:59:59';
            }

            if(!empty($invoice_numbers)){
                $condition['invoice_numbers'] = '%'.$invoice_numbers.'%';
            }

            $pager = [
                'page'=>$page,
                'pageSize'=>$page_size

            ];

            $rs_list = InvoiceService::getListBySearch($pager,$condition);

            $data = [
                'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
                'recordsTotal' => $rs_list['total'], //数据总行数
                'recordsFiltered' => $rs_list['total'], //数据总行数
                'data' => $rs_list['list']
            ];
            return $this->success('', '', $data);
        }
    }

    /** 获取各状态数量
     * @return InvoiceController|\Illuminate\Http\RedirectResponse
     */
    public function getStatusCount()
    {
        $deputy_user = session('_curr_deputy_user');

        // 待开票数量
        $status = InvoiceService::getStatusCount($deputy_user);
        if (!empty($status)){
            return $this->success('success','',$status);
        } else {
            return $this->error('error','',$status);
        }
    }

    /**
     * 开票信息详情
     * @param Request $request
     * @return InvoiceController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function invoiceDetail($invoice_id)
    {

        if (isset(session('_curr_deputy_user')['can_invoice']) && session('_curr_deputy_user')['can_invoice']==0){
            return $this->error(trans('error.no_have_right_apply_invoice'));
        }
        if (empty($invoice_id)){
            return $this->error(trans('error.invoice_info_not_exist'));
        }
        $invoiceDetail = InvoiceService::getInvoiceDetail($invoice_id);
        if (!empty($invoiceDetail)){
            if ($invoiceDetail['invoiceInfo']['id'] != $invoice_id){
                return $this->error(trans('error.network_error'));
            }
        }

        return $this->display('web.user.invoice.detail', [
            'invoiceInfo' => $invoiceDetail['invoiceInfo'],
            'invoiceGoods' => $invoiceDetail['invoiceGoods']
        ]);
    }

    /**
     * 开票列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoiceList(Request $request)
    {
        if (isset(session('_curr_deputy_user')['can_invoice']) && session('_curr_deputy_user')['can_invoice']==0){
            return $this->error(trans('error.no_have_right_apply_invoice'));
        }
        $shop_name = $request->input('shop_name','');
        $order_sn = $request->input('order_sn','');
        $start_time = $request->input('begin_time','');
        $end_time = $request->input('end_time','');
        $firm_id = session('_curr_deputy_user')['firm_id'];

        $userInfo = UserService::getInfo($firm_id);
        $condition = [
            'order_status' =>  5,
            'is_delete' =>  0
        ];

        if(session('_curr_deputy_user')['is_firm']){
//              $condition['user_id'] = $firm_id;
                $condition['firm_id'] = $firm_id;
        }else{
            $condition['user_id'] = $firm_id;
            $condition['firm_id'] = 0;
        }

        if (!empty($shop_name)){
            $condition['shop_name'] = "%".$shop_name."%";
        }
        if (!empty($order_sn)){
            $condition['order_sn'] = $order_sn;
        }
        if (!empty($start_time)){
            $condition['confirm_take_time|>'] = $start_time.' 00:00:00';
        }
        if (!empty($end_time)){
            $condition['confirm_take_time|<'] = $end_time.' 23:59:59';
        }

        $orderList = OrderInfoService::getOrderInfoList(['orderType' =>  ['confirm_take_time' =>  'desc']],$condition);

        $orderList = $orderList['list'];

        //预先存入开票信息到session
        $invoice_type = 1;
        $invoiceSession = [
            'address_id'=>$userInfo['address_id'],
            'invoice_type'=>$invoice_type,
        ];
        session()->put('invoiceSession',$invoiceSession);

        return $this->display('web.user.invoice.list',compact('orderList','invoice_type'));
    }


    /**
     * 申请发票确认页面
     * @param Request $request
     * @return InvoiceController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(Request $request)
    {
        if (isset(session('_curr_deputy_user')['can_invoice']) && session('_curr_deputy_user')['can_invoice']==0){
            return $this->error(trans('error.no_have_right_apply_invoice'));
        }
        $invoiceSession = session('invoiceSession');

        if (empty($invoiceSession)){
            return $this->redirect('/invoice');
        }

        $user_info = UserService::getInfo(session('_curr_deputy_user')['firm_id']);
        $order_ids = $request->input('order_id','');
        $total_amount = $request->input('total_amount','');

        if (empty($order_ids)){
            return $this->error(trans('error.select_order_tips'));
        }

        $order_ids = explode(',',$order_ids);
        $invoiceInfo = UserRealService::getInfoByUserId($user_info['id']);
        if (empty($invoiceInfo)){
            return $this->error(trans('error.no_real_name_tips'));
        }
        if ($invoiceInfo['review_status'] != 1 ){
            return $this->error(trans('error.real_name_no_pass_tips'));
        }
        // 判断默认地址 和当前选择地址
        $invoice_type = $invoiceSession['invoice_type'];
        $addressList = UserAddressService::getInfoByUserId($user_info['id']);
        foreach ($addressList as $k =>  $v){
            $addressList[$k] = UserAddressService::getAddressInfo($v['id']);
            if ($v['id'] == $invoiceSession['address_id']){
                $addressList[$k]['is_select'] = 1;
            } else {
                $addressList[$k]['is_select'] ='';
            };
            if ($v['id'] == $user_info['address_id']){
                $addressList[$k]['is_default'] =1;
                $first_one[$k] = $addressList[$k];
            } else {
                $addressList[$k]['is_default'] ='';
            };
        }
        if(!empty($first_one)) {
            foreach ($first_one as $k1  =>   $v1) {
                unset($addressList[$k1]);
                array_unshift($addressList, $first_one[$k1]);
            }
        }
        $order_id = '';
        foreach ($order_ids as $k =>  $v){
            if ($k==0){
                $order_id = $v;
            } else {
                $order_id .= '|'.$v;
            }
        }
        $goodsList = OrderInfoService::getOrderGoodsList($order_id);

        //重新封装session 加入商品信息
        $invoiceSession['goods_list'] = $goodsList['list'];
        $invoiceSession['total_amount'] = $total_amount;
        session()->put('invoiceSession',$invoiceSession);

        return $this->display('web.user.invoice.confirm',compact('invoiceInfo','addressList','goodsList','total_amount','invoice_type'));
    }

    /**
     * 选择收票地址
     * editOrderAddress
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editInvoiceAddress(Request $request)
    {
        if (isset(session('_curr_deputy_user')['can_invoice']) && session('_curr_deputy_user')['can_invoice']==0){
            return $this->error(trans('error.no_have_right_apply_invoice'));
        }
        $address_id = $request->input('address_id','');
        if(!$address_id){
            return $this->error(trans('error.lack_address_id'));
        }
        $address_info = UserAddressService::getAddressInfo($address_id);
        if(!$address_info){
            return $this->error(trans('error.address_info_not_exist'));
        }
        $invoiceSession = session('invoiceSession');
        $invoiceSession['address_id'] = $address_id;

        session()->put('invoiceSession',$invoiceSession);
        return $this->success(trans('error.select_success'));
    }
    /**
     * 选择开票类型地址
     * editOrderAddress
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editInvoiceType(Request $request)
    {
        $invoice_type = $request->input('invoice_type','');
        if(!$invoice_type){
            return $this->error(trans('error.lack_invoice_type_parameter'));
        }
        $invoiceSession = session('invoiceSession');
        $invoiceSession['invoice_type'] = $invoice_type;

        session()->put('invoiceSession',$invoiceSession);
        return $this->success(trans('error.select_success'));
    }

    /**
     * 申请开票
     * @return InvoiceController|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function applyInvoice()
    {
        if (isset(session('_curr_deputy_user')['can_invoice']) && session('_curr_deputy_user')['can_invoice']==0){
            return $this->error(trans('error.no_have_right_apply_invoice'));
        }
        $user_info = UserService::getInfo(session('_curr_deputy_user')['firm_id']);
        $invoiceSession = session('invoiceSession');
        $goodsList = $invoiceSession['goods_list'];
        $user_real = UserRealService::getInfoByUserId($user_info['id']);
        if ($invoiceSession['invoice_type']==2 && $user_real['is_special']==0){
            return $this->error(trans('error.not_meet_special_invoice_tips'));
        }
        // 通过订单商品获取订单详情->店铺信息
        $orderInfo = OrderInfoService::getOrderInfoById($goodsList[0]['order_id']);
        $address_info = UserAddressService::getAddressInfo($invoiceSession['address_id']);
        $invoice_data = [
            'shop_id'  =>  $orderInfo['shop_id'],
            'shop_name' =>  $orderInfo['shop_name'],
            'user_id' =>  $user_info['id'],
            'member_phone' =>  $user_info['user_name'],
            'invoice_amount' =>  $invoiceSession['total_amount'],
            'order_quantity' =>  count($goodsList),
            'status' =>  1,
            'consignee' =>  $user_real['real_name'],
            'country' =>  $address_info['country'],
            'province' =>  $address_info['province'],
            'city' =>   $address_info['city'],
            'district' => $address_info['district'],
            'street' => $address_info['street'],
            'address' => $address_info['address'],
            'zipcode' => $address_info['zipcode'],
            'mobile_phone' => $user_info['user_name'],
            'invoice_type' => $invoiceSession['invoice_type'],
            'company_name' => $user_real['company_name'],
            'tax_id' => $user_real['tax_id'],
            'bank_of_deposit' => $user_real['bank_of_deposit'],
            'bank_account' => $user_real['bank_account'],
            'company_address' => $user_real['company_address'],
            'company_telephone' => $user_real['company_telephone']
        ];
        if(!$user_real['is_firm']){
            unset($invoice_data['tax_id']);
            unset($invoice_data['bank_of_deposit']);
            unset($invoice_data['bank_account']);
            unset($invoice_data['company_address']);
            unset($invoice_data['company_telephone']);
        }
        // 生成唯一开票号
        $invoice_data['invoice_numbers'] = getInvoiceSn();
        $re = InvoiceService::applyInvoice($invoice_data,$goodsList);
        if ($re){
            return $this->success(trans('error.apply_success'),'',$re['invoice_numbers']);
        } else{
            return $this->error(trans('error.apply_error'));
        }
    }

    /**
     * 提交后的等待页面
     * @param Request $request
     * @return InvoiceController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function waitFor(Request $request)
    {
        $re = $request->input('re','');
        if (empty($re)){
            return $this->error(trans('error.miss_parameter'));
        }
        return $this->display('web.user.invoice.alreadyInvoice',compact('re'));
    }
}
