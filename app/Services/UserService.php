<?php
namespace App\Services;
use App\Repositories\GoodsRepo;
use App\Repositories\RegionRepo;
use App\Repositories\UserAddressRepo;
use App\Repositories\UserCollectGoodsRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Repositories\UserRepo;
use App\Repositories\UserRealRepo;
class UserService
{
    use CommonService;

    /**
     * 验证用户名是否存在
     * @param $name
     * @return bool
     */
    public static function checkNameExists($name){
        if(UserRepo::getTotalCount(['user_name'=> $name])){
            return true;
        }
        return false;
    }

    //用户注册
    public static function userRegister($data)
    {
        if(self::checkNameExists($data['user_name'])){
            self::throwBizError('手机号已经注册');
        }

        $data['reg_time'] = Carbon::now();
        $data['password'] = bcrypt($data['password']);
        if(!isset($data['nick_name']) || empty($data['nick_name'])){
            $data['nick_name'] = 'a'.str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        }

        if ($data['is_firm']) {
            //企业
            //查找黑名单表是否存在
            $firmBlack = FirmBlacklistRepo::getInfoByFields(['firm_name' => $data['nick_name']]);
            if ($firmBlack) {
                throwBizError('此用户已被冻结，请联系管理员');

            }
            $userReal = [];
            $userReal['license_fileImg'] = $data['license_fileImg'];
            $userReal['business_license_id'] = $data['business_license_id'];
            $userReal['taxpayer_id'] = $data['taxpayer_id'];
            $userReal['add_time'] = Carbon::now();

            $attorneyImgPath = Storage::putFile('public', $data['attorney_letter_fileImg']);
            $attorneyImgPath = explode('/', $attorneyImgPath);
            $data['attorney_letter_fileImg'] = '/storage/' . $attorneyImgPath[1];

            $licensePath = Storage::putFile('public', $data['license_fileImg']);
            $licensePath = explode('/', $licensePath);
            $userReal['license_fileImg'] = '/storage/' . $licensePath[1];

            unset($data['business_license_id']);
            unset($data['license_fileImg']);
            unset($data['taxpayer_id']);
            unset($data['mobile_code']);

            try {
                self::beginTransaction();
                $user = UserRepo::create($data);
                $userReal['user_id'] = $user['id'];
                $real = UserRealRepo::create($userReal);
                self::commit();
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }
        } else {
            $user_info = UserRepo::create($data);
            return $user_info['id'];
        }
    }

    //用户登录
    public static function loginValidate($username, $psw, $other_params = [])
    {
        //查用户表
        $info = UserRepo::getInfoByFields(['user_name'=>$username]);
        if(empty($info)){
            self::throwBizError('用户名或密码不正确！');
        }

        if(!Hash::check($psw, $info['password'])){
            self::throwBizError('用户名或密码不正确！');
        }

        if ($info['is_freeze']) {
            self::throwBizError('用户名或密码不正确！');
        }
        unset($info['password']);

        //登录成功后事件
        createEvent('webUserLogin', ['user_id'=>$info['id'], 'client_ip'=>$other_params['ip']]);

        return $info['id'];
    }


    //修改密码
    public static function userUpdatePwd($id,$data){
       $userInfo = UserRepo::getInfo($id);
       if(!Hash::check($data['password'],$userInfo['password'])){
           self::throwBizError('用户密码不正确！');
       }
       $newData = [];
       $newData['password'] = bcrypt($data['newPassword']);
       return UserRepo::modify($id,$newData);
    }

    //忘记密码
    public static function userForgotPwd($id,$data){
        $newData = [];
        $newData['password'] = bcrypt($data['newPassword']);
        return UserRepo::modify($id,$newData);
    }

    //设置支付密码
    public static function setPayPwd($data){
        if($data['password'] != $data['passwords']){
            self::throwBizError('两次密码不一致！');
        }

        unset($data['passwords']);


        UserPaypwdRepo::create();
    }

