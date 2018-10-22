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
            $errorMsg[] = '产品不能为空';
        }
        if($data['shop_id']==0||empty($data['shop_id'])){
            $errorMsg[] = '店铺不能为空';
        }
        if(empty($data['delivery_place'])){
            $errorMsg[] = '交货地不能为空';
        }
        if(empty($data['expiry_time'])){
            $errorMsg[] = '截止时间不能为空';
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
                $goodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteById($data['id']);
                if(strtotime($data['expiry_time'])<strtotime($goodsQuote['add_time'])){
                    return $this->error('截止时间不能在添加时间之前');
                }
                $flag = ShopGoodsQuoteService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/shopgoodsquote/list')."?currpage=".$currpage);
                }
            }else{
                $data['add_time'] = Carbon::now();
                $data['outer_user_id'] = session('_admin_user_id');
                $data['outer_id'] = 0;
                if(strtotime($data['expiry_time'])<strtotime($data['add_time'])){
                    return $this->error('截止时间不能在添加时间之前');
                }
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
}
