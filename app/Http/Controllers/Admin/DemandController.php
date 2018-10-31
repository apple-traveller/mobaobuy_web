<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\DemandService;
class DemandController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $action_state = $request->input('action_state',-1);
        $pageSize = 10;
        $condition = [];
        if($action_state!=-1){
            $condition['action_state'] = $action_state;
        }
        $demand = DemandService::getList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['created_at'=>'desc']],$condition);

        return $this->display('admin.demand.list',[
            'demand'=>$demand['list'],
            'total'=>$demand['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'action_state'=>$action_state
        ]);
    }


    //查看商品信息
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
        if(empty($data['shop_id'])){
            $errorMsg[] = "商家不能为空";
        }
        if(empty($data['goods_id'])){
            $errorMsg[] = "商品不能为空";
        }
        if(empty($data['begin_time'])){
            $errorMsg[] = "开始时间不能为空";
        }
        if(empty($data['end_time'])){
            $errorMsg[] = "结束时间不能为空";
        }
        if(strtotime($data['end_time'])<strtotime($data['begin_time'])){
            $errorMsg[] = "结束时间不能小于开始时间";
        }
        if(empty($data['price'])){
            $errorMsg[] = "促销价格不能为空";
        }
        if(empty($data['num'])){
            $errorMsg[] = "促销总数量不能为空";
        }
        if(empty($data['available_quantity'])){
            $errorMsg[] = "当前可售数量不能为空";
        }
        if(empty($data['min_limit'])){
            $errorMsg[] = "最小起售数量不能为空";
        }

        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }
        try{
            if(!key_exists('id',$data)){
                $data['add_time'] = Carbon::now();
                $flag = ActivityService::create($data);
                if(empty($flag)){
                    return $this->error("添加失败");
                }
                return $this->success("添加成功",url("/admin/promote/list"));
            }else{
                $currpage = $data['currpage'];
                unset($data['currpage']);
                $flag = ActivityService::updateById($data['id'],$data);
                if(empty($flag)){
                    return $this->error("修改失败");
                }
                return $this->success("修改成功",url("/admin/promote/list")."?currpage=".$currpage);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }




}
