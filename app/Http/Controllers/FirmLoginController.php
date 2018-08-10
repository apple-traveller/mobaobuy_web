<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\FirmLoginService;


class FirmLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    //公司注册
    public function firmRegister(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.firm.register');
        }else{
            $rule = [
                'firm_name'=>'required',
                'user_name'=>'required|regex:/^1[34578][0-9]{9}$/|unique:firm',
                'password'=>'required|confirmed|min:6',
                'contactPhone'=>'required|min:11|numeric',
                'contactName'=>'required'
            ];
            $data = $this->validate($request,$rule);
            $data['attorney_letter_fileImg'] = $request->file('attorney_letter_fileImg');
            try{
                 FirmLoginService::firmRegister($data);
                return $this->success('注册成功，正在进入系统...',  $this->redirectTo);
            } catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }

    }
}
