<?php
/**
 * Created by PhpStorm.
 * User: kery
 * Date: 2018/7/17
 * Time: 10:40
 */
if(!function_exists('themePath')){
    function themePath($joint = ''){
        $theme = session('theme');
        if(empty($theme)){
            return '';
        }
        return $theme.$joint;
    }
}

if(!function_exists('getValue')){
    function getValue($obj, $key, $default=''){
        //echo 123;die;
        if(empty($obj)){
            return $default;
        }
        return $obj[$key] ?? $default;
    }
}

if(!function_exists('status')){
    function status($status) {
        if($status == 1) {
            $str = "<button class='layui-btn layui-btn-sm layui-btn-radius'>正常</button>";
        }elseif($status ==0) {
            $str = "<button class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>关闭</button>";
        }else {
            $str = "<button class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-disabled'>警用</button>";
        }
        echo  $str;
    }
}

