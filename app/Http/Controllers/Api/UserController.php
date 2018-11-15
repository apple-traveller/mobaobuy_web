<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
class UserController extends ApiController
{
    //账号信息
    public function detail(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return $this->error('请传入用户id');
        }
        //查询用户信息和实名信息
        $user = UserService::getApiUserInfo($id);
        return $this->success($user,'success');
    }

    //添加收货地址
    public function addAddress(Request $request)
    {
        $id =$request->input('id','');//编辑传入
        $user_id = $this->getUserID($request);
        $str_address = $request->input('str_address','');
        $address = $request->input('address','');//详细地址
        $zipcode = $request->input('zipcode','');//邮编
        $consignee = $request->input('consignee','');//收货人
        $mobile_phone = $request->input('mobile','');//手机地址
        $default = $request->input('default_address','');

        if (empty($str_address)){
            return $this->error('请选择地址');
        }
        if (empty($address)){
            return $this->error('请输入详细地址');
        }
        if (empty($zipcode)){
            return $this->error('请输入邮政编码');
        }
        if (empty($consignee)){
            return $this->error('请填写收货人');
        }
        if (empty($mobile_phone)){
            return $this->error('请填写收货电话');
        }
        $address_ids = explode('|',$str_address);
        $data = [
            'user_id' => $user_id,
            'consignee' => $consignee,
            'country' => $address_ids[0],
            'province' => $address_ids[1],
            'city' => $address_ids[2],
            'district' => $address_ids[3],
            'address' => $address,
            'zipcode' => $zipcode,
            'mobile_phone' => $mobile_phone
        ];
        try{
            if ($id){
                $res = UserService::updateShopAdderss($id,$data);
                if(!empty($default) && $default == 'Y'){//设为默认地址
                    $data = [
                        'id'=>$user_id,
                        'address_id' =>$id
                    ];
                    session()->forget('_web_user');
                    UserService::updateDefaultAddress($data);
                }
                return $this->success('修改成功');
            }else{
                $re =  UserService::addShopAddress($data);
                if(!empty($default) && $default == 'Y'){//设为默认地址
                    $data = [
                        'id'=>$user_id,
                        'address_id' =>$re['id']
                    ];
                    Cache::forget('_api_user_'.$user_id);
                    UserService::updateDefaultAddress($data);
                }
                return $this->success('','添加收获地址成功');
            }
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}