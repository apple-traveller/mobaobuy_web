<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-13
 * Time: 20:48
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ShopGoodsQuoteService;
use App\Services\ShopStoreService;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class ShopStoreController extends Controller
{
    public function getList(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
//        $user_id = session()->get('_seller_id')['user_id'];
        $shop_id = session('_seller_id')['shop_id'];
        $condition['is_delete']= 0;
        $condition['shop_id']= $shop_id;
        $pageSize =5;
        $shopStoreList = ShopStoreService::getShopStoreList(['pageSize'=>$pageSize,'page'=>$currentPage],$condition);
        return $this->display('seller.shopstore.list',[
            'total'=>$shopStoreList['total'],
            'storeList'=>$shopStoreList['list'],
            'currentPage'=>$currentPage,
            'shop_id'=>$shop_id,
            'pageSize'=>$pageSize
        ]);
    }

    public function storeList()
    {
        $shopInfo = session('_seller')['shop_info'];
        $shop_id = $shopInfo['id'];
        $condition['is_delete']= 0;
        $condition['shop_id']= $shop_id;
        if ($shopInfo['is_self_run']==0){
            $storeList = [];
        } else {
            $storeList = ShopStoreService::getShopStoreList([],$condition);
        }
        return $this->success('获取成功','',isset($storeList['list'])?$storeList['list']:[]);
    }

    public function add()
    {
        $shop_info = session('_seller')['shop_info'];
        if ($shop_info['is_self_run']!=1){
            return $this->error('非自营商家无法添加店铺');
        }
        return $this->display('seller.shopStore.add');
    }

    public function save(Request $request)
    {
        $shop_info = session('_seller')['shop_info'];
        if ($shop_info['is_self_run']!=1){
            return $this->error('非自营商家无法添加店铺');
        }
        $shop_id = $shop_info['id'];
        $store_name = $request->get('store_name','');
        $store_name_en = $request->get('store_name_en','');
        $id = $request->get('id',0);
        $data = [
            'shop_id'=>$shop_id,
            'store_name'=>$store_name,
            'store_name_en'=>$store_name_en,
            'store_img'=>$request->get('store_img',''),
            'main_cat'=>$request->get('main_cat',''),
            'main_brand'=>$request->get('main_brand',''),
            'spec'=>$request->get('spec',''),
            'delivery_area'=>$request->get('delivery_area',''),
            'delivery_method'=>$request->get('delivery_method',''),
            'main_cat_en'=>$request->get('main_cat_en',''),
            'main_brand_en'=>$request->get('main_brand_en',''),
            'spec_en'=>$request->get('spec_en',''),
            'delivery_area_en'=>$request->get('delivery_area_en',''),
            'delivery_method_en'=>$request->get('delivery_method_en',''),
        ];
        #先验证唯一性
        try{

            if(!empty($id)){
                $exist_res = ShopStoreService::getShopStoreById($id);
                if(empty($exist_res)){
                    return $this->error('该店铺信息不存在');
                }
                $data['id'] = $id;
                $res = ShopStoreService::modify($data);
            }else{
                $validate_res = ShopStoreService::uniqueValidate($data);
                if($validate_res){
                    return $this->error('该店铺已经存在');
                }
                $data['add_time'] = date('Y-m-d H:i:s');
                $data['is_delete'] = 0;

                $res = ShopStoreService::create($data);
            }

            if($res){
               return $this->success('保存成功！','/seller/store');
            }else{
                return $this->error('保存失败！');
            }

        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
    public function edit(Request $request)
    {
        $shop_info = session('_seller')['shop_info'];
        if ($shop_info['is_self_run']!=1){
            return $this->error('非自营商家无法添加店铺');
        }
        $id = $request->get('id',0);
        $currentPage = $request->input('currentPage');

        $storeInfo = ShopStoreService::getShopStoreById($id);

        return $this->display('seller.shopStore.edit',compact('storeInfo','currentPage'));
    }

    /**
     * delete
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->get('id',0);
        if(!$id){
            return $this->error('无法获取店铺ID');
        }

        $check = ShopStoreService::getShopStoreById($id);
        if(empty($check)){
            return $this->error('店铺信息不存在');
        }
        //检测店铺是否存在报价
        $is_exist_order = ShopGoodsQuoteService::checkStoreExistQuote($id);
        if($is_exist_order){
            return $this->error('该店铺存在相应报价，无法删除');
        }

        $res = ShopStoreService::modify(['id'=>$id,'is_delete'=>1]);
        if($res){
            return $this->success('删除成功！');
        }else{
            return $this->success('删除失败！');
        }
    }
}
