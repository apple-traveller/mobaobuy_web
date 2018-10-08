<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = 10;
        $condition = [];
        $admins = AdminService::getAdminList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['updated_at'=>'asc']],$condition);
        //dd($admins['list']);
        return $this->display('admin.adminuser.list',[
            'admins'=>$admins['list'],
            'total'=>$admins['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage
        ]);
    }

    //修改状态
    public function isFreeze(Request $request)
    {
        $id = $request->input('id');
        $is_freeze = $request->input('val');
        try{
            AdminService::modify(['id'=>$id,'is_freeze'=>$is_freeze]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //查看详情
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $adminUser = AdminService::getAdminById($id);
        $created_by = AdminService::getAdminById($adminUser['created_by'])['user_name'];
        $updated_by = AdminService::getAdminById($adminUser['updated_by'])['user_name'];
        return $this->display('admin.adminuser.detail',[
            'currpage'=>$currpage,
            'adminUser'=>$adminUser,
            'created_by'=>$created_by,
            'updated_by'=>$updated_by,
        ]);
    }

    //日志
    public function log(Request $request)
    {
        $id = $request->input('id');
        $pcurrpage = $request->input('pcurrpage',1);
        $currpage = $request->input('currpage',1);
        $pageSize = 10;
        $condition = ['admin_id'=>$id];
        $logs = AdminService::getLogList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['log_time'=>'desc']],$condition);
        return $this->display('admin.adminuser.log',[
            'currpage'=>$currpage,
            'pcurrpage'=>$pcurrpage,
            'pageSize'=>$pageSize,
            'logs'=>$logs['list'],
            'total'=>$logs['total'],
            'id'=>$id
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        return $this->display('admin.adminuser.add');
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $adminUser = AdminService::getAdminById($id);
        return $this->display('admin.adminuser.edit',[
            'currpage'=>$currpage,
            'adminUser'=>$adminUser
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg = [];
        if(empty($data['user_name'])){
            $errorMsg[] = '用户名不能为空';
        }
        if(empty($data['real_name'])){
            $errorMsg[] = '真实姓名不能为空';
        }
        if(empty($data['mobile'])){
            $errorMsg[] = '手机不能为空';
        }
        if(empty($data['email'])){
            $errorMsg[] = '邮箱不能为空';
        }
        if(empty($data['avatar'])){
            $errorMsg[] = '头像不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }
        try{
            if(!key_exists('id',$data)){
                $data['created_at'] = Carbon::now();
                $data['password'] = Hash::make($data['password']);
                $data['created_by'] = session()->get('_admin_user_info')['id'];
                $data['updated_at'] = Carbon::now();
                $data['updated_by'] = session()->get('_admin_user_info')['id'];
                $flag = AdminService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/adminuser/list'));
                }
                return $this->error('添加失败');
            }else{
                $data['updated_at'] = Carbon::now();
                $data['updated_by'] = session()->get('_admin_user_info')['id'];
                if($data['password']==""){
                    unset($data['password']);
                }else{
                    $data['password'] = Hash::make($data['password']);
                }
                $flag = AdminService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/adminuser/list'));
                }
                return $this->error('修改失败');
            }

        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = AdminService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/adminuser/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
