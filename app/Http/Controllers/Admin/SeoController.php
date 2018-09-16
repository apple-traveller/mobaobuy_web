<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SeoService;
class SeoController extends Controller
{
    //
    public function index(Request $request)
    {
        //查询所有配置信息
        $seos = SeoService::getList();
        $id = $request->input('id',1);
        $seo = SeoService::getInfo($id);
        //dd($seos);
        return $this->display('admin.seo.index',['seos'=>$seos,'seo'=>$seo,'id'=>$id]);
    }

    //配置修改
    public function modify(Request $request)
    {
        $data = $request->all();
        //$id = $data['id'];
        unset($data['_token']);
        try{
            $flag = SeoService::modify($data);
            //dd($flag);
            if($flag){
                return $this->success('保存成功',url('/admin/seo/index')."?id=".$data['id']);
            }else{
                return $this->success('保存失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }

}
