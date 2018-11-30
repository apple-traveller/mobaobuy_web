<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-19
 * Time: 14:42
 */
namespace App\Services;

use App\Repositories\ShopRepo;
use App\Repositories\ShopUserRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ShopLoginService
{
    use CommonService;

    /**
     * 商户入驻
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public static function Register($data)
    {
        try {
            $checkShop = self::checkShopExists($data['company_name']);
            if ($checkShop['status']==3){
                self::throwBizError($checkShop['msg']);
            }
            $checkUser = self::checkUserExists($data['user_name']);
            if ($checkUser['status']==4){
                self::throwBizError($checkUser['msg']);
            }

            $data['password'] = bcrypt($data['password']);
            $shop_data = [
                'user_id' => $data['user_id'],
                'company_name' => $data['company_name'],
                'shop_name' => $data['shop_name'],
                'attorney_letter_fileImg' => $data['attorney_letter_fileImg'],
                'license_fileImg' => $data['license_fileImg'],
                'reg_time' => Carbon::now(),
                'is_validated' => 0
            ];
            self::beginTransaction();
            $shop_info = ShopRepo::create($shop_data);
            if (!empty($shop_info)){
                $user_data = [
                    'shop_id' => $shop_info['id'],
                    'user_name' => $data['user_name'],
                    'password' =>$data['password'],
                    'add_time' =>Carbon::now(),
                    'is_super' => 1
                ];
                $user_res = ShopUserRepo::create($user_data);
                if (!empty($user_res)){
                    self::commit();
                    return true;
                } else {
                    self::rollBack();
                    return false;
                }
            }
        } catch (\Exception $e) {
            self::rollBack();
            self::throwBizError($e->getMessage());
        }
    }

    /**
     * 商户登录
     * @param $data
     * @return array|void
     * @throws \Exception
     */
    public static function CheckLogin($data)
    {
        if (empty($data)){
            return ;
        }
        $user_info = ShopUserRepo::getInfoByFields(['user_name'=>$data['user_name']]);
        if (empty($user_info)){
            self::throwBizError('用户不存在');
        }
        if (!Hash::check($data['password'],$user_info['password'])){
            self::throwBizError('密码不正确');
        }
        $shop_info = ShopRepo::getInfoByFields(['id'=>$user_info['shop_id']]);
        if (empty($shop_info)){
            self::throwBizError('店铺不存在');
        }
        if ($shop_info['is_validated'] == 0){
            self::throwBizError('未通过审核,暂不能登录,请耐心等待');
        }
        if ($shop_info['is_freeze'] == 1){
            self::throwBizError('该店铺已经冻结,暂不能登录');
        }
        // 验证成功后，创建事件
        createEvent('sellerUserLogin',['shop_id'=>$shop_info['id'],'user_id'=>$user_info['id'],'ip'=>$data['ip']]);
        return ['shop_id'=>$user_info['shop_id'],'user_id'=>$user_info['id']];
    }
    /**
     * 发送短信
     * @param $mobile
     * @return mixed|\stdClass
     * @throws \Exception
     */
    public static function sendSMSCode($type,$mobile,$code)
    {
        $params = [
            'code'=>$code
        ];
        return SmsService::sendSms($mobile, $type, $params);
    }

    public static function getMsgSession()
    {
        return Session::get('register_code');
    }

    /**
     * 获取商户管理者基本信息
     * @param $id
     * @return array
     */
    public static function getInfo($id)
    {
        $user_info = ShopUserRepo::getInfo($id);
        unset($user_info['password']);
        return $user_info;
    }

    /**
     * 检查店铺名是否存在
     * @param $ShopName
     * @return array
     */
    public static function checkShopExists($ShopName)
    {
        $re = ShopRepo::getInfoByFields(['company_name'=>$ShopName]);
       if (!empty($re)){
           if ($re['is_validated']==0){
                return [
                    'status'=>4,
                    'msg'=>'该店铺已提交申请，请等待审核'
                ];
           } else {
               return [
                   'status'=>4,
                   'msg'=>'该店铺已注册'
               ];
           }
       }
       return [
           'status'=>1,
           'msg'=>''
       ];
    }

    /**
     * 检查用户是否已经存在
     * @param $user_name
     * @return array|bool
     */
    public static function checkUserExists($user_name)
    {
        $re = ShopUserRepo::getInfoByFields(['user_name'=>$user_name]);
        if (!empty($re)){
            $shop = ShopRepo::getInfo($re['shop_id']);
            if (!empty($shop)){
                if ($shop['is_validated']==0){
                    return [
                        'status'=>4,
                        'msg'=>'该店铺已提交申请，请等待审核'
                    ];
                } else {
                    return [
                        'status'=>4,
                        'msg'=>'该用户已注册店铺'
                    ];
                }
            } else {
                return [
                    'status'=>4,
                    'msg'=>'该用户已存在'
                ];
            }
        }
        return false;
    }

}
