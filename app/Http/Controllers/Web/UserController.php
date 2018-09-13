<?php

namespace App\Http\Controllers\Web;
use App\Services\UserInvoicesService;
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

}
