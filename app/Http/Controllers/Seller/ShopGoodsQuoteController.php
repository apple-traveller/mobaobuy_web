<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-08
 * Time: 9:21
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use App\Services\ShopGoodsQuoteService;
use App\Services\ShopService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopGoodsQuoteController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $shop_id = session('_seller_id')['shop_id'];
        $goos_name = $request->input('goods_name','');
        $condition = [];
        if(!empty($shop_id)){
            $condition['shop_id']= $shop_id;
        }
        if ($goos_name){
            $condition['goods_name'] = "%".$goos_name."%";
        }
        $pageSize =5;
        $goods_list = ShopGoodsQuoteService::getQuoteGoods($shop_id);
        $shopGoodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currentPage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('seller.goodsquote.list',[
            'total'=>$shopGoodsQuote['total'],
            'shopGoodsQuote'=>$shopGoodsQuote['list'],
            'currentPage'=>$currentPage,
            'goods_name'=>$goos_name,
            'pageSize'=>$pageSize,
            'goods'=>$goods_list
        ]);
    }

    /**
     * 添加表单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        $goods = GoodsService::getGoodsList([],[]);
        return $this->display('seller.goodsquote.add',[
            'goodsCatTree'=>$goodsCatTree,
            'goods'=>$goods['list']
        ]);
    }

    /**
     * 编辑表单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = $request->input('id');
        $goodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        $goods = GoodsService::getGoodsList([],[]);
        $good = GoodsService::getGoodInfo($goodsQuote['goods_id']);
        return $this->display('seller.goodsquote.edit',[
            'goodsQuote'=>$goodsQuote,
            'currentPage'=>$currentPage,
            'goodsCatTree'=>$goodsCatTree,
            'goods'=>$goods['list'],
            'good'=>$good
        ]);
    }

    /**
     * 添加和编辑
     * @param Request $request
     * @return ShopGoodsQuoteController|\Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $shop_id = session('_seller_id')['shop_id'];
        $id = $request->input('id','');
        $goods_id = $request->input('goods_id','');
        $delivery_place = $request->input('delivery_place');
        $expiry_time = $request->input('expiry_time','');
        $goods_number = $request->input('goods_number','');
        $shop_price = $request->input('shop_price','');

        if($goods_id==0||!$goods_id){
            return $this->error('产品不能为空');
        }
        if(!$delivery_place){
            return $this->error('交货地不能为空');
        }
        if(!$expiry_time){
            return $this->error('截止时间不能为空');
        }
        if(!$goods_number){
            return $this->error('库存不能为空');
        }
        if(!$shop_price){
            return $this->error('店铺售价不能为空');
        }

        $shop_name = ShopService::getShopById($shop_id)['shop_name'];

        $goods = GoodsService::getGoodInfo($goods_id);
        $data['goods_sn'] = $goods['goods_sn'];
        $data['goods_name'] = $goods['goods_name'];
        $currentPage = $request->input('currentPage');
        $data = [
            'shop_name' => $shop_name,
            'shop_id' => $shop_id,
            'goods_id' => $goods_id,
            'delivery_place' => $delivery_place,
            'expiry_time' => $expiry_time,
            'goods_number' => $goods_number,
            'shop_price' => $shop_price,
            'goods_sn' => $goods['goods_sn'],
            'goods_name' => $goods['goods_name'],

        ];
        try{
            if($id){
                $goodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
                if(strtotime($data['expiry_time'])<strtotime($goodsQuote['add_time'])){
                    return $this->error('截止时间不能在添加时间之前');
                }
                $data['id'] = $id;
                $flag = ShopGoodsQuoteService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/seller/quote/list')."?currentPage=".$currentPage);
                }
            }else{
                $data['add_time'] = Carbon::now();
                $data['shop_user_id'] = session('_seller_id')['user_id'];
                if(strtotime($data['expiry_time'])<strtotime($data['add_time'])){
                    return $this->error('截止时间不能在添加时间之前');
                }
                $flag = ShopGoodsQuoteService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/seller/quote/list'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * delete
     * @param Request $request
     * @return ShopGoodsQuoteController|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = ShopGoodsQuoteService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/seller/quote/list'));
            }
            return  $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}