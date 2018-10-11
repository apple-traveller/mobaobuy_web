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
        $prefix = strstr($view, '.', TRUE);
        if($prefix && in_array($prefix, ['admin','web','seller'])){
            return view(themePath('.', $prefix).$view, $data, $mergeData);
        }
        return view(themePath('.').$view, $data, $mergeData);
    }

    protected function success($msg = '', $url = '', $data = '', $wait = 3, array $header = [])
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
            if($wait == 0){
                return $this->redirect($url);
            }else{
                return response()->view(themePath('.').'jump', $result, 200)->withHeaders($header);
            }
        }else{
            return response()->json($result)->withHeaders($header);
        }
    }

    protected function error($msg = '', $url = '', $data = '', $wait = 3, array $header = [])
    {
        $type = $this->getResponseType();
        if(empty($url) && 'html' == strtolower($type)){
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

    protected function result($data, $code = 0, $msg = '', array $header = [])
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
        return response()->json($result)->withHeaders($header);
    }

    protected function jsonResult($data, array $header = [])
    {
        return response()->json($data)->withHeaders($header);
    }

    protected function redirect($url, $params = [], $code = 302, $with = [])
    {
        return redirect($url)->with($params);
    }

    protected function getResponseType()
    {
        $request = request();
        if ($request->ajax() || $request->wantsJson()){
            return 'json';
        }
        return 'html';
    }
}
