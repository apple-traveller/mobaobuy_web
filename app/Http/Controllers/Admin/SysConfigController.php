<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\SysConfigService;

class SysConfigController extends Controller
{
    //
    public function index(Request $request)
    {
        //查询所有配置信息
        $topConfigs = SysConfigService::getInfo($parent_id=0);
        //获取父类配置的子类配置
        $parent_id = $request->input('parent_id',1);
        $childConfids = SysConfigService::getInfo($parent_id);
        //dd($configs);
        return $this->display('admin.sysconfig.index',
            ['topConfigs'=>$topConfigs,
                'childConfids'=>$childConfids,
                 'parent_id'=>$parent_id
            ]);
    }

    //配置修改
    public function modify(Request $request)
    {
        $data = $request->all();
        $parent_id = $request->input('parent_id');
        unset($data['parent_id']);
        unset($data['_token']);
        try{
            $flag = SysConfigService::modify($data);
            if($flag){
                return $this->success('保存成功',url('/sysconfig/index')."?parent_id=".$parent_id);
            }else{
                return $this->success('保存失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

}
