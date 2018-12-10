<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\LogisticsService;
class LogisticsController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = $request->input("pagesize",10);
        $condition = [];
        $logistics = LogisticsService::getLogistics(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('admin.logistics.list',[
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'total'=>$logistics['total'],
            'goods'=>$logistics['list'],
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        return $this->display('admin.logistics.add');
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
    }


}
