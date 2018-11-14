<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-13
 * Time: 20:48
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
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
        return $this->display('seller.shopStore.list',[
            'total'=>$shopStoreList['total'],
            'storeList'=>$shopStoreList['list'],
            'currentPage'=>$currentPage,
            'shop_id'=>$shop_id,
            'pageSize'=>$pageSize
        ]);
    }

    public function add()
    {
        return $this->display('seller.shopStore.add');
    }

    public function save(Request $request)
    {
        $shop_id = session('_seller_id')['shop_id'];
        $store_name = $request->get('store_name','');

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

            $data['add_time'] = date('Y-m-d H:i:s');
            $data['is_delete'] = 0;

            $res = ShopStoreService::create($data);
            if($res){
               return $this->success('添加成功！','/seller/store');
            }else{
                return $this->error('添加失败！',url('/seller/store/add'));
            }

        }catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }
    public function edit()
    {
        
    }

    public function delete()
    {
        
    }
}
