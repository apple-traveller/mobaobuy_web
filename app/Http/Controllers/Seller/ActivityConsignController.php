<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:28
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ActivityWholesaleService;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use App\Services\ShopGoodsQuoteService;
use App\Services\ShopSalesmanService;
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
            $condition['b.shop_id']= $shop_id;
        }
        if ($goods_name){
            $condition['b.goods_name'] = "%".$goods_name."%";
        }
        $condition['b.type'] = '3';
        $condition['b.is_delete'] = 0;
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
        $shop_id = session('_seller_id')['shop_id'];
        $salesman = ShopSalesmanService::getList([],['shop_id'=>$shop_id]);
        return $this->display('seller.activityconsign.add',['salesman'=>$salesman]);
    }

    public function edit(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = $request->input('id');
        $shop_id = session('_seller_id')['shop_id'];
        $salesman = ShopSalesmanService::getList([],['shop_id'=>$shop_id]);
        $consign_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $goods = GoodsService::getGoodsList([],[]);
        $good = GoodsService::getGoodInfo($consign_info['goods_id']);
        return $this->display('seller.activityconsign.edit',[
            'consign_info'=>$consign_info,
            'currentPage'=>$currentPage,
            'goods'=>$goods['list'],
            'salesman'=>$salesman,
            'good'=>$good
        ]);
    }
}
