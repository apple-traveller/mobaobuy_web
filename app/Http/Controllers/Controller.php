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
        //web.user.login
        return view(themePath('.').$view, $data, $mergeData);
    }
    /**
     * �����ɹ���ת�Ŀ�ݷ���
     * @access protected
     * @param mixed     $msg ��ʾ��Ϣ
     * @param string    $url ��ת��URL��ַ
     * @param mixed     $data ���ص�����
     * @param integer   $wait ��ת�ȴ�ʱ��
     * @param array     $header ���͵�Header��Ϣ
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
     * ����������ת�Ŀ�ݷ���
     * @access protected
     * @param mixed     $msg ��ʾ��Ϣ
     * @param string    $url ��ת��URL��ַ
     * @param mixed     $data ���ص�����
     * @param integer   $wait ��ת�ȴ�ʱ��
     * @param array     $header ���͵�Header��Ϣ
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
     * ���ط�װ���API���ݵ��ͻ���
     * @access protected
     * @param mixed     $data Ҫ���ص�����
     * @param integer   $code ���ص�code
     * @param mixed     $msg ��ʾ��Ϣ
     * @param array     $header ���͵�Header��Ϣ
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
     * ���ط�װ���API���ݵ��ͻ���
     * @access protected
     * @param mixed     $data Ҫ���ص�����
     * @param integer   $code ���ص�code
     * @param mixed     $msg ��ʾ��Ϣ
     * @param array     $header ���͵�Header��Ϣ
     * @return void
     */
    protected function jsonResult($data, array $header = [])
    {
        return response()->json($data)->withHeaders($header);
    }

    /**
     * URL�ض���
     * @access protected
     * @param string         $url ��ת��URL���ʽ
     * @param array|integer  $params ����URL����
     * @param integer        $code http code
     * @param array          $with ��ʽ����
     * @return void
     */
    protected function redirect($url, $params = [], $code = 302, $with = [])
    {
        return redirect($url)->with($params);
    }

    /**
     * ��ȡ��ǰ��response �������
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
