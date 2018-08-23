<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\FriendLinkService;

class FriendLinkController extends Controller
{
    //列表页
    public  function list()
    {
        //查询所有的数据(分页)
        $pageSize =config('website.pageSize');
        $links = FriendLinkService::getLinks($pageSize);
        //dd($links);
        return $this->display('admin.friendlink.list',['links'=>$links]);
    }

    //添加页
    public function addForm()
    {
        return $this->display('admin.friendlink.add');
    }

    //编辑页
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $link = FriendLinkService::getInfo($id);
        return $this->display('admin.friendlink.edit',['link'=>$link]);
    }

    //保存
    public function add(Request $request)
    {
        $data = $request->all();
        $id = $request->input('id');
        $errorMsg = array();
        unset($data['_token']);
        if(empty($data['link_name'])){
            $errorMsg[] = "链接名称不能为空";
        }
        if(empty($data['link_url'])){
            $errorMsg[] = "链接地址不能为空";
        }
        if(empty($data['link_logo'])){
            $errorMsg[] = "链接logo不能为空";
        }
        if(!empty($errorMsg)){
            return $this->error(implode('<br/>',$errorMsg));
        }

        try{
            if(empty($id)){
                FriendLinkService::uniqueValidate($data['link_name']);//唯一性验证
                $info = FriendLinkService::create($data);
                if(empty($info)){
                    return $this->error('保存失败');
                }
            }else{
                $info = FriendLinkService::modify($id,$data);
                if(!$info){
                    return $this->error('保存失败');
                }
            }
            return $this->success('保存成功！',url("/link/list"));
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = FriendLinkService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/link/list'));
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
        $id = $request->input('id');
        $sort_order = $request->input('sort_order');
        try{
            $info = FriendLinkService::modify($id,['sort_order'=>$sort_order]);
            if(!$info){
                return $this->result('',400,'更新失败');
            }
            return $this->result("/link/list",200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }


    }

}
