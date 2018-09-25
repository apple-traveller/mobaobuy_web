<?php

namespace App\Http\Controllers\Web;
use App\Services\UserInvoicesService;
use App\Services\UserLoginService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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

    //显示用户收获地
    public function shopAddressList(){
        $userId = session('_web_info')['id'];
        $condition = [];
        $condition['user_id'] = $userId;
        $addressInfo = UserService::shopAddressList($condition);
        return $this->display('web.user.userAddress',compact('addressInfo'));
    }

    //新增收获地址
    public function addShopAddress(Request $request){
        if($request->isMethod('post')){
            $message = [
                'required' => ':attribute 不能为空'
            ];
            $attributes = [
                'address_name'=>'地址别名',
                'consignee'=>'收货人',
                'country'=>'国家',
                'province'=>'省',
                'city'=>'市',
                'district'=>'县',
                'street'=>'街道',
                'address'=>'详细地址',
                'zipcode'=>'邮编',
                'mobile_phone'=>'手机'
            ];
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
            $data = $this->validate($request,$rule,$message,$attributes);
            try{
                UserService::addShopAddress($data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }else{
            $region_type = 1;
            $addressInfo = UserService::provinceInfo($region_type);
            return $this->display('web.user.createAddress',compact('addressInfo'));
        }
    }

    //通过省获取市区
    public function getCity(Request $request){
        $regionId = $request->input('region_id');
        try{
            $cityInfo = UserService::getCity($regionId);
            return json_encode(array('status'=>1,'info'=>$cityInfo));
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
        if($request->isMethod('get')){
            return $this->display('web.user.createInvoices');
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
            $data['user_id'] = session('_web_info')['id'];
            try{
                UserInvoicesService::create($data);
                return json_encode(array('status'=>1));
                return $this->success('保存成功',$this->redirectTo);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
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
        return $this->display('web.user.userInvoices',compact('invoicesInfo'));
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
            return $this->display('web.user.forgotPwd');
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
