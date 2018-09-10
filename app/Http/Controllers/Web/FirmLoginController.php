<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Services\FirmLoginService;
use App\Http\Controllers\Controller;


class FirmLoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public function __construct()
    {
        session()->put('theme','default');
    }

    //公司注册
    public function firmRegister(Request $request){
        if($request->isMethod('get')){
            return $this->display('web.firm.register');
        }else{
            $rule = [
                'firm_name'=>'required',
                'user_name'=>'required|regex:/^1[34578][0-9]{9}$/|unique:firm|unique:user',
                'password'=>'required|confirmed|min:6',
                'contactPhone'=>'required|min:11|numeric',
                'contactName'=>'required',
                'attorney_letter_fileImg'=>'file'
            ];
            $data = $this->validate($request,$rule);
            $data['attorney_letter_fileImg'] = $request->file('attorney_letter_fileImg');
            try{
                 $result = FirmLoginService::firmRegister($data);
                 if($result == 'error'){
                     return $this->error('注册失败');
                 }else{
                     return $this->success('注册成功，正在进入系统...',  $this->redirectTo);
                 }
            } catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }

    }
}
