<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-18
 * Time: 16:32
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ShopLoginService;
use Illuminate\Http\Request;

class ShopLoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')){
            return view('default.web.shop.login');
        } else {

        }
        dd($request->all());
    }


    public function register(Request $request)
    {
        if ($request->isMethod('get')){
            return view('default.web.shop.register');
        } else {

            $rules = [
                'shop_name',
                'company_name',
                'attorney_letter_fileImg',
                'business_license_id',
                'license_fileImg',
                'taxpayer_id',
                'user_name'=>'required|unique:shop_user',
                'password'=>'required|confirmed|min:6',
                'mobile'=>'required|regex:/^1[34578][0-9]{9}$/',
                'protocol'=>'Accepted'
            ];
            try{
                dd($request);
                $data = $this->validate($request,$rules);
                dd($data);
            }catch (\Exception $e){
                dd($e->getMessage());
            }



        }
    }

    //获取手机验证码
    public function getSmsCode(Request $request){
        $mobile = $request->input('mobile');
        $code = ShopLoginService::sendRegisterCode($mobile);
        if($code){
            echo json_encode(array('code'=>1,'msg'=>'success'));exit;
        }
        echo json_encode(array('code'=>0,'msg'=>'error'));exit;
    }
}
