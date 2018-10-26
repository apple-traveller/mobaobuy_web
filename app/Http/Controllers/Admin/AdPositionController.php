<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdPositionService;
class AdPositionController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = 10;
        $condition = [];
        $adpositions = AdPositionService::getAdPositionList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        //dd($adpositions['list']);
        return $this->display('admin.adposition.list',[
            'adpositions'=>$adpositions['list'],
            'total'=>$adpositions['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage
        ]);
    }



    //添加
    public function addForm(Request $request)
    {
        return $this->display('admin.adposition.add');
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $adPosition = AdPositionService::getAdPositionById($id);
        return $this->display('admin.adposition.edit',[
            'currpage'=>$currpage,
            'adPosition'=>$adPosition
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg = [];
        if(empty($data['position_name'])){
            $errorMsg[] = '广告位名称不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }
        try{
            if(!key_exists('id',$data)){
                $flag = AdPositionService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/ad/position/list'));
                }
                return $this->error('添加失败');
            }else{
                $flag = AdPositionService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/ad/position/list'));
                }
                return $this->error('修改失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = AdPositionService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/ad/position/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
