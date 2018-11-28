<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Services\UserAddressService;
use App\Services\UserRealService;
use App\Services\UserAccountLogService;
use App\Services\RegionService;
class UserController extends ApiController
{
    //账号信息
    public function detail(Request $request)
    {
        $id = $this->getUserID($request);
        //查询用户信息和实名信息
        $user = UserService::getApiUserInfo($id);
        return $this->success($user,'success');
    }

    //收货地址详情
    public function detailAddress(Request $request){
        $id = $request->input('address_id','');
        $is_default = $request->input('is_default','');
        if ($id){
            $address_info = UserAddressService::getAddressInfo($id);
        } else {
            $address_info = [];
        }
        return $this->success(['data'=>$address_info,'is_default'=>$is_default],'success');
    }

    //修改默认地址
    public function updateDefaultAddress(Request $request)
    {
        $address_id = $request->input('address_id','');
        if (empty($address_id)){
            return $this->error('参数错误');
        }
        $userInfo  = $this->getUserInfo($request);
        $data = [
            'id'=>$userInfo['id'],
            'address_id' =>$address_id
        ];
        $user_address = UserAddressService::getInfoByConditions(['id'=>$address_id,'user_id'=>$userInfo['id']]);
        if(empty($user_address)){
            return $this->error('该地址不存在');
        }

        $re = UserService::updateDefaultAddress($data);
        if ($re){
            Cache::forget('_api_user_'.$userInfo['id']);
            return $this->success('','修改成功');
        } else {
            return $this->error('修改失败');
        }
    }

    //收货地址列表
    public function addressList(Request $request)
    {
        $user_info = $this->getUserInfo($request);
        $condition = [];
        $condition['user_id'] = $user_info['id'];
        $addressList = UserService::shopAddressList($condition);
        foreach ($addressList as $k=>$v){
            $addressList[$k] = UserAddressService::getAddressInfo($v['id']);
            if ($v['id'] == $user_info['address_id']){
                $addressList[$k]['is_default'] =1;
                $first_one[$k] = $addressList[$k];
            } else {
                $addressList[$k]['is_default'] ='';
            };
        }
        if(!empty($first_one)) {
            foreach ($first_one as $k1 => $v1){
                unset($addressList[$k1]);
                array_unshift($addressList, $first_one[$k1]);
            }
        }
        return $this->success(compact('addressList'),'success');
    }

