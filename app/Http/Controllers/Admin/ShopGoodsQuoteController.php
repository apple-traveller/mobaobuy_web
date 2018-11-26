<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\ShopGoodsService;
use App\Services\ShopService;
use App\Services\ShopGoodsQuoteService;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
class ShopGoodsQuoteController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_name = $request->input('shop_name',"");
        $condition = [];
        if(!empty($shop_name)){
            $condition['shop_name']="%".$shop_name."%";
        }
        $pageSize =10;
        $shops = ShopService::getShopList([],[]);
        $shopGoodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        //dd($shopGoodsQuote['list']);
        return $this->display('admin.shopgoodsquote.list',[
            'total'=>$shopGoodsQuote['total'],
            'shopGoodsQuote'=>$shopGoodsQuote['list'],
            'currpage'=>$currpage,
            'shop_name'=>$shop_name,
            'pageSize'=>$pageSize,
            'shops'=>$shops['list']
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        $shops = ShopService::getShopList([],[]);
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        $goods = GoodsService::getGoodsList([],[]);
        //dd($goods);
        return $this->display('admin.shopgoodsquote.add',[
            'goodsCatTree'=>$goodsCatTree,
            'shops'=>$shops['list'],
            'goods'=>$goods['list']
        ]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $id = $request->input('id');
        $goodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $shops = ShopService::getShopList([],[]);
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        $goods = GoodsService::getGoodsList([],[]);
        $good = GoodsService::getGoodInfo($goodsQuote['goods_id']);
        return $this->display('admin.shopgoodsquote.edit',[
            'goodsQuote'=>$goodsQuote,
            'currpage'=>$currpage,
            'shops'=>$shops['list'],
            'goodsCatTree'=>$goodsCatTree,
            'goods'=>$goods['list'],
            'good'=>$good
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg = [];
        if($data['goods_id']==0||empty($data['goods_id'])){
            $errorMsg[] = '商品不能为空';
        }
        if($data['delivery_place']==""){
            $errorMsg[] = '发货地不能为空';
        }
        if($data['shop_id']==0||empty($data['shop_id'])){
            $errorMsg[] = '店铺不能为空';
        }
        if(empty($data['delivery_place'])){
            $errorMsg[] = '交货地不能为空';
        }
        if(empty($data['goods_number'])){
            $errorMsg[] = '库存不能为空';
        }
        if(empty($data['shop_price'])){
            $errorMsg[] = '店铺售价不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('|',$errorMsg));
        }

        $delivery_places = explode('/',$data['delivery_place']);//先转化为数组
        $data['delivery_place'] = array_pop($delivery_places);//取最后的一个地区

        $place_ids = explode('|',$data['place_id']);//先转化为数组
        $data['place_id'] = array_pop($place_ids);//取最后的一个地区

        $data['shop_name'] = ShopService::getShopById($data['shop_id'])['shop_name'];
        $goods = GoodsService::getGoodInfo($data['goods_id']);
        $data['goods_sn'] = $goods['goods_sn'];
        $data['goods_name'] = $goods['goods_name'];
        $currpage = $request->input('currpage');
        unset($data['currpage']);

        if(empty($data['store_id']) && $data['store_name'] == '自售'){
            $data['store_name'] = $data['shop_name'];
            $data['type'] = 1;
        }else{
            $data['type'] = 2;
        }
        try{
            if(key_exists('id',$data)){
                $goodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteById($data['id']);
                $flag = ShopGoodsQuoteService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/shopgoodsquote/list')."?currpage=".$currpage);
                }
            }else{
                $data['add_time'] = Carbon::now();
                $data['outer_user_id'] = session('_admin_user_id');
                $data['outer_id'] = 0;
                //dd($data);
                $flag = ShopGoodsQuoteService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/shopgoodsquote/list'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }


    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = ShopGoodsQuoteService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/shopgoodsquote/list'));
            }
            return  $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //ajax获取商品
    public function getGoods(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $goods = GoodsService::getGoods(['cat_id'=>$cat_id],['id','goods_name','packing_spec']);
        if($cat_id==0){
            $goods = GoodsService::getGoods([],['id','goods_name','packing_spec']);
        }
        if(!empty($goods)){
            return $this->result($goods,200,'获取商品成功');
        }else{
            return $this->result('',400,'获取商品失败');
        }
    }

}
