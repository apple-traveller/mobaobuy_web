<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    //上传图片
    public function uploadImg(Request $request)
    {
        $fileCharater = $request->file('file');
        return $this->result($fileCharater,200,'success');
        if ($fileCharater->isValid()) {
            //括号里面的是必须加的哦
            //如果括号里面的不加上的话，下面的方法也无法调用的
            //获取文件的扩展名
            $ext = $fileCharater->getClientOriginalExtension();
            //获取文件的绝对路径
            $path = $fileCharater->getRealPath();
            //定义文件名
            $filename = date('Ymdhis').'.'.$ext;
            $store_path = $request->input('upload_path');
            if(!empty($store_path)){
                $filename = str_finish($store_path, DIRECTORY_SEPARATOR).$filename;
            }
            //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
            Storage::put($filename, file_get_contents($path));
            $url = Storage::url($filename);
            return $this->success('上传成功','', ['path'=> $filename, 'url'=> $url]);
        }

    }
}
