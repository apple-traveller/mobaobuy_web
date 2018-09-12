<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TemplateController extends Controller
{
    public function index()
    {
        return $this->display('admin.template.index');
    }

    public function decorate()
    {
        return $this->display('admin.template.decorate');
    }

    public function decoratetest()
    {
        return $this->display('admin.template.decoratetest');
    }



    //模板缓存
    public function saveTemplate(Request $request)
    {
        $content = $request->input('content');
       // dd($content);
        $file = "G:\phpStudy\PHPTutorial\WWW\mbb_web\public\uploads\page.html";
        file_put_contents($file,$content);
        return $this->result('',200,'更新缓存成功');

    }

    //确认发布
    public function publish(Request $request)
    {
        $data = $request->all();
        $rootdir = $_SERVER['DOCUMENT_ROOT']; //当前项目的跟目录
        $root = $rootdir."/uploads/newpage.html";
        file_put_contents($root,$data['content']);
        return $this->result($root,200,'发布成功');
    }

    //首页预览
    public function preview()
    {
        $rootdir = $_SERVER['DOCUMENT_ROOT']; //当前项目的跟目录
        $root = $rootdir."/uploads/newpage.html";
        $content = file_get_contents($root);
        return $this->display('admin.template.preview',['content'=>$content]);
    }

    //编辑页
    public function partEdit(Request $request)
    {
        $data = $request->all();
        $mode = $data['mode'];
        if($mode=="cust"){
            $pics = $this->getPics();
            return $this->result($pics,200,   '');
        }
        if($mode=="homeFloor"){
            return $this->result('',200,   '');
        }
        //return $this->display('admin.template.edit');
    }



    //测试数据(图片信息)
    public function getPics()
    {
        //查询所有的图片信息
        $path = $_SERVER['DOCUMENT_ROOT'].'/default/1';//G:/phpStudy/PHPTutorial/WWW/mbb_web/public/default/icon
        $filedata = array();
        if(!is_dir($path)) return false;
        $handle = opendir($path);
        if($handle){
            while(($fl = readdir($handle)) !== false){
                if($fl!="."&&$fl!=".."){
                    $filedata[]=$fl;
                }

            }
        }
        $count = count($filedata);
        $result = array();
        $result['count']=$count;
        $result['list']=$filedata;
        return $result;
    }

}
