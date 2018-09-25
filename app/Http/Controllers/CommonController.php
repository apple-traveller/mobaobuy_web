<?php

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    public function route($path){
        print_r('路由地址不存在！');
        abort(404);
        //return redirect()->action('Web\UserLoginController@firmRegister');
    }
}
