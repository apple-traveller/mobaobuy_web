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
    public function getList(Request $request)
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
        $condition['type'] = '1|2';
        $pageSize =5;
        $shopGoodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currentPage,'orderType'=>['b.add_time'=>'desc']],$condition);
        return $this->display('seller.goodsquote.list',[
            'total'=>$shopGoodsQuote['total'],
            'shopGoodsQuote'=>$shopGoodsQuote['list'],
            'currentPage'=>$currentPage,
            'goods_name'=>$goods_name,
            'pageSize'=>$pageSize
        ]);
    }

    /**
     * 添加表单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        return $this->display('seller.goodsquote.add');
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
        $goods = GoodsService::getGoodsList([],[]);
        $good = GoodsService::getGoodInfo($goodsQuote['goods_id']);
        return $this->display('seller.goodsquote.edit',[
            'goodsQuote'=>$goodsQuote,
            'currentPage'=>$currentPage,
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
        $request->flash();
        $shop_id = session('_seller_id')['shop_id'];
        $company_name = session('_seller')['shop_info']['company_name'];
        $id = $request->input('id','');
        $store_id = $request->input('store_id',0);
        $store_name = $request->input('store_name','');
        $goods_id = $request->input('goods_id','');
        $delivery_place = $request->input('delivery_place');
        $place_id = $request->input('place_id','');
        $production_date = $request->input('production_date','');
        $goods_number = $request->input('goods_number','');
        $shop_price = $request->input('shop_price','');
        $salesman = $request->input('salesman','');
        $contact_info = $request->input('contact_info','');
        $qq = $request->input('QQ','');
        $type = $request->input('type','');

        $delivery_place = substr($delivery_place,strripos($delivery_place,'/')?strripos($delivery_place,'/')+2:strripos($delivery_place,'/'));
        $place_id = substr($place_id,strripos($place_id,'|')+1);

        if($goods_id==0||!$goods_id){
            return $this->error('商品不能为空');
        }
        if(!$store_name && !$store_id){
            return $this->error('店铺不能为空');
        }
        if($store_id == 0 && $store_name == '自售' && empty($type)){
            $store_name = $company_name;
            $type = 1;
        }else{
            if(empty($type)){
                $type = 2;
            }
        }
        if(!$delivery_place){
            return $this->error('交货地不能为空');
        }
        if(!$production_date){
            return $this->error('生产日期不能为空');
        }
        if(!$goods_number){
            return $this->error('库存不能为空');
        }
        if(!$shop_price){
            return $this->error('店铺售价不能为空');
        }
        if(!$salesman){
            return $this->error('业务员不能为空');
        }
        if(!$contact_info){
            return $this->error('联系方式不能为空');
        }
        if (!$qq){
            return $this->error('qq不能为空');
        }

        $goods = GoodsService::getGoodInfo($goods_id);
        $data['goods_sn'] = $goods['goods_sn'];
        $data['goods_name'] = $goods['goods_name'];
        $currentPage = $request->input('currentPage');
        $data = [
            'shop_store_id' => $store_id,
            'shop_id' => $shop_id,
            'goods_id' => $goods_id,
            'delivery_place' => $delivery_place,
            'place_id' => $place_id,
            'production_date' => $production_date,
            'goods_number' => $goods_number,
            'shop_price' => $shop_price,
            'expiry_time' => '0',
            'goods_sn' => $goods['goods_sn'],
            'goods_name' => $goods['goods_full_name'],
            'salesman' => $salesman,
            'contact_info' => $contact_info,
            'QQ' => $qq,
            'type' => $type,
        ];

        if ($store_id==0){
            $data['is_self_run'] = 1;
            $data['type'] = 1;
            $data['store_name'] = $company_name;
        } else {
            $data['is_self_run'] = 0;
            $data['type'] = 2;
            $data['store_name'] = $store_name;
        }
        try{
            if($id){
                $data['id'] = $id;
                $flag = ShopGoodsQuoteService::modify($data);
                if(!empty($flag)){
                    if($type != 3){
                        return $this->success('修改成功',url('/seller/quote/list')."?currentPage=".$currentPage);
                    }else{
                        return $this->success('修改成功',url('/seller/activity/consign')."?currentPage=".$currentPage);
                    }

                }
            }else{
                $data['add_time'] = Carbon::now();
                $data['shop_user_id'] = session('_seller_id')['user_id'];
                $flag = ShopGoodsQuoteService::create($data);
                if(!empty($flag)){
                    if($type != 3){
                        return $this->success('添加成功',url('/seller/quote/list'));
                    }else{
                        return $this->success('添加成功',url('/seller/activity/consign'));
                    }

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
