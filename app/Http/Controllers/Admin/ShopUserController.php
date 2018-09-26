<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ShopUserRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\ShopUserService;
use App\Services\ShopService;
use Illuminate\Support\Facades\Hash;

class ShopUserController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_id = $request->input('shop_id');
        $shops = ShopService::getShopList([],[]);
        $condition = [];
        if($shop_id!=0){
            $condition['shop_id']=$shop_id;
        }
        $pageSize =5;
        $shopUsers = ShopUserService::getShopUserList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        return $this->display('admin.shopuser.list',[
            'total'=>$shopUsers['total'],
            'shopusers'=>$shopUsers['list'],
            'currpage'=>$currpage,
            'shop_id'=>$shop_id,
            'pageSize'=>$pageSize,
            'shops'=>$shops['list']
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        $shops = ShopService::getShopList([],[]);
        //dd($shops);
        return $this->display('admin.shopuser.add',[
            'shops'=>$shops['list'],
        ]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $shopUser = ShopUserService::getShopUserById($id);
        $shops = ShopService::getShopList([],[]);
        return $this->display('admin.shopuser.edit',[
            'shops'=>$shops['list'],
            'shopUser'=>$shopUser,
            'currpage'=>$currpage
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $currpage = $request->input('currpage');
        $errorMsg = [];
        if(empty($data['user_name'])){
            $errorMsg[] = '用户名不能为空';
        }
        try{
            if(key_exists('id',$data)){
                unset($data['currpage']);
                if(empty($data['password'])){
                    unset($data['password']);
                }
                $info = ShopUserService::modify($data);
                if(!empty($info)){
                    return $this->success('修改成功',url('/admin/shopuser/list')."?currpage=".$currpage);
                }
            }else{
                //验证唯一性
                ShopUserService::uniqueValidate(['shop_id'=>$data['shop_id'],'user_name'=>$data['user_name']]);
                $data['add_time'] = Carbon::now();
                $data['password'] = Hash::make($data['password']);
                $info = ShopUserService::create($data);
                if(!empty($info)){
                    return $this->success('添加成功',url('/admin/shopuser/list'));
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
            $flag = ShopUserService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/shopuser/list'));
            }
            return  $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
