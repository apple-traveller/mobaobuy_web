<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\LogisticsService;
use App\Services\OrderInfoService;
class LogisticsController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = $request->input("pagesize",10);
        $shipping_billno = $request->input("shipping_billno","");
        $condition['is_delete'] = 0;
        if(!empty($shipping_billno)){
            $condition['shipping_billno'] = "%".$shipping_billno."%";
        }
        $logistics = LogisticsService::getLogistics(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('admin.logistics.list',[
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'total'=>$logistics['total'],
            'logistics'=>$logistics['list'],
            'shipping_billno'=>$shipping_billno
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        //查询所有的快递公司
        $shippings = OrderInfoService::getShippingList();
        //dd($shippings);
        return $this->display('admin.logistics.add',['shippings'=>$shippings]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        //查询所有的快递公司
        $shippings = OrderInfoService::getShippingList();
        //dd($shippings);
        $logistic_info = LogisticsService::getLogisticInfo($id);
        return $this->display('admin.logistics.edit',
            [
                'logistic_info'=>$logistic_info,
                'shippings'=>$shippings,
                'currpage'=>$currpage,
            ]);
    }

    //保存
    public function save(Request $request)
    {
        $id = $request->input('id',0);
        $data = [
            'shipping_billno'=>$request->input('shipping_billno'),
            'shipping_company'=>$request->input('shipping_company'),
            'shipping_content'=>$request->input('shipping_content'),
            'is_delete'=>0
        ];

        try{
            if($id!=0){
                //编辑
                $currpage = $request->input('currpage',1);
                $data['id'] = $id;
                $flag = LogisticsService::modify($data);
                if(!empty($flag)){
                    return $this->success('编辑成功','/admin/logistics/list?currpage='.$currpage);
                }
            }else{
                //添加
                $data['add_time'] = Carbon::now();
                //验证唯一性
                LogisticsService::validateShippingNo($data['shipping_billno']);
                //保存
                $logistics = LogisticsService::create($data);
                if(!empty($logistics)){
                    return $this->success('添加成功','/admin/logistics/list');
                }
            }
            return $this->error('error');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = LogisticsService::modify(['id'=>$id,'is_delete'=>1]);
            if(!empty($flag)){
                return $this->success('删除成功','/admin/logistics/list');
            }
            return $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error('删除失败');
        }
    }


}
