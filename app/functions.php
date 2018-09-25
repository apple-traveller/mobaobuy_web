<?php
/**
 * Created by PhpStorm.
 * User: kery
 * Date: 2018/7/17
 * Time: 10:40
 */
if(!function_exists('themePath')){
    function themePath($joint = '', $prefix=''){
        if(empty($prefix)){
            $theme = session('theme', 'default');
        }else{
            $theme = session($prefix.'_theme', 'default');
        }

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
            $str = "<div class='layui-btn layui-btn-sm layui-btn-radius'>是</div>";
        }elseif($status ==0) {
            $str = "<div class='layui-btn layui-btn-sm layui-btn-radius layui-btn-primary'>否</div>";
        }else {
            $str = "<div class='layui-btn layui-btn-sm layui-btn-radius  layui-btn-danger'>禁用</div>";
        }
        echo  $str;
    }
}

if(!function_exists('createEvent')){
    function createEvent($name, $params=''){
        $clazz = "App\Events\\".ucwords($name);
        if(class_exists($clazz)){
            event(new $clazz($params));
        }
    }
}

if(!function_exists('getConfig')){
    function getConfig($code = ''){
        return \App\Services\SysConfigService::getConfig($code);
    }
}

