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
            $shop = $request->input('shop_name','');
            $company_name = $request->input('company_name','');
            $attorney_letter_fileImg = $request->input('attorney_letter_fileImg','');
            $business_license_id = $request->input('business_license_id','');
            $license_fileImg = $request->input('license_fileImg','');
            $taxpayer_id = $request->input('taxpayer_id','');
            $is_self_run = $request->input('is_self_run','0');
            $user_name = $request->input('user_name','');
            $password = $request->input('password','');
            $password_confirmation = $request->input('password_confirmation','');
            $mobile= $request->input('mobile','');
            $mobile_code = $request->input('mobile_code','');
            $protocol = $request->input('protocol','');

            if (empty($protocol)){
                $errorMsg[] = '未同意协议';
            }

            if (empty($shop)){
                $errorMsg[] ='店铺名称不能为空';
            }

            if (empty($company_name)){
                $errorMsg[] ='企业名称不能为空';
            }

            if (empty($attorney_letter_fileImg)){
                $errorMsg[] ='授权委托书电子版不能为空';
            }

            if (empty($business_license_id)){
                $errorMsg[] ='营业执照注册号不能为空';
            }
            if (empty($license_fileImg)){
                $errorMsg[] ='营业执照副本电子版不能为空';
            }
            if (empty($taxpayer_id)){
                $errorMsg[] ='纳税人识别号';
            }
            if (empty($user_name)){
                $errorMsg[] ='用户名称不能为空';
            }
            if (empty($password)){
                $errorMsg[] ='密码不能为空';
            }
            if ($password!=$password_confirmation){
                $errorMsg[] = "两次密码不能一样";
            }
            if (empty($mobile)){
                $errorMsg[] ='手机号不能为空';
            }
            if (empty($mobile_code)){
                $errorMsg[] ='店铺名称不能为空';
            }

            if (!empty($errorMsg))
            {
                return $this->error(implode('<br/>,',$errorMsg));
            }
            $data = [
                'shop_name',
                'company_name',
                'attorney_letter_fileImg',
                'business_license_id',
                'license_fileImg',
                'taxpayer_id',
                'is_self_run',
                'password',
                'mobile',
                'mobile_code',
                'protocol'
            ];
            try{
               $re = ShopLoginService::Register($data);

               dd($re);
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
