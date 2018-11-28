<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-13
 * Time: 20:48
 */
namespace App\Http\Controllers\Admin;

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
//        $shop_id = session('_seller_id')['shop_id'];

        $condition['is_delete']= 0;
        $pageSize =5;
        $shopStoreList = ShopStoreService::getShopStoreList(['pageSize'=>$pageSize,'page'=>$currentPage],$condition);
        return $this->display('admin.shopstore.list',[
            'total'=>$shopStoreList['total'],
            'storeList'=>$shopStoreList['list'],
            'currentPage'=>$currentPage,
            'pageSize'=>$pageSize
        ]);
    }

    public function storeList(Request $request)
    {
        $shop_id = $request->get('shop_id','');

        $condition['is_delete']= 0;
        $condition['shop_id']= $shop_id;

        $storeList = ShopStoreService::getShopStoreList([],$condition);
        if($storeList){
            return $this->success('获取成功','',$storeList['list']);
        }else{
            return $this->error('无信息');
        }
    }

    public function add()
    {
        return $this->display('admin.shopStore.add');
    }

    public function save(Request $request)
    {
        $shop_id = $request->get('shop_id','');
        $store_name = $request->get('store_name','');
        $id = $request->get('id','');

        $data = [
            'shop_id'=>$shop_id,
            'store_name'=>$store_name,
        ];
        #先验证唯一性
        try{
            $validate_res = ShopStoreService::uniqueValidate($data);
            if($validate_res){
                return $this->error('该店铺已经存在');
            }
            if(!empty($id)){
                $exist_res = ShopStoreService::getShopStoreById($id);
                if(empty($exist_res)){
                    return $this->error('该店铺信息不存在');
                }
                $data['id'] = $id;
                $res = ShopStoreService::modify($data);
            }else{
                $data['add_time'] = date('Y-m-d H:i:s');
                $data['is_delete'] = 0;

                $res = ShopStoreService::create($data);
            }

            if($res){
               return $this->success('保存成功！','/admin/shop/store');
            }else{
                return $this->error('保存失败！');
            }

        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
    public function edit(Request $request)
    {
        $id = $request->get('id',0);
        $currentPage = $request->input('currentPage');

        $storeInfo = ShopStoreService::getShopStoreById($id);

        return $this->display('admin.shopStore.edit',compact('storeInfo','currentPage'));
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
