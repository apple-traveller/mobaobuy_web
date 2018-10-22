<?php
namespace App\Http\Controllers\Web;

use App\Services\FirmUserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class FirmUserController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    public function search($username){
        $userInfo = FirmUserService::search($username);
        return $this->display('web',compact('userInfo'));
    }

    //新增企业会员
    public function createFirmUser(Request $request){
        $user = session('_web_user');
        if(!$user['is_firm']){
            return $this->error('个人会并无此功能！');
        }
        if($request->isMethod('get')){
            $firmUserInfo = FirmUserService::firmUserList($user['id']);
            return $this->display('web.user.emp.firmUserList',compact('firmUserInfo'));
        }else{
//            $rule = [
//                'firm_id'=>'required|numeric',
//                'user_id'=>'required|numeric',
//                'real_name'=>'required|max:30',
//                'can_po'=>'required|numeric',
//                'can_pay'=>'required|numeric ',
//                'can_confirm'=>'required|numeric',
//                'can_stock_in'=>'required|numeric',
//                'can_stock_out'=>'required|numeric'
//            ];

         $userName = $request->input('user_name');
         $firmId = session('_web_user_id')['id'];
            try{
                $userInfo = FirmUserService::search($firmId,$userName);
                return json_encode(array('code'=>1,'info'=>$userInfo));
            }catch (\Exception $e){
                return json_encode(array('code'=>0,'info'=>$e->getMessage()));
            }

        }
    }

    //绑定企业会员和权限
    public function addFirmUser(Request $request){
        $firmId = session('_web_user_id');
        $userName = $request->input('user_name');
        $phone = $request->input('phone');
        $permi = $request->input('permi');
        try{
            FirmUserService::addFirmUser($firmId,$phone,$permi,$userName);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //更新权限信息
    public function updateFirmUser(Request $request){
        $rule = [
            'firm_id'=>'required|numeric',
            'user_id'=>'required|numeric',
            'real_name'=>'required|max:30',
            'can_po'=>'required|numeric',
            'can_pay'=>'required|numeric ',
            'can_confirm'=>'required|numeric',
            'can_stock_in'=>'required|numeric',
            'can_stock_out'=>'required|numeric'
        ];
        $data = $this->validate($request,$rule);
        try{
            FirmUserService::update($data);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function destroy($id){

    }

    //权限审批属性设置页面
    public function Approval(){
        $userId = session('_web_user_id');
        $approvalInfo = FirmUserService::Approval($userId);
        return $this->display('web.user.emp.authList',compact('approvalInfo'));
    }

    //编辑企业会员弹层获取数据
    public function editFirmUser(Request $request){
        $id = $request->input('id');
        try{
            $firmUserInfo = FirmUserService::editFirmUser($id);
            return $this->success('','',$firmUserInfo);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }

    //审核设置 下单是否需要审批
    public function OrderNeedApproval(Request $request){
        $userId = session('_web_user_id');
        $approvalId = $request->input('approvalId');
        try{
            $approvalInfo = FirmUserService::OrderNeedApproval($userId,$approvalId);
            if($approvalInfo){
                return $this->success();
            }
            return $this->error();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }
}
