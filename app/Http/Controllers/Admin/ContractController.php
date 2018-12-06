<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderContractService;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = 10;
        $condition = [];

        $list = OrderContractService::getListBySearch(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('admin.orderinfo.contract',[
            'total'=>$list['total'],
            'list'=>$list['list'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage
        ]);
    }
}
