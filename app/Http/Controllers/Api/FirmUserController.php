<?php
namespace App\Http\Controllers\Api;

use App\Services\FirmUserService;
use Illuminate\Http\Request;
use App\Services\UserService;
class FirmUserController extends ApiController
{
    //获取企业会员列表
    public function getList(Request $request)
    {
        $user = $this->getUserInfo($request);
        if(!$user['is_firm']){
            return $this->error('个人会员并无此功能！');
        }
        $firmUserList = FirmUserService::firmUserList($user['id']);
        return $this->success($firmUserList,'success');

    }

    //编辑企业员工(查询企业的详细信息)
    public function getDetail(Request $request){
        $id = $request->input('id');
        try{
            $firmUserInfo = FirmUserService::editFirmUser($id);
            return $this->success($firmUserInfo,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //绑定企业会员和权限(添加)
    public function addFirmUser(Request $request){
        $firmId = $this->getUserID($request);
        $userName = $request->input('user_name');
        $phone = $request->input('phone');
        $permi = $request->input('permi','');
        $permi = explode(',',$permi);
        $isEdit = $request->input('isEdit');
        if(empty($userName)){
            return $this->error('职员名称不能为空');
        }
        if(empty($phone)){
            return $this->error('职员手机号不能为空');
        }
        if(empty($permi)){
            return $this->error('权限不能为空');
        }
        try{
            FirmUserService::addFirmUser($firmId,$phone,$permi,$userName,$isEdit);
            return $this->success('','success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //检查账号用户是否已实名 根据手机号码
    public function checkRealNameBool(Request $request)
    {
        $mobile = $request->input('mobile');
        if(!$mobile){
            return $this->error('参数错误！');
        }
        $userInfo = UserService::checkNameExists($mobile);
        if(empty($userInfo)){
            return $this->error('该用户不存在！');
        }
        if($userInfo['is_firm'] == 1){
            return $this->error('企业账号不能被添加！');
        }
        $res = getRealNameBool($userInfo['id']);
        if($res){
            return $this->success('验证成功！');
        }else{
            return $this->error('该用户未实名认证！');
        }
    }

    //删除企业会员
    public function delFirmUser(Request $request){
        $id = $request->input('id');
        try{
            $flag = FirmUserService::delFirmUser($id);
            if($flag){
                return $this->success($flag,'success');
            }else{
                return $this->error('error');
            }

        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //

}
