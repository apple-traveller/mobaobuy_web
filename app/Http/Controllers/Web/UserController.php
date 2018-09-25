<?php

namespace App\Http\Controllers\Web;

use App\Services\UserInvoicesService;
use App\Services\UserLoginService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\SmsService;


class UserController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function  index(){

    }

    //检查账号用户是否存在
    public function checkNameExists(Request $request){
        $accountName = $request->input('accountName');
        $rs = UserService::checkNameExists($accountName);

        return $this->success($rs);
    }

    //注册获取手机验证码
    public function sendSms(Request $request){
        $accountName = $request->input('accountName');

        $t = $request->input('t');
        $code = $request->input('verifyCode');
        $s_code = Cache::get(session()->getId().'captcha'.$t, '');
        if($s_code != $code){
            return $this->error('图形验证有误');
        }
        if(UserService::checkNameExists($accountName)){
            return $this->error('手机号已经注册');
        }

        $type = 'sms_signup';
        //生成的随机数
        $mobile_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::add(session()->getId().$type.$accountName, $mobile_code, 5);
        createEvent('sendSms', ['phoneNumbers'=>$accountName, 'type'=>$type, 'tempParams'=>['code'=>$mobile_code]]);

        return $this->success();
    }

    //个人用户注册
    public function userRegister(Request $request){
        if($request->isMethod('get')){

            return $this->display('web.user.register.user');
        }else{
            $accountName = $request->input('accountName', '');
            $password = base64_decode($request->input('password', ''));
            $messCode = $request->input('messCode', '');
            $type = 'sms_signup';

            //手机验证码是否正确
            if(Cache::get(session()->getId().$type.$accountName) != $messCode){
                return $this->error('手机验证码不正确');
            }

            $data=[
                'user_name' => $accountName,
                'password' => $password,
                'is_firm' => 0
            ];

            try{
                UserService::userRegister($data);
                return $this->success('注册成功','/');
            } catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
    }

    //企业用户注册
    public function firmRegister(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.user.register.firm');
        }else{
            if(session('send_code') != $request->input('mobile_code')){
                return $this->error('验证码有误');exit;
            }
            $is_firm = $request->input('is_firm');
            if($is_firm){
                //企业
                $rule = [
                    'user_name'=>'required|regex:/^1[34578][0-9]{9}$/|unique:user',
                    'password'=>'required|confirmed|min:6',
                    'nick_name'=>'required',
                    'attorney_letter_fileImg'=>'file',
                    'license_fileImg'=>'file',
                    'business_license_id'=>'required',
                    'taxpayer_id'=>'required',
                    'is_firm'=>'required|numeric',
                    'mobile_code'=>'required|numeric'
                ];
                $data = $this->validate($request,$rule);
                $data['attorney_letter_fileImg'] = $request->file('attorney_letter_fileImg');
                $data['license_fileImg'] = $request->file('license_fileImg');
            }else{
                //个人
                $rule = [
                    'user_name'=>'required|regex:/^1[34578]\d{9}$/|numeric|unique:user|min:11',
                    'password'=>'required|confirmed|min:6',
                    'is_firm'=>'required|numeric',
                    'mobile_code'=>'required|numeric',
                ];
                $data = $this->validate($request,$rule);
            }

            try{
                UserLoginService::userRegister($data);
                $request->session()->forget('send_code');
                return $this->success('注册成功','/');
            } catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }

    }

    //用户登录页面
    public function showLoginForm()
    {
        if (!empty(session('_web_user_id'))) {
            return redirect('/');
        }
        return $this->display('web.login');
    }

    //用户登录提交
    public function login(Request $request)
    {
        $username = $request->input('user_name');
        $password = base64_decode($request->input('password'));

        if(empty($username)){
            return $this->error('用户名不能为空');
        }
        if(empty($password)){
            return $this->error('密码不能为空');
        }

        $other_params = [
            'ip'  => $request->getClientIp()
        ];
        try{
            $user_id = UserService::loginValidate($username, $password, $other_params);
            session()->put('_web_user_id', $user_id);
            return $this->success('登录成功，正在进入系统...');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //登出
    public function logout()
    {
        session()->forget('_web_user_id');
        session()->forget('_web_user');

        return $this->success('退出登录成功！',  route('login'), '', 0);
    }


    //显示用户收获地
    public function shopAddressList(){
        $userId = session('_web_info');
        $condition = [];
        $condition['user_id'] = $userId;
        $addressInfo = UserService::shopAddressList($condition);
        return $this->display('web',compact('addressInfo'));
    }

    //新增收获地址
    public function addShopAddress(Request $request){
        if($request->isMethod('post')){
            $rule = [
                'address_name'=>'required',
                'user_id'=>'required',
                'consignee'=>'required',
                'country'=>'required',
                'province'=>'required',
                'city'=>'required',
                'district'=>'required',
                'street'=>'required',
                'address'=>'required',
                'zipcode'=>'required',
                'mobile_phone'=>'required',
            ];
            $data = $this->validate($request,$rule);
            try{
                UserService::addShopAddress($data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }else{
            $region_type = 1;
            UserService::provinceInfo($region_type);
            return $this->display();
        }
    }

    //通过省获取市区
    public function getCity(Request $request){
        $regionId = $request->input('region_id');
        try{
            UserService::getCity($regionId);
        }
        catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //通过市区获取县级
    public function getCounty(Request $request){
        $cityId = $request->input('cityId');
        try{
            UserService::getCounty($cityId);
        }
        catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //编辑收获地址
    public function updateShopAddress(Request $request,$id){
        if($request->isMethod('post')){
            $rule = [
                'address_name'=>'required',
                'user_id'=>'required|numeric',
                'consignee'=>'required',
                'country'=>'required',
                'province'=>'required',
                'city'=>'required',
                'district'=>'required',
                'street'=>'required',
                'address'=>'required',
                'zipcode'=>'required',
                'mobile_phone'=>'required',
            ];
            $data = $this->validate($request,$rule);
            try{
                UserService::updateShopAdderss($id,$data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }else{
            return $this->display('web.xx');
        }

    }

    //会员发票信息新增
    public function createInvoices(Request $request){
        $rule = [
            'company_name' => 'required',
            'tax_id' => 'required',
            'bank_of_deposit' =>'required',
            'bank_account' => 'required',
            'company_address' => 'required',
            'company_telephone' => 'required',
            'consignee_name' => 'required',
            'consignee_mobile_phone' =>'required',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'street' => 'required',
            'consignee_address' => 'required',
        ];
        $data = $this->validate($request,$rule);
        $data['user_id'] = session('_web_info')['id'];
        try{
            UserInvoicesService::create($data);
            return $this->success('保存成功',$this->redirectTo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //编辑用户发票信息
    public function editInvoices(Request $request,$id){
        if($request->isMethod('get')){
            return $this->display('');
        }else{
            $rule = [
                'company_name' => 'required',
                'tax_id' => 'required',
                'bank_of_deposit' =>'required',
                'bank_account' => 'required',
                'company_address' => 'required',
                'company_telephone' => 'required',
                'consignee_name' => 'required',
                'consignee_mobile_phone' =>'required',
                'country' => 'required',
                'province' => 'required',
                'city' => 'required',
                'district' => 'required',
                'street' => 'required',
                'consignee_address' => 'required',
            ];
            $data = $this->validate($request,$rule);
            $data['user_id'] = session('_web_info');
            try{
                UserInvoicesService::editInvoices($id,$data);
                return $this->success('保存成功');
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }

        }

    }

    //用户发票信息
    public function invoicesList(){
        $userId = session('_web_info')['id'];
        $condition = [];
        $condition['user_id'] = $userId;
        $invoicesInfo = UserInvoicesService::invoicesById($condition);
        return $this->display('web.xx',compact('invoicesInfo'));
    }

    //完善用户信息
    public function userUpdate(Request $request){
       if($request->isMethod('post')){
            $rule = [
                'nick_name'=>'nullable',
                'email'=>'nullable|email|unique:user',
                'real_name'=>'required',
                'sex'=>'nullable|numeric|max:1',
//                'birthday'=>'nullable|numeric',
                'avatar'=>'required|file',
                'front_of_id_card'=>'required|file',
                'reverse_of_id_card'=>'required|file'
            ];
           $data = $this->validate($request,$rule);
           $data['avatar'] = $request->file('avatar');
           $data['front_of_id_card'] = $request->file('front_of_id_card');
           $data['reverse_of_id_card'] = $request->file('reverse_of_id_card');
            try{
                UserService::updateUserInfo(session('_web_info')['id'],$data);
                return $this->success('实名信息添加成功，等待审核...','/');
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }

       }else{
//            $userInfo = UserLoginService::getInfo(session('_web_info')['id']);
            return $this->display('web.user.userUpdate');
       }
    }

    //修改密码
    public function userUpdatePwd(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.user.updatePwd');
        }else{
            $rule = [
                'password'=> 'required|min:6',
                'newPassword'=> 'required|min:6|confirmed',
                'newPassword_confirmation'=>'required|same:newPassword'

            ];
            $data = $this->validate($request,$rule);
            $id = session('_web_info')['id'];
            try{
                UserService::userUpdatePwd($id,$data);
                return $this->success('修改密码成功','/');
            }catch(\Exception $e){
                return $this->error($e->getMessage());
            }
        }
    }

    //忘记密码
    public function userForgotPwd(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.user.forgotpwd');
        }else{
            $rule = [
                'newPassword'=> 'required|min:6|confirmed',
                'newPassword_confirmation'=>'required|same:newPassword',
//                'mobile_code'=> 'required'
            ];
            $data = $this->validate($request,$rule);
            $id = session('_web_info')['id'];

            try{
                UserService::userForgotPwd($id,$data);
                return $this->success('修改密码成功','/');
            }catch(\Exception $e){
                return $this->error($e->getMessage());
            }
        }
    }

    //忘记密码获取验证码
    public function userForgotCode(Request $request){
        $mobile = session('_web_info')['user_name'];
        $type = $request->input('is_type');
        try{
            UserLoginService::sendCode($mobile,$type);
            return json_encode(array('code'=>1,'msg'=>'succ'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //发送支付密码验证码
    public function sendCodeByPay(Request $request){
        $mobile = session('_web_info')['user_name'];
        $type = $request->input('type');
        $mobile_code = rand(1000, 9999);
        session()->put('pay_send_code', $mobile_code);
        try{
            UserLoginService::sendCode($mobile,$type,$mobile_code);
            return json_encode(array('code'=>1,'msg'=>'succ'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //设置支付密码
    public function setPayPwd(Request $request){
        if($request->isMethod('get')){
            return $this->display('web');
        }else{

            $payInfo = [];
            $payInfo['password'] = $request->input('password');
            $payInfo['passwords'] = $request->input('passwords');
            $payInfo['code'] = $request->input('code');
            $payInfo['user_id'] = session('_web_info')['id'];
            if($payInfo['code'] != session('pay_send_code')){
                return $this->error('验证码错误');exit;
            }
            try{
                UserService::setPayPwd($payInfo);
                return $this->success('支付密码设置成功','/');
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }


    }

}