    //完善信息
    public static function updateUserInfo($id,$data){
        //real表 真实名字  性别  省份证正  反面
        //user表  昵称 邮箱 用户头像
        $real = [];
        $real['real_name'] = $data['real_name'];
        $real['sex'] = $data['sex'];


        $frontCardImgPath = Storage::putFile('public', $data['front_of_id_card']);
        $frontCardImgPath = explode('/',$frontCardImgPath);
        $real['front_of_id_card'] = '/storage/'.$frontCardImgPath[1];

        $reverseCardImgPath = Storage::putFile('public', $data['reverse_of_id_card']);
        $reverseCardImgPath = explode('/',$reverseCardImgPath);
        $real['reverse_of_id_card'] = '/storage/'.$reverseCardImgPath[1];

        unset($data['real_name']);
        unset($data['sex']);
        unset($data['front_of_id_card']);
        unset($data['reverse_of_id_card']);
        try{
            self::beginTransaction();
            UserRealRepo::modify($id,$real);
            UserRepo::modify($id,$data);
            self::commit();
        }catch (\Exception $e){
            self::rollBack();
            throw $e;
        }
    }




    //显示用户收获地
    public static function shopAddressList($condi){
        $userAddressInfo = UserAddressRepo::getList($order=[],$condi);
        foreach($userAddressInfo as $k=>$v){
            $userAddressInfo[$k]['country'] = RegionRepo::getInfo($v['country'])['region_name'];
            $userAddressInfo[$k]['province'] = RegionRepo::getInfo($v['province'])['region_name'];
            $userAddressInfo[$k]['city'] = RegionRepo::getInfo($v['city'])['region_name'];
            $userAddressInfo[$k]['district'] = RegionRepo::getInfo($v['district'])['region_name'];
        }
        return $userAddressInfo;
    }

    //更新收获地
    public static function updateShopAdderss($id,$data){
        return UserAddressRepo::modify($id,$data);
    }

    //新增收获地
    public static function addShopAddress($data){
        return UserAddressRepo::create($data);
    }

    //获取省
    public static function provinceInfo($region_type){
        return RegionRepo::getProvince($region_type);
    }

    //获取市
    public static function getCity($regionId){
        return RegionRepo::getCity($regionId);
    }

    //获取县
    public static function getCounty($cityId){
        return RegionRepo::getCounty($cityId);
    }

    //收藏商品列表
    public static function userCollectGoodsList($id){
        //查找收藏商品表
        $collectGoods = UserCollectGoodsRepo::getList([],['user_id'=>$id]);
        //通过商品id查找对应的产品
        if($collectGoods){
            $goodsId = [];
            foreach($collectGoods as $v){
                $goodsId[] = $v['goods_id'];
            }
            return GoodsRepo::userCollectGoodsList($goodsId);
        }
        return [];
    }

    //收藏商品
    public static function addCollectGoods($goodsId,$userId){
        return UserCollectGoodsRpepo::create(['user_id'=>$userId,'goods_id'=>$goodsId,'add_time'=>Carbon::now()]);
    }


    //后台
    //获取用户列表(导出excel表)
    public static function getUsers($fields)
    {
        $info = UserRepo::getUsers($fields);
        return $info;
    }

    //获取用户列表（分页）
    public static function getUserList($pager,$condition)
    {
        //$info = UserRepo::search($pageSize,$user_name);
        $info = UserRepo::getListBySearch($pager,$condition);
        foreach($info['list'] as $k=>$v) {
            $userreal = UserRealRepo::getInfoByFields(['user_id'=>$v['id']]);
            if(!empty($userreal)){
                $info['list'][$k]['userreal']=$userreal['review_status'];
            }else{
                $info['list'][$k]['userreal']=0;
            }
        }
        return $info;
    }


    //修改
    public static function modify($id,$data)
    {
        return UserRepo::modify($id,$data);
    }

    public static function getInfo($id)
    {
        $info = UserRepo::getInfo($id);
        unset($info['password']);
        return $info;
    }


    //获取总条数
    public static function getCount($user_name)
    {
        return UserRepo::getCount($user_name);
    }
}