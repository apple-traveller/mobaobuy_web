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
    public function getList(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $user_id = session()->get('_seller_id')['user_id'];
        $shop_id = session('_seller_id')['shop_id'];
        $condition['is_super']= 0;
        $pageSize =5;
        $shopUsers = ShopUserService::getNotSuper(['pageSize'=>$pageSize,'page'=>$currentPage],$shop_id,$user_id);
        return $this->display('seller.shopuser.list',[
            'total'=>$shopUsers['total'],
            'shopUsers'=>$shopUsers['list'],
            'currentPage'=>$currentPage,
            'shop_id'=>$shop_id,
            'pageSize'=>$pageSize
        ]);
    }

    public function add(Request $request)
    {
        return $this->display('seller.shopuser.add');
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $currentPage = $request->input('currentPage');
        $shopUser = ShopUserService::getShopUserById($id);
        return $this->display('seller.shopuser.edit',[
            'shopUser'=>$shopUser,
            'currentPage'=>$currentPage
        ]);
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
        $action_id = session('_seller_id')['user_id'];
        if(!$user_name){
            return $this->error('用户名不能为空');
        }

        $data = [
            'shop_id' => $shop_id,
            'user_name' => $user_name
        ];

        $lv = ShopUserService::getLv($action_id,$shop_id);

        if ($lv == 3){
            return $this->error('您不具备执行此操作的权限',url('/seller/shopUser')."?currentPage=".$currentPage);
        }
        if ($is_super){
            if ($lv == 2){
                return $this->error('您不具备修改\添加其他用户的管理权限',url('/seller/shopUser')."?currentPage=".$currentPage);
            }
            $data['is_super'] = $is_super;
        }
        if ($password){
            $data['password'] = bcrypt($password);
        }
        try{
            if($id){
                $u_lv = ShopUserService::getLv($id,$shop_id);
                if ($lv>=$u_lv){
                    return $this->error('您不具备执行此操作的权限',url('/seller/shopUser')."?currentPage=".$currentPage);
                }
               $data['id'] = $id;
                $info = ShopUserService::modify($data);
                if(!empty($info)){
                    return $this->success('修改成功',url('/seller/shopUser')."?currentPage=".$currentPage);
                }
            }else{
                //验证唯一性
                ShopUserService::uniqueValidate(['shop_id'=>$data['shop_id'],'user_name'=>$data['user_name']]);
                $data['add_time'] = Carbon::now();
                $info = ShopUserService::create($data);
                if(!empty($info)){
                    return $this->success('添加成功',url('/seller/shopUser'));
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
        $shop_id = session('_seller_id')['shop_id'];
        $action_id = session('_seller_id')['user_id'];
        $lv = ShopUserService::getLv($action_id,$shop_id);
        $u_lv = ShopUserService::getLv($id,$shop_id);
        if ($lv>=$u_lv){
            return $this->error('您不具备执行此操作的权限',url('/seller/shopUser'));
        }
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
