<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RegionRepo;
use Illuminate\Http\Request;
use App\Services\RegionService;
use App\Http\Controllers\ExcelController;
class RegionController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $parent_id = $request->input('parent_id',0);//作为parent_id查询当前页面的数据
        $last_parent_id = 0;
        $region_info = RegionService::getInfoByParentId($parent_id);
        if(!empty($region_info)){
            $last_parent_id = $region_info['parent_id'];
        }
        $regions= RegionService::getRegionList($parent_id);//前页面的数据
        $parentRegion = RegionService::getRegionNameById($parent_id);//获取当前页面所属地区名字
        $region_type = RegionService::getRegionTypeById($parent_id);//获取当前页面所属地区类型
        //dd($parentRegion);
        return $this->display('admin.region.list',
            ['regions'=>$regions,
             'parent_id'=>$parent_id,
             'parentRegion'=>$parentRegion,
             'region_type'=>$region_type+1,
             'last_parent_id'=>$last_parent_id
              ]
            );
    }

    //添加
    public function save(Request $request)
    {
        $data = array();
        $data['region_type'] = $request->input('region_type');
        $data['parent_id'] = $request->input('parent_id');
        $data['region_name'] = $request->input('region_name');
        if($data['region_name']==''){
            return $this->error('名称不能为空');
        }
        try{
            $flag = RegionService::create($data);
            if($flag){
                return $this->success("添加成功",url('/admin/region/list')."?parent_id=".$data['parent_id']);
            }else{
                return $this->error('添加失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $region_id = $request->input("region_id");
        $parent_id = $request->input("parent_id");
        try{
            $flag = RegionService::delete($region_id);
            //dd($flag);
            if($flag){
                return $this->success("删除成功",url('/admin/region/list')."?parent_id=".$parent_id);
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改
    public function modify(Request $request)
    {
        $region_id = $request->input('region_id');
        $region_name = $request->input('region_name');
        $parent_id = $request->input('parent_id');
        try{
            $flag = RegionService::modify($region_id,$region_name);
            if($flag){
                return $this->result("/admin/region/list?parent_id=".$parent_id,1,"修改成功");
            }else {
                return $this->result("", 0, "修改失败");
            }
        }catch(\Exception $e){
            return  $this->result('','0',$e->getMessage());
        }
    }


    //联动
    public function linkage(Request $request)
    {
        $id = $request->input('id');
        $data = RegionService::getRegionList($id);
        if($id==0){
            return $this->result("",400,'获取失败');
        }
        if(!empty($data)){
            return $this->result($data,200,'获取成功');
        }else{
            return $this->result('',400,'获取失败');
        }
    }








}
