<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FriendLinkService;

class FriendLinkController extends Controller
{
    //列表页
    public  function list(Request $request)
    {
        //查询所有的数据(分页)
        $currpage = $request->input('currpage',1);
        $pageSize = 3;
        $links = FriendLinkService::getLinks(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['sort_order'=>'asc']],[]);
        //dd($links);
        return $this->display('admin.friendlink.list',[
            'links'=>$links['list'],
            'pageSize'=>$pageSize,
            'count'=>$links['total'],
            'currpage'=>$currpage
        ]);
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
    public function save(Request $request)
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
        $regex = '/\b(([\w-]+:\/\/?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/';
        if(!preg_match($regex,$data['link_url'])){
            $errorMsg[] = "请输入正确的url";
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
            return $this->success('保存成功！',url("/admin/link/list"));
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
                return $this->success('删除成功',url('/admin/link/list'));
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
            return $this->result("/admin/link/list",200,'更新成功');
        }catch(\Exception $e){
            return $this->result('',400,$e->getMessage());
        }


    }

}
