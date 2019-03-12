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
/*获取所有特殊规格的商品*/
if(!function_exists('getSpecialGoods')){
    function getSpecialGoods(){
        $rs = [];
        $value = \App\Services\GoodsService::getSpecialGoods();
        foreach ($value['list'] as $k=>$v){
            $top_cat = getTopCatByCatId($v['cat_id']);
            $rs[$top_cat['top_id']]['goods'][] = $v;
            //$value['list'][$k]['cat_top_id'] = getTopCatByCatId($v['cat_id']);
        }
        return $rs;
    }
}
/*根据商品id获取这个商品顶级分类id、名称*/
if(!function_exists('getTopCatByCatId')){
    function getTopCatByCatId($cat_id){
        $value = \App\Services\GoodsCategoryService::getTopCatByCatId($cat_id);
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
            $list = \App\Services\ArticleCatService::getList($v1['id']);
            $cat_list =  array_merge($cat_list,$list);
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
    function  createPage($url,$currentPage, $totalPage, $delta = 2, $target = '_self',$lang=[]){

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
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', 1, $url). "' target='{$target}'>{$lang['sFirst']}</a></li>";
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', $currentPage - 1, $url) . "' target='{$target}'>{$lang['sPrevious']}</a></li>";
        }else {
            $ret_string .= '<li><a class="" style="color: #ccc">'.$lang["sFirst"].'</a></li>';
            $ret_string .= '<li><a class="" style="color: #ccc">'.$lang['sPrevious'].'</a></li>';
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
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', $currentPage + 1, $url) . "' target='{$target}'>{$lang['sNext']}</a></li>";
            $ret_string .= '<li><a style="cursor:pointer" href=\'' . str_replace('%d', $totalPage, $url) . '\' target=\'' . $target . '\'>'.$lang['sLast'].'</a></li>';
        }else{
            $ret_string .= '<li><a class="" style="color: #ccc">'.$lang['sNext'].'</a></li>';
            $ret_string .= '<li><a class="" style="color: #ccc">'.$lang['sLast'].'</a></li>';
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
if(!function_exists('isIncludeHttp')){
    function isIncludeHttp($value){
        $link = substr($value,0,4);
        if($link == 'http'){
            return $value;
        }else{
            $value = '//'.$value;
            return $value;
        }
    }
}
if(!function_exists('getInvoiceSn')){
    function getInvoiceSn(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $invoice_numbers = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $invoice_numbers;
    }
}

if(!function_exists('getLangData')){
    function getLangData($data,$field){
        $key = App::getLocale();
        if($key == 'zh-CN'){
            return $data[$field];
        }
        return isset($data[$field.'_'.App::getLocale()]) && !empty($data[$field.'_'.App::getLocale()]) ? $data[$field.'_'.App::getLocale()] : $data[$field];
    }
}

if(!function_exists('getLangGoodsSource')){
    function getLangGoodsSource($goods_source){
        $key = App::getLocale();
        if($key == 'zh-CN'){
            switch($goods_source){
                case 0:$res = '现货';break;
                case 1:$res = '紧张';break;
                case 2:$res = '厂家直发';break;
                case 3:$res = '少量';break;
                default:$res = '现货';
            }
        }else{
            switch($goods_source){
                case 0:$res = 'spot goods';break;
                case 1:$res = 'Tight supply';break;
                case 2:$res = 'Straight hair';break;
                case 3:$res = 'A few';break;
                default:$res = 'spot goods';
            }
        }
        return $res;
    }
}

if(!function_exists('isMobile')){
    function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
}
//验证用户是否绑定过微信
if(!function_exists('checkNameIsBindWx')){
    function checkNameIsBindWx($name){
        #获取用户id
        $userInfo = \App\Repositories\UserRepo::getInfoByFields(['user_name'=>$name]);
        #检查user_id是否绑定过wx
        if(\App\Repositories\AppUsersRepo::getTotalCount(['user_id'=>$userInfo['id']])){
            return true;
        }
        return false;
    }
}


