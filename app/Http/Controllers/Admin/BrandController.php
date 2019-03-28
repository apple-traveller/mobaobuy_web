<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepo;
use App\Services\GoodsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BrandService;
class BrandController extends Controller
{
    //用户列表
    public function getList(Request $request)
    {
        $brand_name = $request->input('brand_name','');
        $condition = [
            'is_delete'=>0
        ];
        if(!empty($brand_name)){
            $condition['brand_name']= '%'.$brand_name.'%';
        }
        $currpage = $request->input('currpage',1);
        $pageSize = 10;
        $links = BrandService::getBrandList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['sort_order'=>'asc']],$condition);
        return $this->display('admin.brand.list',[
            'links'=>$links['list'],
            'total'=>$links['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'brand_name'=>$brand_name
        ]);

    }

    //添加
    public function addForm(Request $request)
    {
        return $this->display('admin.brand.add');
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $brand = BrandService::getBrandInfo($id);
        return $this->display('admin.brand.edit',['currpage'=>$currpage,'brand'=>$brand]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $currpage = 1;
        if (!empty($data['currpage'])) {
            $currpage = $data['currpage'];
            unset($data['currpage']);
        }
        $errorMsg = [];
        if (empty($data['brand_name'])) {
            $errorMsg[] = "品牌名称不能为空";
        }
        if (empty($data['brand_first_char'])) {
            $errorMsg[] = "品牌首字母不能为空";
        }
        if (empty($data['brand_logo'])) {
            $errorMsg[] = "品牌Logo不能为空";
        }
        if (!empty($errorMsg)) {
            return $this->error(implode("|", $errorMsg));
        }
        try {
            if (!key_exists('id', $data)) {
                BrandService::uniqueValidate($data['brand_name']);//唯一性验证
                $data['add_time'] = Carbon::now();
                $info = BrandService::create($data);
                if (!empty($info)) {
                    return $this->success('添加成功', url('/admin/brand/list'));
                }
            } else {//修改品牌
                //先获取原数据
                $old_info = BrandRepo::getInfo($data['id']);
                $info = BrandService::modify($data);
                if (!empty($info)) {
                    //同步修改商品表冗余字段
                    if($old_info['brand_name'] != $data['brand_name'] || $old_info['brand_name_en'] != $data['brand_name_en']){
                        $brand_name = $old_info['brand_name'] != $data['brand_name'] ? $data['brand_name'] : '';
                        $brand_name_en = $old_info['brand_name_en'] != $data['brand_name_en'] ? $data['brand_name_en'] : '';
                        GoodsService::syncGoodsByBrand($info['id'],$brand_name,$brand_name_en);
                    }

                    return $this->success('保存成功！', url("/admin/brand/list") . "?currpage=" . $currpage);
                }
            }
            return $this->error('保存失败');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

    }


    //修改状态（ajax）
    public function isRemmond(Request $request)
    {
        $id = $request->input("id");
        $is_recommend = $request->input("val", 0);
        try{
            BrandService::modify(['id'=>$id, 'is_recommend' => $is_recommend]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //排序（ajax）
    public function sort(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        try{
            $info = BrandService::modify($data);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/admin/brand/list",200,'更新成功');
        }catch (\Exception $e){
            return $this->result('',400,'修改失败');
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return $this->error('无法获取参数ID');
        }
        try{
            //检测品牌是否存在对应商品
            $flag = BrandService::delete($id);

            if($flag){
                return $this->success('删除成功',url('/admin/brand/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }



}
