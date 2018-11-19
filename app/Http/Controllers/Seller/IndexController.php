<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-27
 * Time: 11:13
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\OrderInfoService;
use App\Services\ShopService;
use App\Services\ShopUserService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends Controller
{
    public function index()
    {
        $info = session()->get('_seller');
        $data = [
            'user_name'=>$info['user_name'],
            'shop_name'=> $info['shop_info']['shop_name'],
            'is_super'=>'',
            'last_log'=>$info['shop_info']['last_time']
        ];
        return $this->display('seller.index',compact('data'));
    }

    public function home()
    {
        $info = session()->get('_seller');
        $data = [
            'user_name'=>$info['user_name'],
            'shop_name'=> $info['shop_info']['shop_name'],
            'is_super'=>'',
            'last_log'=>$info['shop_info']['last_time']
        ];
        return $this->display('seller.home',compact('data'));
    }

    /**
     * 店铺详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = session()->get('_seller_id')['shop_id'];
        $shop = ShopService::getShopById($id);
        return $this->display('seller.shop.detail',[
            'currentPage'=>$currentPage,
            'shop'=>$shop
        ]);
    }

    /**
     * 更改店铺收款信息
     * @param Request $request
     * @return IndexController|\Illuminate\Http\RedirectResponse
     */
    public function updateCash(Request $request)
    {
        $shop_id = session('_seller_id')['shop_id'];
        $cash_name = $request->input('settlement_bank_account_name','');
        $cash_num = $request->input('settlement_bank_account_number','');

        $data = ['id'=>$shop_id];
        if (!empty($cash_name)){
            $data['settlement_bank_account_name']=$cash_name;
        }
        if (!empty($cash_num)){
            $data['settlement_bank_account_number']=$cash_num;
        }
        if (!empty($data)){
            $re = ShopService::modify($data);
        } else {
            $re = false;
        }
        if ($re){
            return $this->success('修改成功');
        } else {
            return $this->error('修改失败');
        }
    }

    /**
     * 数据图
     * @return IndexController|\Illuminate\Http\RedirectResponse
     */
    public function chars()
    {
        $shop_id = session('_seller_id')['shop_id'];

        $re =  OrderInfoService::getCharsData($shop_id);

        $select_month = [1,2,3,4,5,6,7,8,9,10,11,12];

        $data= [];
        // waitPay
        $dd = [];
        $waitPay_month = array_column($re['waitPay'],'m');
        foreach($re['waitPay'] as $key=>$val){
            $dd[$val['m']] = $val['order_count'];
        }
        foreach($select_month as $key=>$val){
            if(!in_array($val,$waitPay_month)){
                $data['waitPay'][] = 0;
            }else{
                $data['waitPay'][] = $dd[$val];
            }
        }
        // waitSend
        $dd = [];
        $waitPay_month = array_column($re['waitSend'],'m');
        foreach($re['waitSend'] as $key=>$val){
            $dd[$val['m']] = $val['order_count'];
        }
        foreach($select_month as $key=>$val){
            if(!in_array($val,$waitPay_month)){
                $data['waitSend'][] = 0;
            }else{
                $data['waitSend'][] = $dd[$val];
            }
        }

        // waitSend
        $dd = [];
        $finished_month = array_column($re['finished'],'m');
        foreach($re['finished'] as $key=>$val){
            $dd[$val['m']] = $val['order_count'];
        }
        foreach($select_month as $key=>$val){
            if(!in_array($val,$finished_month)){
                $data['finished'][] = 0;
            }else{
                $data['finished'][] = $dd[$val];
            }
        }
        if (!empty($re)){
            return $this->success('获取成功','',$data);
        } else {
            return $this->error('获取失败');
        }
    }
}
