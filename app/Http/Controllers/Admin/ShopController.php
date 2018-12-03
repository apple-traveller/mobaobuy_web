<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\ShopService;
use App\Services\UserService;
use App\Services\ShopUserService;
use App\Services\AdminService;
use App\Services\GsxxService;
class ShopController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_name = $request->input('shop_name',"");
        $condition = [];
        if(!empty($shop_name)){
            $condition['shop_name']="%".$shop_name."%";
        }
        $pageSize =10;
        $shops = ShopService::getShopList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        return $this->display('admin.shop.list',[
            'total'=>$shops['total'],
            'shops'=>$shops['list'],
            'currpage'=>$currpage,
            'shop_name'=>$shop_name,
            'pageSize'=>$pageSize
        ]);
    }


    //日志
    public function logList(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $pageSize = 10;
        $currpage = $request->input('currpage',1);
        $shopUsers = ShopUserService::getShopUserList([],[]);//所有的店铺用户
        $admins = AdminService::getAdminList([],[]);//所有的店铺用户
        $shop_logs = ShopService::getShopLogList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['log_time'=>'desc']],[]);
        //dd($shopUsers['list']);
        return $this->display('admin.shop.loglist',[
            'shop_logs'=>$shop_logs['list'],
            'total'=>$shop_logs['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'shopUsers'=>$shopUsers['list'],
            'admins'=>$admins
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        return $this->display('admin.shop.add');
    }

    //编辑
    public function editForm(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $id = $request->input('id');
        $shop = ShopService::getShopById($id);
        $user = UserService::getInfo($shop['user_id']);
        $nick_name = '';
        if(!empty($user)){
            $nick_name = $user['nick_name'];
        }

        return $this->display('admin.shop.edit',[
            'currpage'=>$currpage,
            'shop'=>$shop,
            'nick_name'=>$nick_name
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->requestGetNotNull('user_id','');
        $data['shop_name'] = $this->requestGetNotNull('shop_name','');
        $currpage = $request->input('currpage',1);
        unset($data['nick_name']);
        unset($data['currpage']);
        $errorMsg = [];
        if(empty($data['shop_name'])){
            $errorMsg[] = '店铺名称不能为空';
        }
        if(empty($data['company_name'])){
            $errorMsg[] = '企业全称不能为空';
        }
        if(empty($data['contactName'])){
            $errorMsg[] = '负责人姓名不能为空';
        }
        if(empty($data['contactPhone'])){
            $errorMsg[] = '负责人手机不能为空';
        }
        if(empty($data['attorney_letter_fileImg'])){
            $errorMsg[] = '授权委托书电子版不能为空';
        }
        if(empty($data['license_fileImg'])){
            $errorMsg[] = '营业执照副本电子版不能为空';
        }
        if(empty($data['business_license_id'])){
            $errorMsg[] = '营业执照注册号不能为空';
        }
        if(empty($data['taxpayer_id'])){
            $errorMsg[] = '纳税人识别号不能为空';
        }

        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        try{
            if(!key_exists('id',$data)){
                ShopService::uniqueValidate($data['company_name'],$data['user_name']);//唯一性验证
                $data['reg_time']=Carbon::now();
                $flag = ShopService::create($data);
                //dd($flag);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/shop/list'));
                }
            }else{
                $flag = ShopService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/shop/list')."?currpage=".$currpage);
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //查看
    public function detail(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $id = $request->input('id');
        $shop = ShopService::getShopById($id);
        $user = UserService::getInfo($shop['user_id']);
        $nick_name = '';
        if(!empty($user)){
            $nick_name = $user['nick_name'];
        }

        return $this->display('admin.shop.detail',[
            'currpage'=>$currpage,
            'shop'=>$shop,
            'nick_name'=>$nick_name,
            "id"=>$id
        ]);
    }

    //修改状态（ajax）
    public function isFreeze(Request $request)
    {
        $id = $request->input("id");
        $is_freeze = $request->input("val", 0);
        try{
            ShopService::modify( ['id'=>$id,'is_freeze' => $is_freeze]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //ajax修改状态
    public function isValidated(Request $request)
    {
        $data = $request->all();
        try{
            $shop= ShopService::modify($data);
            if($shop){
                 return $this->result($shop['is_validated'],'200',"审核成功");
            }else{
                return  $this->result('','400',"审核失败");
            }
        }catch(\Exception $e){
            return  $this->result('','400',$e->getMessage());
        }
    }

    //修改字段（ajax）
    public function modifyAjax(Request $request)
    {
        $data = $request->all();
        try{
            $flag = ShopService::modify($data);
            if(!empty($flag)){
                return $this->result($flag,200,'success');
            }else{
                return  $this->result('','400',"修改成功");
            }
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    public function getUsers(Request $request)
    {
        $nick_name = $request->input('nick_name');
        $condition = [];
        if(!empty($nick_name)){
            $condition['nick_name']="%".$nick_name."%";
        }
        $users = ShopService::getUserList($condition);
        if(!empty($users['list'])){
            return $this->result($users['list'],200,'获取用户成功');
        }else{
            return $this->result('',400,'没有用户可以选择');
        }
    }

    //调用企查查
    public function GsSearch(Request $request)
    {
        $company_name = $request->input("company_name");
        $flag = GsxxService::GsSearch($company_name);
        if($flag){
            return $this->result($flag,200,'该企业存在');
        }else{
            return $this->result('',400,'该企业不存在');
        }
    }

    //ajax获取商家列表,模糊查询
    public function getShopList(Request $request)
    {
        $company_name = $request->input('company_name');
        $is_self_run = $request->input('is_self_run');
        $condition = [
            'is_validated' => 1,
            'is_freeze' => 0,
        ];
        if(!empty($company_name)){
            $condition['company_name'] = "%".$company_name."%";
        }
        if(!empty($is_self_run)){
            $condition['is_self_run'] = $is_self_run;
        }
        $res = ShopService::getList([],$condition);
        if($res){
            return $this->success('成功！','',$res);
        }
        return $this->error();
    }



}
