<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
class AdminUserController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = 10;
        $condition = [];
        $admins = AdminService::getAdminList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['sort_order'=>'asc']],$condition);
        return $this->display('admin.');
    }

    //添加
    public function addForm(Request $request)
    {

    }

    //编辑
    public function editForm(Request $request)
    {

    }

    //保存
    public function save(Request $request)
    {

    }

    //排序
    public function sort(Request $request)
    {

    }

    //删除
    public function delete(Request $request)
    {

    }
}
