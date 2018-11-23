<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class WebClosed extends Controller
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(getConfig('shop_closed') == '1'){
            print_r(getConfig('close_comment'));
            die();
        }

        if(!empty(session('_web_user_id'))){
            //缓存用户的基本信息
//            if(!session()->has('_web_user')){
                $user_info = UserService::getInfo(session('_web_user_id'));

                //is_logout为企业的id
                if($user_info['is_logout']){
//                    session()->flush();
//                    return $this->error('权限已被更改，请重新登陆','/login');
//                    $res = array('code' => 200,'msg' => '权限已被更改，请重新登陆');
//                    return response()->json($res);

                    if($user_info['is_firm'] == 0 && session('_curr_deputy_user')['is_self'] == 0){
                        //获取用户所代表的公司
                        //firms是firmuser表信息 加企业名称和addressid
                        $firms = UserService::getUserFirms(session('_web_user_id'));
                        foreach ($firms as $firm){
                            if($user_info['is_logout'] == $firm['firm_id']){
                                //修改代表信息
                                $firm['is_self'] = 0;
                                $firm['is_firm'] = 1;
                                $firm['firm_id'] = $firm['firm_id'];
                                $firm['name'] = $firm['firm_name'];
                                $firm['address_id'] = $firm['address_id'];
                                session()->put('_curr_deputy_user', $firm);

                            }
                        }
                    }
                }
                if(!$user_info['is_firm']){
                    $user_info['firms'] = UserService::getUserFirms(session('_web_user_id'));
                }

                session()->put('_web_user', $user_info);
//            }

            if(!session()->has('_curr_deputy_user')){
                $info = [
                    'is_self' => 1,
                    'is_firm' => session('_web_user')['is_firm'],
                    'firm_id'=> session('_web_user_id'),
                    'name' => session('_web_user')['nick_name'],
                    'address_id' => session('_web_user')['address_id']
                ];

                session()->put('_curr_deputy_user', $info);
            }

            //缓存模板信息
            if(!session()->has('web_theme')){
                session()->put('web_theme', getConfig('template','default'));
            }
        }

        return $next($request);
    }
}
