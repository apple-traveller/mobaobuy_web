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
    public function list(Request $request)
    {
        $currpage = $request->input('currentPage',1);
        $shop_id = session('_seller_id')['shop_id'];
        $goods_name = $request->input('goods_name','');
        $condition = [];
        $condition['shop_id']= $shop_id;
        if(!empty($goods_name)){
            $condition['goods_name']= "%".$goods_name."%";;
        }

        $pageSize =5;
        $shopGoods = ShopGoodsService::getShopGoodsList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        $search = ShopGoodsService::getGoodsList(['shop_id'=>$shop_id]);
        return $this->display('seller.ShopGoods.list',[
            'total'=>$shopGoods['total'],
            'list'=>$shopGoods['list'],
            'search' => $search,
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
        return $this->display('seller.ShopGoods.add',[
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
        return $this->display('seller.ShopGoods.edit',[
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
            return $this->error('产品不能为空');
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
     * 获取产品
     * @param Request $request
     * @return ShopGoodsController
     */
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
}
