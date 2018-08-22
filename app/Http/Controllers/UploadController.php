<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class UploadController extends Controller
{
    //上传图片
    public function uploadImg(Request $request)
    {
        $file = $_FILES['file'];
        //print_r($file);die;
        //检测文件大小
        if(!empty($file)){
            if($file['size']>config('website.common_size'))
            {
                return $this->result( '',400,  '图片超过' . config('website.common_size')/(1024*1024) . 'M' );
            }
        }
        //检测图片格式
        $ext = explode('.', $file['name']);
        $ext = array_pop($ext);
        $allowImgs = config('website.common_img'); //读取系统配置的上传图片配置
        if(!in_array($ext, $allowImgs)){
            return $this->result('',400, '只能上传' . join(',',$allowImgs) . '的图片');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $date = date('Ymd');
        $new_file_name = date('YmdHis') . '.' . $ext;
        $path = "uploads/".$date."/";
        $file_path = $path . $new_file_name;

        //判断当前的目录是否存在，若不存在就新建一个!
        if (!is_dir($path)){mkdir($path, 0777, true);}
        //print_r($file['tmp_name']);die;
        $upload_result = move_uploaded_file($file['tmp_name'], $file_path);

        //此函数只支持 HTTP POST 上传的文件
        if ($upload_result) {
            return $this->result( "/".$file_path ,200,  '上传成功');
        } else {
            return $this->result('',400,   '上传失败');
        }

    }

    //上传文件接口
    public function uploadFile(Request $request)
    {
        $file = $_FILES['file'];
        //检测文件大小
        if(!empty($file)){
            if($file['size']>config('website.common_size'))
            {
                return $this->result( '',400,  '文件超过' . config('website.common_size')/(1024*1024) . 'M' );
            }
        }

        //检测图片格式
        $ext = explode('.', $file['name']);
        $ext = array_pop($ext);
        $allowImgs = config('website.common_file'); //读取系统配置的上传图片配置
        if(!in_array($ext, $allowImgs)){
            return $this->result('',400, '只能上传' . join(',',$allowImgs) . '的文件');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $date = date('Ymd');
        $new_file_name = date('YmdHis') . '.' . $ext;
        $path = "/uploads/".$date."/";
        $file_path = $path . $new_file_name;

        //判断当前的目录是否存在，若不存在就新建一个!
        if (!is_dir($path)){mkdir($path, 0777, true);}
        $upload_result = move_uploaded_file($file['tmp_name'], $file_path);
        //此函数只支持 HTTP POST 上传的文件
        if ($upload_result) {
            return $this->result( "/".$file_path ,200,  '上传成功');
        } else {
            return $this->result('',400,   '上传失败');
        }

    }
}
