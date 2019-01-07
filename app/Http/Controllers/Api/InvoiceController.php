<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-30
 * Time: 14:36
 */
namespace App\Http\Controllers\Api;

use App\Services\InvoiceService;
use App\Services\OrderInfoService;
use App\Services\UserAddressService;
use App\Services\UserRealService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class InvoiceController extends ApiController
{

    /**
     * 我的开票
     * @param Request $request
     * @return InvoiceController|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function myInvoice(Request $request)
    {
        $dupty_user = $this->getDeputyUserInfo($request);
        if (isset($dupty_user['can_invoice']) && $dupty_user['can_invoice']==0){
            return $this->error('您没有申请开票的权限');
        }
        $tab_code = $request->input('tab_code', '');
        $page = $request->input('currpage', 0);
        $page_size = $request->input('pagesize', 10);
        $begin_time = $request->input('begin_time','');
        $end_time = $request->input('end_time','');
        $invoice_numbers = $request->input('invoice_numbers','');
        $firm_id = $dupty_user['firm_id'];
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

        return $this->success($data,'success');
    }

    /** 获取各状态数量
     * @return InvoiceController|\Illuminate\Http\RedirectResponse
     */
    public function getStatusCount(Request $request)
    {
        $deputy_user = $this->getDeputyUserInfo($request);
        // 待开票数量
        $status = InvoiceService::getStatusCount($deputy_user);
        if (!empty($status)){
            return $this->success($status,'success');
        } else {
            return $this->error('error');
        }
    }

    /**
     * 开票信息详情
     * @param Request $request
     * @return InvoiceController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function invoiceDetail(Request $request)
    {
        $deputy_user = $this->getDeputyUserInfo($request);
        $invoice_id = $request->input('invoice_id');
        if(empty($invoice_id)){
            return $this->error('开票id不能为空');
        }

        if (isset($deputy_user['can_invoice']) && $deputy_user['can_invoice']==0){
            return $this->error('您没有申请开票的权限');
        }
        if (empty($invoice_id)){
            return $this->error('该开票信息不存在');
        }
        $invoiceDetail = InvoiceService::getInvoiceDetail($invoice_id);
        if (!empty($invoiceDetail)){
            if ($invoiceDetail['invoiceInfo']['id'] != $invoice_id){
                return $this->error('网络错误');
            }
        }
        return $this->success([
            'invoiceInfo' => $invoiceDetail['invoiceInfo'],
            'invoiceGoods' => $invoiceDetail['invoiceGoods']
        ],'success');
    }

    /**
     * 待开票列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoiceList(Request $request)
    {
        $deputy_user = $this->getDeputyUserInfo($request);
        if (isset($deputy_user['can_invoice']) && $deputy_user['can_invoice']==0){
            return $this->error('您没有申请开票的权限');
        }
        $shop_name = $request->input('shop_name','');
        $order_sn = $request->input('order_sn','');
        $start_time = $request->input('begin_time','');
        $end_time = $request->input('end_time','');
        $firm_id = $deputy_user['firm_id'];
        $userInfo = UserService::getInfo($firm_id);
        $condition = [
            'order_status' =>  5,
            'is_delete' =>  0
        ];

        if($deputy_user['is_firm']){
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

        Cache::put('invoiceSession'.$this->getUserID($request),$invoiceSession,60*24*1);

        return $this->success(compact('orderList','invoice_type'),'success');
    }


    /**
     * 申请发票确认页面
     * @param Request $request
     * @return InvoiceController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(Request $request)
    {
        $dupty_user = $this->getDeputyUserInfo($request);
        //dd($dupty_user);
        if (isset($dupty_user['can_invoice']) && $dupty_user['can_invoice']==0){
            return $this->error('您没有申请开票的权限');
        }
        $user_info = UserService::getInfo($dupty_user['firm_id']);
        $order_ids = $request->input('order_id','');
        $total_amount = $request->input('total_amount','');
        if (empty($order_ids)){
            return $this->error('请选择订单');
        }
        $order_ids = explode(',',$order_ids);
        //判断order_id是不是属于该user_id的
        $invoiceInfo = UserRealService::getInfoByUserId($user_info['id']);
        if (empty($invoiceInfo)){
            return $this->error('您还没有实名认证，不能申请发票');
        }
        if ($invoiceInfo['review_status'] != 1 ){
            return $this->error('您的实名认证还未通过，不能申请发票');
        }
        // 判断默认地址 和当前选择地址
        $invoiceSession = Cache::get('invoiceSession'.$user_info['id']);
        //dd($invoiceSession);
        $invoice_type = $invoiceSession['invoice_type'];
        $addressList = UserAddressService::getInfoByUserId($user_info['id']);
        //dd($addressList);
        foreach ($addressList as $k =>  $v){
            $addressList[$k] = UserAddressService::getAddressInfoApi($v['id']);
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
        Cache::put('invoiceSession'.$user_info['id'], $invoiceSession, 60*24*1);
        return $this->success(compact('invoiceInfo','addressList','goodsList','total_amount','invoice_type'),'success');
    }

    /**
     * 选择收票地址
     * editOrderAddress
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editInvoiceAddress(Request $request)
    {
        $dupty_user = $this->getDeputyUserInfo($request);
        if (isset($dupty_user['can_invoice']) && $dupty_user['can_invoice']==0){
            return $this->error('您没有申请开票的权限');
        }
        $address_id = $request->input('address_id','');
        if(!$address_id){
            return $this->error('缺少地址ID！');
        }
        $address_info = UserAddressService::getAddressInfoApi($address_id);
        if(!$address_info){
            return $this->error('地址信息不存在！');
        }
        $invoiceSession = Cache::get('invoiceSession'.$this->getUserID($request));
        $invoiceSession['address_id'] = $address_id;
        Cache::put('invoiceSession'.$this->getUserID($request), $invoiceSession, 60*24*1);
        return $this->success(Cache::get('invoiceSession'.$this->getUserID($request)),'success');
    }
    /**
     * 选择开票类型
     * editOrderAddress
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editInvoiceType(Request $request)
    {
        $invoice_type = $request->input('invoice_type','');
        if(!$invoice_type){
            return $this->error('缺少开票类型参数！');
        }
        $invoiceSession = Cache::get('invoiceSession'.$this->getUserID($request));
        $invoiceSession['invoice_type'] = $invoice_type;
        Cache::put('invoiceSession'.$this->getUserID($request), $invoiceSession, 60*24*1);
        return $this->success(Cache::get('invoiceSession'.$this->getUserID($request)),'success');
    }

    /**
     * 申请开票
     * @param Request $request
     * @return InvoiceController|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function applyInvoice(Request $request)
    {
        $dupty_user = $this->getDeputyUserInfo($request);
        if (isset($dupty_user['can_invoice']) && $dupty_user['can_invoice']==0){
            return $this->error('您没有申请开票的权限');
        }
        $user_info = UserService::getInfo($dupty_user['firm_id']);
        $invoiceSession = Cache::get('invoiceSession'.$this->getUserID($request));
        if(empty($invoiceSession['goods_list'])){
            return $this->error('请先选择订单');
        }
        $goodsList = $invoiceSession['goods_list'];
        $user_real = UserRealService::getInfoByUserId($user_info['id']);
        if ($invoiceSession['invoice_type']==2 && $user_real['is_special']==0){
            return $this->error('您不符合开增值专用发票的条件');
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
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $invoice_numbers = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        $invoice_data['invoice_numbers'] = $invoice_numbers;
        $re = InvoiceService::applyInvoice($invoice_data,$goodsList);
        if ($re){
            return $this->success($re['invoice_numbers'],'提交成功');
        } else{
            return $this->error('申请失败');
        }
    }

}
