<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:28
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityWholesaleService;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Http\Request;

class ActivityConsignController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $shop_id = session('_seller_id')['shop_id'];
        $goods_name = $request->input('goods_name','');
        $condition = [];
        if(!empty($shop_id)){
            $condition['shop_id']= $shop_id;
        }
        if ($goods_name){
            $condition['b.goods_name'] = "%".$goods_name."%";
        }
        $condition['type'] = '3';
        $pageSize =5;
        $consign_info = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currentPage,'orderType'=>['b.add_time'=>'desc']],$condition);
        return $this->display('seller.activityconsign.consign',[
            'total'=>$consign_info['total'],
            'consign_list'=>$consign_info['list'],
            'currentPage'=>$currentPage,
            'goods_name'=>$goods_name,
            'pageSize'=>$pageSize
        ]);
    }

    public function add(Request $request)
    {
        return $this->display('seller.activityconsign.add');
//        $currentPage = $request->input('currentPage',1);
//
//        $id = $request->input('id','');
//
//        if($id){
//            $consign_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
//            $consign_info['begin_time'] = explode(' ',$consign_info['begin_time']);
//            $consign_info['end_time'] = explode(' ',$consign_info['end_time']);
//            $good = GoodsService::getGoodInfo($consign_info['goods_id']);
//        } else {
//            $consign_info = [];
//            $good = [];
//        }
//        return $this->display('seller.activityconsign.edit',[
//            'currentPage' => $currentPage,
//            'consign_info' => $consign_info,
//            'good' => $good
//        ]);
    }

    public function edit(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = $request->input('id');
        $consign_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $goods = GoodsService::getGoodsList([],[]);
        $good = GoodsService::getGoodInfo($consign_info['goods_id']);
        return $this->display('seller.activityconsign.edit',[
            'consign_info'=>$consign_info,
            'currentPage'=>$currentPage,
            'goods'=>$goods['list'],
            'good'=>$good
        ]);
    }
}
