<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BrandService;
class BrandController extends Controller
{
    //用户列表
    public function list(Request $request)
    {
        $user_name = $request->input('user_name','');
        $currpage = $request->input("curr",1);
        $pageSize = 4;
        $is_firm = $request->input('is_firm',0);
        $condition = ['is_firm'=>$is_firm];
        if(!empty($user_name)){
            $condition['user_name'] = $user_name;
        }
        $users = BrandService::getBrandList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        //dd($users);
        return $this->display();
    }

    //编辑(修改状态)
    public function modify(Request $request)
    {
        $id = $request->input("id");
        $data = $request->all();
        unset($data['_token']);
        try{
            $user = UserService::modify($id,$data);
            if($user){
                return $this->result($user['is_freeze'],'1',"修改成功");
            }else{
                return  $this->result('','0',"修改失败");
            }
        }catch(\Exception $e){
            return  $this->result('','0',$e->getMessage());
        }
    }

    //查看详情信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $info = UserService::getInfo($id);//基本信息
        $user_invoices = UserInvoicesService::getInfoByUserId($id);//会员发票信息
        $user_address = UserAddressService::getInfoByUserId($id);//收货地址列表
        $region = RegionService::getList($pager=[],$condition=[]);
        //dd($region);
        return $this->display('admin.user.detail',
            [ 'info'=>$info,
              'user_invoices'=>$user_invoices,
              'user_address'=>$user_address,
              'region'=>$region
            ]);
    }



}
