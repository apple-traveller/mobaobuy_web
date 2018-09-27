<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NavService;
class NavController extends Controller
{
    //
    public function list(Request $request)
    {

        $currpage = $request->input('currpage',1);
        $pageSize = 10;
        $navs = NavService::getNavs(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['sort_order'=>'asc']],[]);

        return $this->display('admin.nav.list',[
            'navs'=>$navs['list'],
            'count'=>$navs['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize
        ]);
    }

    //添加
    public function addForm()
    {
        return $this->display('admin.nav.add');
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $nav = NavService::getInfo($id);
        return $this->display('admin.nav.edit',['nav'=>$nav,'currpage'=>$currpage]);
    }

    //保存
    public function add(Request $request)
    {
        $data = $request->all();
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        unset($data['currpage']);
        //dd($id);
        unset($data['_token']);
        $errorMsg = [];
        if(empty($data['name'])){
            $errorMsg[] = "导航名称不能为空";
        }
        if(empty($data['url'])){
            $errorMsg[] = "导航地址不能为空";
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }
        try{
            if(empty($id)){
                NavService::uniqueValidate($data['name']);//唯一性验证
                $info = NavService::create($data);
                if(empty($info)){
                    return $this->error('保存失败');
                }
            }else{
                //NavService::uniqueValidate($data['name']);//唯一性验证
                $info = NavService::modify($id,$data);
                if(empty($info)){
                    return $this->error('保存失败');
                }
            }
            return $this->success('保存成功！',url("/admin/nav/list")."?currpage=".$currpage);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //ajax修改状态
    public function status(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $id = $request->input('id');

        try{
            $info = NavService::modify($id,$data);

            if($info){
                if(!array_key_exists('opennew',$data)){
                    return $this->result($info['is_show'],200,"修改成功");
                }else{
                    //return "123";
                    return $this->result($info['opennew'],200,"修改成功");
                }

            }else{
                return  $this->result('',400,"修改失败");
            }
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }

    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = NavService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/nav/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //ajax排序
    public function sort(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $id = $request->input('id');
        try{
            $info = NavService::modify($id,$data);
            if(empty($info)){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/admin/nav/list",200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }


    }




}
