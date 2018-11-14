<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\UnitService;
class UnitController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $units = UnitService::getUnitsList();
        return $this->display('admin.unit.list',['units'=>$units['list'],'total'=>$units['total']]);
    }

    //添加
    public function addForm(Request $request)
    {
        return $this->display('admin.unit.add');
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $unit = UnitService::getUnitById($id);
        return $this->display('admin.unit.edit',['unit'=>$unit]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $errorMsg = [];
        if(empty($data['unit_name'])){
            $errorMsg[] = "单位名称不能为空";
        }
        if(!empty($errorMsg)){
            return $this->error(implode(',',$errorMsg));
        }
        try{
            if(key_exists('id',$data)){
                $flag = UnitService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/unit/list'));
                }
            }else{
                $data['add_time'] = Carbon::now();
                $flag = UnitService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/unit/list'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = UnitService::delete($id);
            if(!$flag){
                return $this->error('删除失败');
            }else{
                return $this->success('删除成功',url('/admin/unit/list'));
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //排序
    public function sort(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        try{
            $info = UnitService::modify($data);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/admin/unit/list",200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }




}
