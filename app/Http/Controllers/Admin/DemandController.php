<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\DemandService;
class DemandController extends Controller
{
    //列表
    public function getList(Request $request)
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

        return $this->display('admin.demand.list',[
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


    //会员卖货需求
    public function userSale(Request $request)
    {
        $user_name = $request->input('user_name','');
        $currpage = $request->input("currpage",1);
        $condition = [];
        if(!empty($user_name)){
            $condition['user_name'] = "%".$user_name."%";
        }
        $pageSize = 10;
        $list = DemandService::getUserSaleList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('admin.demand.sale',[
            'saleList'=>$list['list'],
            'user_name'=>$user_name,
            'saleCount'=>$list['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
        ]);
    }
    //设为已读
    public function setRead(Request $request)
    {
        $id = $request->get('id');
        $opinion = $request->get('opinion','');
        if(empty($id)){
            return $this->error('无法获取参数ID');
        }
        if(empty($opinion)){
            return $this->error('处理意见不能为空');
        }
        #修改数据库
        $data = ['is_read' => 1,'opinion'=>$opinion];
        $res = DemandService::userSaleModify($id,$data);
        if($res){
            return $this->success('处理成功');
        }else{
            return $this->error('处理失败！请联系管理员。');
        }
    }

    //整单采购需求
    public function userWholeSingle(Request $request)
    {
        $user_name = $request->input('user_name', '');
        $currpage = $request->input("currpage", 1);
        $condition = [];
        if (!empty($user_name)) {
            $condition['user_name'] = "%" . $user_name . "%";
        }
        $pageSize = 10;
        $list = DemandService::getUserWholeSingleList(['pageSize' => $pageSize, 'page' => $currpage, 'orderType' => ['add_time' => 'desc']], $condition);
        return $this->display('admin.demand.userWholeSingle'
            , [
                'saleList' => $list['list'],
                'user_name' => $user_name,
                'saleCount' => $list['total'],
                'currpage' => $currpage,
                'pageSize' => $pageSize,
            ]
        );
    }
    //整单采购设为已读
    public function setSingleRead(Request $request)
    {
        $id = $request->get('id');
        $opinion = $request->get('opinion','');
        if(empty($id)){
            return $this->error('无法获取参数ID');
        }
        if(empty($opinion)){
            return $this->error('处理意见不能为空');
        }
        #修改数据库
        $data = ['is_read' => 1,'opinion'=>$opinion];
        $res = DemandService::userWholeSaleModify($id,$data);
        if($res){
            return $this->success('处理成功');
        }else{
            return $this->error('处理失败！请联系管理员。');
        }
    }

}
