<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\FirmBlacklistService;
use App\Http\Controllers\ExcelController;
class FirmBlackController extends Controller
{
    //企业黑名单列表
    public function getList(Request $request)
    {
        $firm_name = $request->input('firm_name','');
        $currpage = $request->input("currpage",1);
        $pageSize = 4;
        $condition = [];
        if(!empty($firm_name)){
            $condition['firm_name'] = "%".$firm_name."%";
        }
        $blacklist = FirmBlacklistService::getBlackList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        return $this->display('admin.blacklist.list',[
            'blacklist'=>$blacklist['list'],
            'firm_name'=>$firm_name,
            'count'=>$blacklist['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
        ]);
    }

    //添加黑名单
    public function addForm()
    {
        return $this->display('admin.blacklist.add');
    }

    //添加黑名单
    public function save(Request $request)
    {
        $data = array();
        $errorMsg = array();
        $data['firm_name']=$request->input('firm_name');
        $data['taxpayer_id']=$request->input('taxpayer_id');

        if(empty($data['firm_name'])){
            $errorMsg[] = '企业名称不能为空';
        }
        if(empty($data['taxpayer_id'])){
            $errorMsg[] = '税号不能为空';
        }

        //查询企业号是否已经存在
        $is_exists = FirmBlacklistService::validateUnique($data['firm_name']);

        if(!empty($is_exists)){
            $errorMsg[] = '该企业已经存在';
        }

        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }

        try{
            $data['add_time']=Carbon::now();
            $flag = FirmBlacklistService::create($data);
            if(!$flag){
                return $this->error('添加失败');
            }else{
                return $this->success('添加成功',url('/admin/blacklist/list'));
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input("id");
        try{
            $flag = FirmBlacklistService::delete($id);

            //dd($flag);
            if($flag){
                return $this->success("删除成功",url('/admin/blacklist/list'));
            }else{
                return  $this->error("删除失败");
            }
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }

    }

    //批量删除
    public function deleteAll(Request $request)
    {
        $ids = $request->input('checkboxes');
        try{
            $flag = FirmBlacklistService::delete($ids);
            if($flag){
                return $this->success("批量删除成功",url('/admin/blacklist/list'));
            }else{
                return  $this->error("批量删除失败");
            }
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }

    }

    //导出黑名单
    public static function export()
    {
        $excel = new ExcelController();
        $data = array();
        $data = [
            ['ID','企业名称','税号','添加时间']
        ];
        $users = FirmBlacklistService::getBlacklists(['id','firm_name','taxpayer_id','add_time']);
        foreach($users as $item){
            $data[]=$item;
        }
        $excel->export($data,'黑名单列表');
    }

}
