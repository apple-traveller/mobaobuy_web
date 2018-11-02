<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\DemandService;
class InvoiceController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $add_time = $request->input("add_time","");
        $currpage = $request->input('currpage',1);
        $action_state = $request->input('action_state',-1);
        $pageSize = 10;
        $condition = [];
        if($action_state!=-1){
            $condition['action_state'] = $action_state;
        }
        if(!empty($add_time)){
            $begin_time = trim(substr($add_time , 0 , 10));
            $end_time = trim(substr($add_time , -10));
            $condition['created_at|<'] = $end_time;
            $condition['created_at|>'] = $begin_time;
        }
        $demand = DemandService::getList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['created_at'=>'desc']],$condition);

        return $this->display('admin.invoice.list',[
            'demand'=>$demand['list'],
            'total'=>$demand['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'action_state'=>$action_state,
            'add_time'=>$add_time
        ]);
    }


    //查看详细信息
    public function detail(Request $request)
    {
        $id = $request->input("id");
        $currpage = $request->input("currpage");
        $action_state = $request->input("action_state");
        $demand = DemandService::getInfo($id);
        return $this->display('admin.demand.detail',[
            'demand'=>$demand,
            'currpage'=>$currpage,
            'action_state'=>$action_state
        ]);
    }



    //保存优惠活动
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg=[];
        if(empty($data['action_log'])){
            $errorMsg[] = "处理日志不能为空";
        }

        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }
        try{
            $operator = session('_admin_user_info')['real_name'];
            $time = Carbon::now();
            $data['action_log'] = $operator.";".$time.";".$data['action_log'];
            $data['action_state'] = 1;
            $flag = DemandService::update($data['id'],$data);
            if(empty($flag)){
                return $this->error("保存失败");
            }
            return $this->success("保存成功",url("/admin/demand/list"));

        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }




}
