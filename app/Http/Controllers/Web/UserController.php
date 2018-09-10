<?php

namespace App\Http\Controllers\Web;
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

    //新增收获地址
    public function addShopAddress(Request $request){
        if($request->isMethod('post')){
            $rule = [
                'address_name'=>'required',
                'user_id'=>'required',
                'firm_id'=>'required',
                'consignee'=>'required',
                'country'=>'required',
                'province'=>'required',
                'city'=>'required',
                'district'=>'required',
                'street'=>'required',
                'address'=>'required',
                'zipcode'=>'required',
                'tel'=>'required',
                'mobile'=>'required|numeric'
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
    public function updateShopAddress(Request $request){
        if($request->isMethod('post')){
            $rule = [
                'address_name'=>'required',
                'user_id'=>'required|numeric',
                'firm_id'=>'required|numeric',
                'consignee'=>'required',
                'country'=>'required',
                'province'=>'required',
                'city'=>'required',
                'district'=>'required',
                'street'=>'required',
                'address'=>'required',
                'zipcode'=>'required',
                'tel'=>'required',
                'mobile'=>'required|numeric'
            ];
            $data = $this->validate($request,$rule);
            try{
                UserService::updateShopAdderss($data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }

        }else{
            return $this->display('web');
        }

    }
}
