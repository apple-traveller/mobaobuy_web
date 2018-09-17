<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BrandService;
class BrandController extends Controller
{
    //用户列表
    public function list(Request $request)
    {
        $brand_name = $request->input('brand_name','');
        $condition = [];
        if(!empty($brand_name)){
            $condition['brand_name']=$brand_name;
        }
        $currpage = $request->input('currpage',1);
        $pageSize = 3;
        $links = BrandService::getBrandList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['sort_order'=>'asc']],$condition);
        return $this->display('admin.brand.list',[
            'links'=>$links['list'],
            'total'=>$links['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'brand_name'=>$brand_name
        ]);

    }

    //编辑(修改状态)
    public function modify(Request $request)
    {

    }

    //查看详情信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $brands = BrandService::getBrandInfo($id);
        return $this->display('admin.brand.detail');
    }

    //修改状态（ajax）
    public function status(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        try{
            $info = BrandService::modify($data['id'],$data);
            $flag = 1;
            if(key_exists('is_delete',$data)){
                $flag = $info['is_delete'];
            }else{
                $flag = $info['is_recommend'];
            }
            if($info){
                return $this->result($flag,200,'修改成功');
            }else{
                return $this->result('',400,'修改失败');
            }
        }catch (\Exception $e){
            return $this->result('',400,'修改失败');
        }
    }

    //排序（ajax）
    public function sort(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        try{
            $info = BrandService::modify($data['id'],$data);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/admin/brand/list",200,'更新成功');
        }catch (\Exception $e){
            return $this->result('',400,'修改失败');
        }
    }



}
