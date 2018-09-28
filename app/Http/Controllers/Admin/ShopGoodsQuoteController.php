<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ShopGoodsService;
use App\Services\ShopService;
use App\Services\ShopGoodsQuoteService;
class ShopGoodsQuoteController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_name = $request->input('shop_name',"");
        $condition = [];
        if(!empty($shop_name)){
            $condition['shop_name']="%".$shop_name."%";
        }
        $pageSize =5;
        $shops = ShopService::getShopList([],[]);
        $shopGoodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
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
        //dd($goods);
        return $this->display('admin.shopgoods.add',[
            'goodsCatTree'=>$goodsCatTree,
            'shops'=>$shops['list'],
        ]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $id = $request->input('id');
        $shopGood = ShopGoodsService::getShopGoodsById($id);
        $shops = ShopService::getShopList([],[]);
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        return $this->display('admin.shopgoods.edit',[
            'shopGood'=>$shopGood,
            'currpage'=>$currpage,
            'shops'=>$shops['list'],
            'goodsCatTree'=>$goodsCatTree,
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg = [];
        if($data['goods_id']==0||empty($data['goods_id'])){
            $errorMsg[] = '产品不能为空';
        }
        if(empty($data['shop_id'])){
            $errorMsg[] = '店铺不能为空';
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
        $data['shop_name'] = ShopService::getShopById($data['shop_id'])['shop_name'];
        $goods = GoodsService::getGoodInfo($data['goods_id']);
        $data['goods_sn'] = $goods['goods_sn'];
        $data['goods_name'] = $goods['goods_name'];
        $currpage = $request->input('currpage');
        unset($data['currpage']);
        try{
            if(key_exists('id',$data)){
                $flag = ShopGoodsService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/shopgoods/list')."?currpage=".$currpage);
                }
            }else{
                $flag = ShopGoodsService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/shopgoods/list'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }


    //ajax获取产品
    public function getGoods(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $goods = GoodsService::getGoods(['cat_id'=>$cat_id],['id','goods_name']);
        if($cat_id==0){
            $goods = GoodsService::getGoods([],['id','goods_name']);
        }
        if(!empty($goods)){
            return $this->result($goods,200,'获取产品成功');
        }else{
            return $this->result('',400,'获取产品失败');
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = ShopGoodsService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/shopgoods/list'));
            }
            return  $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
