<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\ArticleCatService;
class ArticleCatController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $parent_id = $request->input('parent_id',0);
        $cats = ArticleCatService::getList($parent_id);
        $cate = ArticleCatService::getInfo($parent_id);
        $last_parent_id = 0;
        if(!empty($cate)){
            $last_parent_id = $cate['parent_id'];
        }
        return $this->display('admin.articlecat.list',
            ['cats'=>$cats,
                'last_parent_id'=>$last_parent_id,
                'parent_id'=>$parent_id
            ]);
    }

    //添加
    public function addForm(Request $request)
    {
        $parent_id = $request->input('parent_id',0);
        $cate = ArticleCatService::getInfo($parent_id);//根据id获取信息
        //获取所有的栏目
        $cates = ArticleCatService::getCates();
        //获取所有的栏目(无限极分类)
        $catesTree = ArticleCatService::getCatesTree($cates);
        //dd($catesTree);
        return $this->display('admin.articlecat.add',
            [
                'catesTree'=>$catesTree,
                'parent_id'=>empty($cate['id'])?0:$cate['id']
            ]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $cate= ArticleCatService::getInfo($id);//根据id获取信息
        //获取所有的栏目
        $cates = ArticleCatService::getCates();
        //获取所有的栏目(无限极分类)
        $catesTree = ArticleCatService::getCatesTree($cates);
        foreach($catesTree as $k=>$v){
            if($v['id']==$id){
                unset($catesTree[$k]);//选着parent_id的时候不能存在自己的数据
            }
        }
        //dd($catesTree);
        return $this->display('admin.articlecat.edit',['catesTree'=>$catesTree,'cate'=>$cate]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $id = $request->input('id');
        unset($data['_token']);
        $errorMsg = [];
        if(empty($data['cat_name'])){
            $errorMsg[] = '分类名称不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        try{
            if(empty($id)){
                ArticleCatService::uniqueValidate($data['cat_name']);//唯一性验证
                $info = ArticleCatService::create($data);
            }else{
                $info = ArticleCatService::modify($id,$data);
            }
            if(!$info){
                return $this->error('保存失败');
            }
            return $this->success('保存成功！',url("/articlecat/list")."?parent_id=".$data['parent_id']);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //排序
    public function sort(Request $request)
    {
        $id = $request->input('id');
        $sort_order = $request->input('sort_order');
        try{
            $info = ArticleCatService::modify($id,['sort_order'=>$sort_order]);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/articlecat/list?parent_id=".$info['parent_id'],200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        //dd($id);
        //获取所有的栏目
        $cates = ArticleCatService::getCates();
        //获取当前id的所有下级id
        $ids = ArticleCatService::getChilds($cates,$id);
        $ids[]=$id;
        //dd($ids);
        try{
            $flag = ArticleCatService::delete($ids);
            if($flag){
                return $this->success('删除成功',url('/articlecat/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
