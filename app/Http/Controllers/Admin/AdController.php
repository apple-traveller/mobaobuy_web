<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\AdService;
use App\Services\AdPositionService;
class AdController extends Controller
{
    //列表
    public function list(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $position_id = $request->input('position_id',0);
        $condition = [];
        if(!$position_id==0){
            $condition['position_id'] = $position_id;
        }
        $pageSize = 10;
        $ads = AdService::getAdvertList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['sort_order'=>'desc']],$condition);
        //dd($ads['list']);
        $ad_positions = AdPositionService::getAdPositionLists();
        return $this->display('admin.ad.list',[
            'ads'=>$ads['list'],
            'total'=>$ads['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'ad_positions'=>$ad_positions,
            'position_id'=>$position_id
        ]);
    }

    //修改状态
    public function enabled(Request $request)
    {
        $id = $request->input("id");
        $enabled = $request->input("val", 0);
        try{
            AdService::modify(['id'=>$id,'enabled' => $enabled]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //添加
    public function addForm(Request $request)
    {
        $ad_positions = AdPositionService::getAdPositionLists();
        return $this->display('admin.ad.add',['ad_positions'=>$ad_positions]);
    }

    //编辑
    public function editForm(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $ad = AdService::getAdInfo($id);
        $ad_positions = AdPositionService::getAdPositionLists();
        return $this->display('admin.ad.edit',[
            'currpage'=>$currpage,
            'ad_positions'=>$ad_positions,
            'ad'=>$ad
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg = [];
        if(empty($data['ad_name'])){
            $errorMsg[] = '图片名称不能为空';
        }
        if(empty($data['ad_img'])){
            $errorMsg[] = '广告图片不能为空';
        }
        if(empty($data['start_time'])){
            $errorMsg[] = '开始时间不能为空';
        }
        if(strtotime($data['start_time'])>strtotime($data['end_time'])&&strtotime($data['end_time']>0)){
            $errorMsg[] = '开始时间不能大于结束时间';
        }
        $data['end_time'] = $this->requestGetNotNull('end_time',0);
        $data['ad_link'] = $this->requestGetNotNull('ad_link'," ");
        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }
        try{
            if(!key_exists('id',$data)){
                $flag = AdService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/ad/list'));
                }
                return $this->error('添加失败');
            }else{
                $flag = AdService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/ad/list'));
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
            $flag = AdService::delete($id);
            if($flag){
                return $this->success('删除成功',url('/admin/ad/list'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
