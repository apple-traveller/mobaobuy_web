<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-28
 * Time: 10:40
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use App\Services\ShopGoodsService;
use App\Services\ShopService;
use Illuminate\Http\Request;


class ShopGoodsController extends Controller
{
    /**
     *  商品列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Request $request)
    {
        $currpage = $request->input('currentPage',1);
        $goods_name = $request->input('goods_name','');
        $condition = [];
        if(!empty($goods_name)){
            $condition['goods_name']= "%".$goods_name."%";;
        }
        $pageSize =5;
        $shopGoods = GoodsService::getGoodsList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['id'=>'desc']],$condition);
        return $this->display('seller.shopgoods.list',[
            'total'=>$shopGoods['total'],
            'list'=>$shopGoods['list'],
            'goods_name' => $goods_name,
            'currentPage'=>$currpage,
            'pageSize'=>$pageSize
        ]);
    }

    /**
     * add one
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        return $this->display('seller.shopgoods.add',[
            'goodsCatTree'=>$goodsCatTree,
        ]);
    }

    /**
     *  修改
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = $request->input('id');
        $shopGood = ShopGoodsService::getShopGoodsById($id);
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        return $this->display('seller.shopgoods.edit',[
            'shopGood'=>$shopGood,
            'currentPage'=>$currentPage,
            'goodsCatTree'=>$goodsCatTree,
        ]);
    }

    /**
     * 统一 保存（修改|添加）
     * @param Request $request
     * @return ShopGoodsController|\Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $id = $request->input('id',0);
        $shop_id = session()->get('_seller_id')['shop_id'];
        $goods_id = $request->input('goods_id','');
        $goods_number = $request->input('goods_number',0);
        $shop_price = $request->input('shop_price','');
        $is_on_sale = $request->input('is_on_sale',1);
        if(!$goods_id){
            return $this->error('商品不能为空');
        }
        if(!$shop_id){
            return $this->error('店铺不能为空');
        }
        if(!$goods_number){
            return $this->error('库存不能为空');
        }
        if(!$shop_price){
            return $this->error('店铺售价不能为空');
        }

        $shop_name = ShopService::getShopById($shop_id)['shop_name'];
        $goods = GoodsService::getGoodInfo($goods_id);

        $in_data = [
            'shop_id' => $shop_id,
            'shop_name' => $shop_name,
            'goods_id' => $goods_id,
            'goods_sn' => $goods['goods_sn'],
            'goods_name' => $goods['goods_name'],
            'goods_number' => $goods_number,
            'shop_price' => $shop_price,
            'is_on_sale' => $is_on_sale
        ];
        $currentPage = $request->input('currentPage');

        try{
            if ($id){
                $in_data['id'] = $id;
                $flag = ShopGoodsService::modify($in_data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/seller/goods/list')."?currentPage=".$currentPage);
                }
            } else {
                //唯一性验证
                ShopGoodsService::uniqueValidate(['shop_id'=>$shop_id,'goods_id'=>$goods_id]);
                $flag = ShopGoodsService::create($in_data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/seller/goods/list'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    /**
     * 删除
     * @param Request $request
     * @return ShopGoodsController|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = ShopGoodsService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/seller/goods/list'));
            }
            return  $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 为layui提供api
     * @return \Illuminate\Http\JsonResponse
     */
    public function GoodsForm(Request $request)
    {
        $goods_name = $request->input('goods_name','');
        if(!empty($goods_name)){
            $c['opt'] = "OR";
            $c['goods_name'] = "%".$goods_name."%";
            $c['goods_sn'] = $goods_name;
            $c['brand_name'] = $goods_name;
            $c['goods_model'] = $goods_name;
            $condition[] = $c;
        }else{
            $condition = [];
        }
        $goods = GoodsService::getGoodsList([],$condition);
        $result = [
            'code'=>0,
            'msg'=>'',
            'count'=>$goods['total'],
            'data'=>$goods['list']
        ];
        return response()->json($result);
    }
    //ajax获取商品分类
    public function getGoodsCat(Request $request)
    {
        $cat_name = $request->input('cat_name');
        $condition = [];
        if($cat_name!=""){
            $condition['cat_name'] = "%".$cat_name."%";
        }
        $cates = GoodsCategoryService::getCatesByCondition($condition);
        return $this->result($cates,200,'获取数据成功');
    }

    //ajax获取商品值
    public function getGood(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $goods_name = $request->input('goods_name');
        $condition = [];
        if($cat_id!="" || $cat_id!=0){
            $condition['cat_id'] = $cat_id;
        }
        if($goods_name!=""){
            $condition['goods_name'] = "%".$goods_name."%";
        }
        $goods = GoodsService::getGoods($condition,['id','goods_full_name','packing_spec','packing_unit']);
        if(!empty($goods)){
            return $this->result($goods,200,'获取数据成功');
        }else{
            return $this->result([],400,'没有查询到数据');
        }

    }
}
