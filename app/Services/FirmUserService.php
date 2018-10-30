<?php
namespace App\Services;
use App\Repositories\FirmUserRepo;
use App\Repositories\UserRepo;
class FirmUserService
{
    use CommonService;
    //企业用户列表
    public static function firmUserList($firmId){
        $firmUsers =  FirmUserRepo::getList([], ['firm_id'=>$firmId]);
        foreach($firmUsers as &$v){
            $userInfo = UserRepo::getInfo($v['user_id']);
            $v['phone'] = $userInfo['user_name'];
        }
        return $firmUsers;
    }

    //删除企业会员
    public static function delFirmUser($id){
        return FirmUserRepo::delete($id);
    }

    //增加企业用户
    public static function addFirmUser($firmId,$phone,$permi,$userName,$isEdit){
        //查询此手机号是否存在，
        $userInfo = UserRepo::getInfoByFields(['user_name'=>$phone, 'is_firm'=>0]);
        if(empty($userInfo)){
            self::throwBizError('手机用户不存在!');
        }
        $firmUserInfo = FirmUserRepo::getInfoByFields(['firm_id'=>$firmId,'user_id'=>$userInfo['id']]);
        $userPermi = [];
        if($isEdit){
            //编辑
            if($firmUserInfo){
                $userPermi['real_name'] = $userName;
                if(in_array(1,$permi)){
                    $userPermi['can_po'] = 1;
                }else{
                    $userPermi['can_po'] = 0;
                }

                if(in_array(2,$permi)){
                    $userPermi['can_pay'] = 1;
                }else{
                    $userPermi['can_pay'] = 0;
                }

                if(in_array(3,$permi)){
                    $userPermi['can_confirm'] = 1;
                }else{
                    $userPermi['can_confirm'] = 0;
                }

                if(in_array(4,$permi)){
                    $userPermi['can_stock_out'] = 1;
                }else{
                    $userPermi['can_stock_out'] = 0;
                }

                if(in_array(5,$permi)){
                    $userPermi['can_approval'] = 1;
                }else{
                    $userPermi['can_approval'] = 0;
                }

                if(in_array(6,$permi)){
                    $userPermi['can_invoice'] = 1;
                }else{
                    $userPermi['can_invoice'] = 0;
                }
                if(in_array(7,$permi)){
                    $userPermi['can_stock_in'] = 1;
                }else{
                    $userPermi['can_stock_in'] = 0;
                }
                if(in_array(8,$permi)){
                    $userPermi['can_stock_view'] = 1;
                }else{
                    $userPermi['can_stock_view'] = 0;
                }
                return FirmUserRepo::modify($firmUserInfo['id'],$userPermi);

            }
            self::throwBizError('用户未绑定企业');
        }else{
            //新增

            if($firmUserInfo){
                self::throwBizError('企业用户已绑定!');
            }

            $userPermi['firm_id'] = $firmId;
            $userPermi['user_id'] = $userInfo['id'];
            $userPermi['real_name'] = $userName;
            if(in_array(1,$permi)){
                $userPermi['can_po'] = 1;
            }
            if(in_array(2,$permi)){
                $userPermi['can_pay'] = 1;
            }
            if(in_array(3,$permi)){
                $userPermi['can_confirm'] = 1;
            }
            if(in_array(4,$permi)){
                $userPermi['can_stock_out'] = 1;
            }
            if(in_array(5,$permi)){
                $userPermi['can_approval'] = 1;
            }
            if(in_array(6,$permi)){
                $userPermi['can_invoice'] = 1;
            }
            if(in_array(7,$permi)){
                $userPermi['can_stock_in'] = 1;
            }
            if(in_array(8,$permi)){
                $userPermi['can_stock_view'] = 1;
            }

            return FirmUserRepo::create($userPermi);
        }
    }

    //根据企业id，用户id读取出对应的权限
    public static function getAuthByCurrUser($firmId,$userId){
        return FirmUserRepo::getList([],['user_id'=>$userId,'firm_id'=>$firmId]);
    }

    //
    public static function update($id,$data){
        return FirmUserRepo::modify($id,$data);
    }

    public static function delete($id){
        return FirmUserRepo::delete($id);
    }

    //企业根据手机号码查询需要绑定的员工
    public static function search($firmId,$name){
        if(!preg_match("/^1[345789]{1}\\d{9}$/",$name)){
            self::throwBizError('手机号码格式不正确!');
        }

        $userInfo = UserRepo::getInfoByFields(['user_name'=>$name]);
        if($userInfo){
            $firmUserInfo = FirmUserRepo::getInfoByFields(['firm_id'=>$firmId,'user_id'=>$userInfo['id']]);
            if($firmUserInfo){
                self::throwBizError('用户已经绑定过本企业了');
            }
            return $userInfo;
        }
        self::throwBizError('未找到该用户');
    }
    //编辑企业会员弹层获取数据
    public static function editFirmUser($id){
        //获取firmuser表数据
        $firmUserInfo = FirmUserRepo::getInfo($id);
        if(empty($firmUserInfo)){
            self::throwBizError('企业用户不存在');
        }
        //获取user表user_name
        $userInfo = UserRepo::getInfo($firmUserInfo['user_id']);
        if(empty($userInfo)){
            self::throwBizError('用户不存在');
        }
        return ['firm_user_info'=>$firmUserInfo,'user_phone'=>$userInfo['user_name']];
    }

    //审批属性页面
    public static function Approval($userId){
        return UserRepo::getInfo($userId)['need_approval'];
    }

    //审批设置
    public static function OrderNeedApproval($userId,$approvalId){
        return UserRepo::modify($userId,['need_approval'=>$approvalId]);
    }


}