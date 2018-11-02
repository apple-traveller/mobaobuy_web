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
        if(empty($obj)){
            return $default;
        }
        return $obj[$key] ?? $default;
    }
}

if(!function_exists('getNotEmptyValue')){
    function getNotEmptyValue($obj, $key, $default=''){
        $value = getValue($obj, $key, $default);
        if(empty($value)){
            return $default;
        }
        return $value;
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
            $params['_event_data'] = Carbon\Carbon::now();
            event(new $clazz($params));
        }
    }
}

if(!function_exists('getConfig')){
    function getConfig($code = '', $default = ''){
        $value = \App\Services\SysConfigService::getConfig($code);
        if(empty($value)){
            return $default;
        }
        return $value;
    }
}

if(!function_exists('getFileUrl')){
    function getFileUrl($file_path){
        if(preg_match('/^(http|https):\/\/(.*)/', $file_path)){
            return $file_path;
        }
        return \Illuminate\Support\Facades\Storage::url($file_path);
    }
}

if(!function_exists('getPositionNav')){
    function getPositionNav($position){
        $value = \App\Services\NavService::getPositionList($position);
        return $value;
    }
}

if(!function_exists('getFooterArticle')){
    function getFooterArticle(){
        $value = \App\Services\ArticleService::getFooterArticle();
        return $value;
    }
}

if(!function_exists('getCategoryTree')){
    function getCategoryTree(){
        $value = \App\Services\GoodsCategoryService::getCategoryTree();
        return $value;
    }
}

if(!function_exists('amount_format')){
    function amount_format($amount, $decimals=2, $currency_symbol='￥', $dec_point='.', $thousands_sep=','){
        $value = number_format($amount, $decimals, $dec_point, $thousands_sep);
        return $currency_symbol.$value;
    }
}

if(!function_exists('make_treeTable')) {
    /**
     * 列表转树表格
     * @param $list 数据列表
     * @param string $pk 主键字段
     * @param string $pid 关联父字段
     * @param string $child 子结点名称
     * @param int $root 第一层父ID值
     * @return array
     */
    function make_treeTable($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        $tree = array();
        $packData = array();

        //转换数组的结构
        foreach ($list as $data) {
            $packData[$data[$pk]] = $data;
        }

        foreach ($packData as $key => $val) {
            if ($val[$pid] == $root) {//代表跟节点
                $tree[] =& $packData[$key];
            } else {
                //找到其父类
                $packData[$val[$pid]][$child][] =& $packData[$key];
            }
        }
        return $tree;
    }
}

if(!function_exists('getRealNameBool')){
    //获取用户是否实名认证
    function getRealNameBool($user_id)
    {
        $res = \App\Services\UserRealService::getInfoByUserId($user_id);
        if(!empty($res) && $res['review_status'] == 1){//已实名认证
            return true;
        }
        return false;
    }
}


