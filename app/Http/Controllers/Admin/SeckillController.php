<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SeckillService;
class SeckillController extends Controller
{
    public function list(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_name = $request->input('shop_name');
        $pageSize = 10;
        $condition = [];
        if(!empty($shop_name)){
            $condition['shop_name'] = "%".$shop_name."%";
        }
        $seckills = SeckillService::getAdminSeckillList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        //dd($seckills);
        return $this->display('admin.seckill.list',[
            'seckills'=>$seckills['list'],
            'total'=>$seckills['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'shop_name'=>$shop_name
        ]);
    }

    //修改启用状态
    public function status(Request $request)
    {
        $id = $request->input("id");
        $enabled = $request->input("val", 0);
        try{
            UserService::modify(['id'=>$id,'is_freeze' => $is_freeze]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

}
