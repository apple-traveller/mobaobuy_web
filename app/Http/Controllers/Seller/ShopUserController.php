<?php
/**
 * Created by PhpStorm.
 * User: selleristrator
 * Date: 2018-10-08
 * Time: 16:30
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ShopService;
use App\Services\ShopUserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopUserController extends Controller
{
    public function list(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $shop_id = session('_seller_id')['shop_id'];
        $shops = ShopService::getShopList([],[]);
        $condition = [];
        if($shop_id!=0){
            $condition['shop_id']=$shop_id;
        }
        $pageSize =5;
        $shopUsers = ShopUserService::getShopUserList(['pageSize'=>$pageSize,'page'=>$currentPage],$condition);
        return $this->display('seller.shopuser.list',[
            'total'=>$shopUsers['total'],
            'shopusers'=>$shopUsers['list'],
            'currentPage'=>$currentPage,
            'shop_id'=>$shop_id,
            'pageSize'=>$pageSize,
            'shops'=>$shops['list']
        ]);
    }

    public function add(Request $request)
    {
        return $this->display('seller.shopuser.add');
    }

    //保存
    public function save(Request $request)
    {
        $shop_id = session('_seller_id')['shop_id'];
        $currentPage = $request->input('currentPage');
        $id = $request->input('id','');
        $user_name = $request->input('user_name','');
        $password = base64_decode($request->input('password', ''));
        $is_super = $request->input('is_super', 0);

        if(!$user_name){
            return $this->error('用户名不能为空');
        }

        $data = [
            'shop_id' => $shop_id,
            'user_name' => $user_name
        ];
        if (!$password){
            $data['password'] = bcrypt($password);
        }
        if (!$is_super){
            $data['is_super'] = $is_super;
        }
        try{
            if($id){
               $data['id'] = $id;
                $info = ShopUserService::modify($data);
                if(!empty($info)){
                    return $this->success('修改成功',url('/seller/shopUser/list')."?currentPage=".$currentPage);
                }
            }else{
                //验证唯一性
                ShopUserService::uniqueValidate(['shop_id'=>$data['shop_id'],'user_name'=>$data['user_name']]);
                $data['add_time'] = Carbon::now();
                $info = ShopUserService::create($data);
                if(!empty($info)){
                    return $this->success('添加成功',url('/seller/shopUser/list'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = ShopUserService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/seller/shopUser'));
            }
            return  $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

}
