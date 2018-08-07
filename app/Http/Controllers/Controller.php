<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function display($view, $data = [], $mergeData = []){
        return view(themePath('.').$view, $data, $mergeData);
    }
    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed     $msg 提示信息
     * @param string    $url 跳转的URL地址
     * @param mixed     $data 返回的数据
     * @param integer   $wait 跳转等待时间
     * @param array     $header 发送的Header信息
     * @return void
     */
    protected function success($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ('html' == strtolower($type)) {
            return response()->view(themePath('.').'jump', $result, 200)->withHeaders($header);
        }else{
            return response()->json($result)->withHeaders($header);
        }
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed     $msg 提示信息
     * @param string    $url 跳转的URL地址
     * @param mixed     $data 返回的数据
     * @param integer   $wait 跳转等待时间
     * @param array     $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        $type = $this->getResponseType();
        if(is_null($url) && 'html' == strtolower($type)){
            $url = 'javascript:history.back(-1);';
        }
        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if ('html' == strtolower($type)) {
            return response()->view(themePath('.').'jump', $result, 200)
                ->withHeaders($header);
        }else{
            return response()->json($result)->withHeaders($header);
        }
    }

    /**
     * 返回封装后的API数据到客户端
     * @access protected
     * @param mixed     $data 要返回的数据
     * @param integer   $code 返回的code
     * @param mixed     $msg 提示信息
     * @param array     $header 发送的Header信息
     * @return void
     */
    protected function result($data, $code = 0, $msg = '', array $header = [])
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
        return response()->json($result)->withHeaders($header);
    }

    /**
     * 返回封装后的API数据到客户端
     * @access protected
     * @param mixed     $data 要返回的数据
     * @param integer   $code 返回的code
     * @param mixed     $msg 提示信息
     * @param array     $header 发送的Header信息
     * @return void
     */
    protected function jsonResult($data, array $header = [])
    {
        return response()->json($data)->withHeaders($header);
    }

    /**
     * URL重定向
     * @access protected
     * @param string         $url 跳转的URL表达式
     * @param array|integer  $params 其它URL参数
     * @param integer        $code http code
     * @param array          $with 隐式传参
     * @return void
     */
    protected function redirect($url, $params = [], $code = 302, $with = [])
    {
        return redirect($url)->with($params);
    }

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        $request = request();
        if ($request->ajax() || $request->wantsJson()){
            return 'json';
        }
        return 'html';
    }
}
