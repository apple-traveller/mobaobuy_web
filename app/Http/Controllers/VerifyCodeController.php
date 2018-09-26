<?php

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VerifyCodeController extends Controller
{
    public function create(Request $request){
        $width = $request->input('width', 100);
        $height = $request->input('height', 40);
        $length = $request->input('length', 4);
        $t = $request->input('t');

        $phrase = new PhraseBuilder();
        // 设置验证码位数
        $code = $phrase->build($length);

        $builder = new CaptchaBuilder($code, $phrase);
        //可以设置图片宽高及字体
        $builder->build($width, $height, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入缓存
        Cache::add(session()->getId().'captcha'.$t, $phrase, 5);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    public function check(Request $request){
        $t = $request->input('t');
        $code = $request->input('verifyCode');
        $s_code = Cache::get(session()->getId().'captcha'.$t, '');
        if($s_code == $code){
            return $this->success(true);
        }
        return $this->success(false);
    }
}