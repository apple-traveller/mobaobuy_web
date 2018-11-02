<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-27
 * Time: 15:07
 */
namespace App\Helpers;
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
