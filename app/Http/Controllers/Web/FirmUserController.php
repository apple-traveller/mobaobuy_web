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
        if($request->isMethod('get')){
            return $this->display('web.firm.createFirmUser');
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
         $firmId = session('_web_info')['id'];
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
        $userId = $request->input('user_id');
        $userName = $request->input('user_name');
        if(!$firmId || !$userId){
            return json_encode(array('code'=>0,'msg'=>'企业和用户id为空'));
        }
        $permi = $request->input('permi');
        //$permi数组1能采购 2能付款 3能收货 4能其它入库 5能库存出库

        try{
            $firmInfo = FirmUserService::create($firmId,$userId,$permi,$userName);
            return json_encode(array('code'=>1,'msg'=>$firmInfo));
        }catch (\Exception $e){
            return json_encode(array('code'=>0,'msg'=>$e->getMessage()));
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

    public function firmUserAuthList(){
        $userInfo = session('_web_user');
        $firmId = session('_web_user_id');
        $firmUser = FirmUserService::firmUserList($firmId);
        return $this->display('web.firm.firmUserAuth',compact('userInfo','firmUser'));
    }
}