    //添加收货地址
    public function addAddress(Request $request)
    {
        $id =$request->input('address_id','');//编辑传入
        $user_id = $this->getUserID($request);
        $str_address = $request->input('str_address','');
        $address = $request->input('address','');//详细地址
        $zipcode = $request->input('zipcode','');//邮编
        $consignee = $request->input('consignee','');//收货人
        $mobile_phone = $request->input('mobile','');//手机地址
        $default = $request->input('default_address','');//是否默认

        if (empty($str_address)){
            return $this->error('请选择地址');
        }
        if (empty($address)){
            return $this->error('请输入详细地址');
        }
       /* if (empty($zipcode)){
            return $this->error('请输入邮政编码');
        }*/
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
            'country' => 1,
            'province' => $address_ids[0],
            'city' => $address_ids[1],
            'district' => $address_ids[2],
            'address' => $address,
            'zipcode' => $zipcode,
            'mobile_phone' => $mobile_phone
        ];
        //dd($data);
        try{
            if ($id){
                $res = UserService::updateShopAdderss($id,$data);
                if(!empty($default) && $default == 'Y'){//设为默认地址
                    $data = [
                        'id'=>$user_id,
                        'address_id' =>$id
                    ];
                    Cache::forget('_api_user_'.$user_id);
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
                return $this->success($re,'添加收获地址成功');
            }
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除收货地址
    public function deleteAddress(Request $request)
    {
        $id = $request->input('id','');
        if (empty($id)){
            return $this->error('参数错误');
        }
        $re = UserAddressService::delete($id);

        if ($re){
            return $this->success('删除成功');
        } else {
            return $this->error('删除失败');
        }
    }

    //修改昵称
    public function editNickname(Request $request)
    {
        $user_id = $this->getUserID($request);
        $nick_name = $request->input('nick_name');
        if(empty($nick_name)){
            return $this->error('昵称不能为空');
        }
        try{
            UserService::modify($user_id,['nick_name'=>$nick_name]);
            //清楚缓存
            Cache::forget('_api_user_'.$user_id);
            return $this->success('','success');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //查看个人关注信息(收藏)
    public function myCollection(Request $request)
    {
        $user_id = $this->getUserID($request);
        $currpage = $request->input('currpage',1);
        $pagesize = $request->input('pageSize', 10);
        $rs_list =UserService::userCollectGoodsList($user_id,$currpage,$pagesize);
        $data = [
            'draw' => $request->input('draw'), //浏览器cache的编号，递增不可重复
            'currpage'=>$currpage,
            'pageSize' => $pagesize, //每页显示的条数
            'total' => $rs_list['total'], //数据总行数
            'data' => $rs_list['list'],
        ];
        return $this->success($data,'success');
    }

    //添加收藏
    public function addCollection(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $userId = $this->getUserID($request);
        if(empty($goods_id)){
            return $this->error('商品id不能为空');
        }
        try{
            UserService::addCollectGoods($goods_id,$userId);
            return $this->success('','success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除收藏
    public function delCollection(Request $request)
    {
        $id = $request->input('id');
        try{
            UserService::delCollectGoods($id);
            return $this->success('','success');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //注销账号
    public function accountLogout(Request $request)
    {
        $uuid = $request->input('token');
        $userInfo = $this->getUserInfo($request);
        //检测用户是否已经企业认证
        $realInfo = UserRealService::getInfoByUserId($userInfo['id']);
        //已经实名认证的企业用户不能注销账号
        if($realInfo && $realInfo['review_status'] == 1 && $realInfo['is_firm'] == 1){
            return $this->error('已经实名认证的企业用户不能注销账号');
        }
        $user_data = [
            'user_name'=>$userInfo['user_name'].'_'.time().'_logout',
            'is_freeze'=>1
        ];
        $res = UserService::modify($userInfo['id'],$user_data);
        if($res){
            Cache::forget($uuid);
            Cache::forget('_api_user_'.$userInfo['id']);
            Cache::forget('_api_deputy_user_'.$userInfo['id']);
            return $this->success('注销成功！');
        }else{
            return $this->error('注销失败！请联系管理员。');
        }
    }

    //查看积分
    public function viewPoint(Request $request)
    {
        $user_id = $this->getUserID($request);
        $condition['user_id']=$user_id;
        $pageSize = $request->input('pagesize',10);
        $currpage = $request->input("currpage",1);
        //积分列表
        $user_account_logs = UserAccountLogService::getInfoByUserId(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['change_time'=>'desc']],$condition);
        return $this->success([
            'user_account_logs'=>$user_account_logs['list'],
            'total'=>$user_account_logs['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'totalPoints'=>$this->getUserInfo($request)['points']
        ],'success');
    }

    //实名信息
    public function viewRealInfo(Request $request)
    {
        $user_id = $this->getUserID($request);
        $user_name = $this->getUserInfo($request)['user_name'];
        $is_firm = $this->getUserInfo($request)['is_firm'];
        $user_real = UserRealService::getInfoByUserId($user_id);
        if(empty($user_real)){
            return $this->error('没有实名信息');
        }else{
            return $this->success([
                'user_name'=>$user_name,
                'is_firm'=>$is_firm,
                'user_real'=>$user_real,
                'user_id'=>$user_id
            ],'json');
        }
    }

    //保存实名信息
    public function saveUserReal(Request $request)
    {
        $user_id = $this->getUserID($request);
        $data = $request->all();
        //is_self 1是个人提交  2是企业
        $is_self = $request->input('is_self');
        $dataArr = $data['jsonData'];
        if($is_self == 1){
            if(empty($dataArr['real_name'])){
                return $this->error('请输入真实姓名');
            }
            if(empty($dataArr['front_of_id_card'])){
                return $this->error('请上传身份证正面');
            }
            if(empty($dataArr['reverse_of_id_card'])){
                return $this->error('请上传身份证反面');
            }
        }elseif($is_self == 2){
            if(empty($dataArr['real_name_firm'])){
                return $this->error("请输入企业全称");
            }

            if(empty($dataArr['attorney_letter_fileImg'])){
                return $this->error("请上传授权电子版");
            }

            if(empty($dataArr['invoice_fileImg'])){
                return $this->error("请上传开票电子版");
            }

            if(empty($dataArr['license_fileImg'])){
                return $this->error("请输入营业执照电子版");
            }
        }else{
            return $this->error('非法操作');
        }

        try{
            $flag = UserRealService::saveUserReal($dataArr,$is_self,$user_id);
            if($flag){
                return $this->success("","保存成功");
            }
            return $this->error("保存失败");
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //我要卖货
    public function sale(Request $request)
    {
        $userInfo = $this->getUserInfo($request);
        $saleData['user_id'] = $userInfo['id'];
        $saleData['user_name'] = $userInfo['user_name'];
        $saleData['content'] = $request->input('content');
        $saleData['bill_file'] = $request->input('bill_file');
        if(empty($saleData['content'])){
            return $this->error('需求内容不能为空');
        }
        try{
            UserService::sale($saleData);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }



}