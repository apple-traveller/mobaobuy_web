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
        $file_path = str_replace('\\','/',$file_path);
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
if(!function_exists('timeFormat')){
    function timeFormat($res)
    {
        if($res <= 9){
            return '0'.$res;
        }
        return $res;
    }
}

if(!function_exists('getSidebar')){
    function getSidebar()
    {
        $cat_list = [];
        $Cates1 = \App\Services\ArticleCatService::getList(1);

        foreach ($Cates1 as $k1=>$v1){
            $cat_list[$k1] = \App\Services\ArticleCatService::getList($v1['id']);
            if ($k1>0){
                $cat_list =  array_merge($cat_list[$k1-1],$cat_list[$k1]);
            }
        }

        foreach ($cat_list as $k2=>$v2){
            $cat_list[$k2]['_child'] = \App\Services\ArticleService::getList(['cat_id'=>$v2['id']]);
        }
        if (!empty($cat_list)){
            return $cat_list;
        } else {
            return [];
        }
    }
}

if (!function_exists('getNewsSidebar')){
    function getNewsSidebar(){
        $cat = \App\Services\ArticleCatService::getList(2); // 新闻中心的cat_id 为2 数据库修改之后要修改这里
        // 热门
        $hot_news = \App\Services\ArticleService::getTopClick(1,6);
        $data =[
            'cat'=>$cat,
            'hot_news'=>$hot_news['list']
        ];
        return $data;
    }
}

//最新资讯
if (!function_exists('getLatestNews')){
    function getLatestNews(){
        $data = \App\Services\ArticleCatService::getLatestNews(); // 新闻中心的cat_id 为2 数据库修改之后要修改这里
        return $data;
    }
}

if (!function_exists('getHotSearch')){
    function getHotSearch(){
        return \App\Services\HotSearchService::getList([],['is_show'=>1]);
    }
}

if (!function_exists('getOrderFromText')){
    function getOrderFromText($code){
        $res = '购物车下单';
        switch ($code){
            case 'promote' : $res = '限时抢购活动';
                break;
            case 'wholesale' : $res = '集采火拼活动';
                break;
            case 'consign' : $res = '清仓特卖活动';
                break;
            default:

        }
        return $res;
    }
}

if(!function_exists('getSeoInfoByType')){
    function getSeoInfoByType($type){
        $res = \App\Services\SeoService::getInfoByType($type);
        if($res){
            if(empty($res['title'])){
                $res['title'] = getConfig('shop_title');
            }
            if(empty($res['keywords'])){
                $res['keywords'] = getConfig('shop_keywords');
            }
            if(empty($res['description'])){
                $res['description'] = getConfig('shop_desc');
            }
            return $res;
        }
        return [
            'title'=>getConfig('shop_title'),
            'keywords'=>getConfig('shop_keywords'),
            'description'=>getConfig('shop_desc')
        ];
    }
}
if(!function_exists('createPage')){
    function  createPage($url,$currentPage, $totalPage, $delta = 2, $target = '_self'){

        $high = $currentPage + $delta;
        $low = $currentPage - $delta;
        if ($high > $totalPage) {
            $high = $totalPage;
            $low = $totalPage - 2 * $delta;
        }
        if ($low < 1) {
            $low = 1;
            $high = $low + 2 * $delta;
            if($high > $totalPage) $high = $totalPage;
        }
        $ret_string ='<div class="news_pages"><ul class="pagination">';
        if($currentPage > 1)
        {
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', 1, $url). "' target='{$target}'>首页</a></li>";
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', $currentPage - 1, $url) . "' target='{$target}'>上一页</a></li>";
        }else {
            $ret_string .= '<li><a class="" style="color: #ccc">首页</a></li>';
            $ret_string .= '<li><a class="" style="color: #ccc">上一页</a></li>';
        }
        $links = array();
        for (;$low <= $high; $low++)
        {
            if($low != $currentPage) $links[] = '<li><a style="cursor:pointer" href=\'' . str_replace('%d', $low, $url) . '\' target=\'' . $target . '\'>' . $low . '</a></li>';
            else $links[] = "<li><a class='active' >{$low}</a>";
        }
        $links = implode('', $links);
        $ret_string .= "\r\n" . $links;
        if($currentPage < $totalPage){
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', $currentPage + 1, $url) . "' target='{$target}'>下一页</a></li>";
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', $totalPage, $url) . '\' target=\'' . $target . '\'>尾页</a></li>';
        }else{
            $ret_string .= '<li><a class="" style="color: #ccc">下一页</a></li>';
            $ret_string .= '<li><a class="" style="color: #ccc">尾页</a></li>';
        }
        return $ret_string . '</ul></div>';
    }
}
if(!function_exists('object_array')) {
    function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
}
if(!function_exists('getFromInfo')){
    function getFromInfo($key){
        $info = [
            '1'=>'web',
            '2'=>'seller',
            '3'=>'admin',
        ];
        return $info[$key];
    }
}


