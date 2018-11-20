<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\HotSearchService;
use Carbon\Carbon;
use Illuminate\Http\Request;
class HotSearchController extends Controller
{
    //列表
    public function index(Request $request)
    {
        $currpage = $request->input('currpage',1);

        $pageSize = 10;
        $condition = [];
//        $condition = ['is_show' => 1];

        $hot = HotSearchService::getListBySearch(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['update_time'=>'desc']],$condition);

        return $this->display('admin.hotsearch.list',[
            'hot'=>$hot['list'],
            'total'=>$hot['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
        ]);
    }

    public function setShow(Request $request)
    {
        $id = $request->input('id',0);
        $is_show = $request->input('is_show',0);
        if(!$id){
            return $this->error('无法获取参数：ID');
        }
        $data = [
            'id'=>$id,
        ];
        if($is_show == 1){//启用改为禁用
            $data['is_show'] = 0;
        }else{
            $data['is_show'] = 1;
        }
        $res = HotSearchService::modify($data);
        if($res){
            return $this->success('设置成功','',$data);
        }else{
            return $this->error('设置失败');
        }

    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return $this->error('无法获取参数ID');
        }
        $res = HotSearchService::delete($id);
        if($res){
            return $this->success();
        }
    }
}
