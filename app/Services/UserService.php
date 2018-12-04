<?php
namespace App\Services;
use App\Repositories\AppUsersRepo;
use App\Repositories\FirmUserRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\FirmBlacklistRepo;
use App\Repositories\GsxxCompanyRepo;
use App\Repositories\GsxxSupplierRepo;
use App\Repositories\OrderInfoRepo;
use App\Repositories\RegionRepo;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\UserAddressRepo;
use App\Repositories\UserCollectGoodsRepo;
use App\Repositories\UserPaypwdRepo;
use App\Repositories\UserSaleRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Repositories\UserRepo;
use App\Repositories\UserRealRepo;
use League\Flysystem\Exception;

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

    /**
     * @param $name
     * @return bool
     * 验证用户id是否实名并通过
     */
    public static function isReal($userId){
        $userRealInfo = UserRealRepo::getInfoByFields(['user_id'=>$userId,'review_status'=>1]);
        if(empty($userRealInfo)){
            self::throwBizError('实名认证通过后才能下单');
        }
    }

    public static function checkCompanyNameCanAdd($name){
        if(UserRepo::getTotalCount(['is_firm'=>1, 'nick_name'=> $name])){
            return false;
        }

        $firmBlack = FirmBlacklistRepo::getInfoByFields(['firm_name' => $name]);
        if ($firmBlack) {
            return false;
        }

        if(getConfig('firm_exist_check')){
            $info = GsxxService::GsSearch($name);
            if($info){
                return true;
            }else{
                return false;
            }
        }

        return true;
    }

    //短信登陆
    public static function loginByMessage($username,$messageCode){

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

        $user_id = 0;
        if ($data['is_firm']) {
            //企业
            //查找黑名单表是否存在
            $firmBlack = FirmBlacklistRepo::getInfoByFields(['firm_name' => $data['nick_name']]);
            if ($firmBlack) {
                self::throwBizError('企业已被冻结');
            }
            $data['nick_name'] = $data['company_name'];
            if(!self::checkCompanyNameCanAdd($data['company_name'])){
                self::throwBizError('企业名称不对或已被注册!');
            }
            if(getConfig('firm_reg_check')){
                $data['is_validated'] = 0;
            }else{
                $data['is_validated'] = 1;
            }

            $user_data = [
                'user_name' => $data['user_name'],
                'nick_name' => $data['nick_name'],
                'password' => $data['password'],
                'contactName' => '',
                'contactPhone' => '',
                'attorney_letter_fileImg' => $data['attorney_letter_fileImg'],
                'reg_time' => Carbon::now(),
                'is_firm' => $data['is_firm'],
                'is_validated' => $data['is_validated']
            ];

            $userReal = [
                'real_name' => $data['nick_name'],
                'business_license_id' => '',
                'license_fileImg' => $data['license_fileImg'],
                'taxpayer_id' => '',
                'add_time' => Carbon::now(),
                'review_status' => $data['is_validated']
            ];
            $company_info = GsxxCompanyRepo::getInfoByFields(['Name'=>$data['nick_name']]);
            if($company_info){
                $userReal['taxpayer_id'] = $company_info['CreditCode'];
                $userReal['business_license_id'] = $company_info['No'];
            }

            try {
                self::beginTransaction();
                $user = UserRepo::create($user_data);
                $userReal['user_id'] = $user['id'];
                UserRealRepo::create($userReal);
                self::commit();
                $user_id = $user['id'];
            }catch (\Exception $e){
                self::rollBack();
                throw $e;
            }
        } else {
            if(getConfig('individual_reg_check')){
                $data['is_validated'] = 0;
            }else{
                $data['is_validated'] = 1;
            }
            $user_info = UserRepo::create($data);
            $user_id = $user_info['id'];
        }
        //登录成功后事件
        createEvent('webUserRegister', ['user_id'=>$user_id]);
        return $user_id;
    }

    //用户登录
    public static function loginValidate($username, $psw, $other_params = [],$params = [])
    {
        //查用户表
        $info = UserRepo::getInfoByFields(['user_name'=>$username]);
        if(empty($info)){
            self::throwBizError('用户名或密码不正确！');
        }
        if(isset($params['mobile_code'])){
//            if(!Hash::check($psw, $params['mobile_code'])){
//                dd(1);
//                self::throwBizError('用户名或密码不正确！');
//            }
            if($params['mobile_code'] != $psw){
                self::throwBizError('用户名或密码不正确');
            }
        }else{
            if(!Hash::check($psw, $info['password'])){
                self::throwBizError('用户名或密码不正确！');
            }
        }

        if ($info['is_freeze']) {
            self::throwBizError('用户名或密码不正确！');
        }
        if (!$info['is_validated']) {
            self::throwBizError('账号需待审核通过后才可登录！');
        }
        UserRepo::modify($info['id'],['is_logout'=>0]);
        unset($info['password']);
        //登录成功后事件
        createEvent('webUserLogin', ['user_id'=>$info['id'], 'client_ip'=>$other_params['ip']]);
        return $info['id'];
    }


    //修改密码
    public static function userUpdatePwd($id, $data){
       $newData['password'] = bcrypt($data['newPassword']);
       return UserRepo::modify($id,$newData);
    }

    //忘记密码
    public static function userFindPwd($username, $new_pwd){
        $newData = [];
        $info = UserRepo::getInfoByFields(['user_name'=>$username]);
        if(empty($info)){
            self::throwBizError('用户名不正确！');
        }


        if ($info['is_freeze']) {
            self::throwBizError('用户名已被冻结！');
        }
        if (!$info['is_validated']) {
            self::throwBizError('账号审核通过后才可操作！');
        }
        $newData['password'] = bcrypt($new_pwd);
        return UserRepo::modify($info['id'], $newData);
    }

    //重置密码
    public static function resetPwd($username, $new_pwd){
        $newData = [];
        $info = UserRepo::getInfoByFields(['user_name'=>$username]);
        if(empty($info)){
            self::throwBizError('用户名不正确！');
        }

        if ($info['is_freeze']) {
            self::throwBizError('用户名已被冻结！');
        }
        if (!$info['is_validated']) {
            self::throwBizError('账号审核通过后才可操作！');
        }
        $newData['password'] = bcrypt($new_pwd);
        return UserRepo::modify($info['id'], $newData);
    }

    public static function getUserFirms($user_id){
        $firm_list = FirmUserRepo::getList([],['user_id'=>$user_id]);
        if($firm_list){
            foreach($firm_list as &$item){
                $firm_info = UserRepo::getInfo($item['firm_id']);
                $item['firm_name'] = $firm_info['nick_name'];
                $item['address_id'] = $firm_info['address_id'];
            }
            unset($item);
            return $firm_list;
        }
        return [];
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
            $userAddressInfo[$k]['district'] = RegionRepo::getInfo($v['district'])?RegionRepo::getInfo($v['district'])['region_name']:"";
        }
        return $userAddressInfo;
    }

    public static function getOneAddressId($user_id)
    {
        $userAddressInfo = UserAddressRepo::getList($order=['id'=>'desc'],['user_id'=>$user_id]);
        if($userAddressInfo){
            return $userAddressInfo[0]['id'];
        }
        return false;
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
    public static function userCollectGoodsList($firm_id,$page = 1,$pageSize = 10){
        $condition = [];
        if($firm_id > 0){
            $condition['user_id'] = $firm_id;
        }

        //查找收藏商品表
        $collectGoods = UserCollectGoodsRepo::getListBySearch(['pageSize'=>$pageSize,'page'=>$page,'orderType'=>['add_time'=>'desc']],$condition);
        //通过商品id查找对应的商品
        if($collectGoods){
            foreach($collectGoods['list'] as $k=>$v){
                $collectGoods['list'][$k]['goods_name'] = GoodsRepo::getInfo($v['goods_id'])['goods_name'];
            }
            return $collectGoods;
        }
        return [];
    }

    //收藏商品
    public static function addCollectGoods($goodsId,$userId){
        $userCollect = UserCollectGoodsRepo::getList([],['user_id'=>$userId,'goods_id'=>$goodsId]);
        if(!$userCollect){
            return UserCollectGoodsRepo::create(['user_id'=>$userId,'goods_id'=>$goodsId,'add_time'=>Carbon::now()]);
        }
        self::throwBizError('已收藏过此商品！');
    }

    //删除搜藏商品
    public static function delCollectGoods($id){
        return UserCollectGoodsRepo::delete($id);
    }

    //我要卖货提交
    public static function sale($data){

        return UserSaleRepo::create($data);
    }

    //后台
    //获取用户列表(导出excel表)
    public static function getUsers($fields)
    {
        $info = UserRepo::getList([],[],$fields);
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
                $info['list'][$k]['review_status']=$userreal['review_status'];
            }else{
                $info['list'][$k]['review_status']=-1;
            }
        }
        return $info;
    }

    //修改
    public static function modifyNeedApproval($data)
    {
        return UserRepo::modify($data['id'],$data);
    }

    //修改用户信息
    public static function modify($userId,$data)
    {
        try{
            //修改用户表
            $info = UserRepo::modify($userId,$data);
            if($info){
                unset($info['password']);
            }
            return $info;
        }catch (\Exception $e){
            self::throwBizError($e->getMessage());
            //throw $e;
        }
    }

    //修改默认收获地址
    public static function updateDefaultAddress($data)
    {
        return UserRepo::modify($data['id'],['address_id'=>$data['address_id']]);
    }

    public static function getUserInfo($id)
    {
        return UserRepo::getInfo($id);
    }

    public static function getInfo($id)
   {
        $info = UserRepo::getInfo($id);
        unset($info['password']);
        return $info;
   }

    //获取指定字段的所有数据
    public static function getUsersByColumn($condition,$column)
    {
        return UserRepo::getList([],$condition,$column);
    }

    //修改支付密码
    public static function modifyPayPwd($user_id, $pay_pwd)
    {
        $info = UserPaypwdRepo::getInfoByFields(['user_id'=>$user_id]);
        if(empty($info)){
            $data = [
                'user_id' => $user_id,
                'pay_password' => bcrypt($pay_pwd)
            ];
            return UserPaypwdRepo::create($data);
        }else{
            return UserPaypwdRepo::modify($info['id'], ['pay_password'=>bcrypt($pay_pwd)]);
        }
    }

    //返回各实名状态的用户id
    public static function getUserIds($is_firm)
    {
        $arr = [];
        if($is_firm==-1){
            //已经提交实名信息，实名信息审核没通过
            $user_reals = UserRealRepo::getList([],['review_status'=>"2|0"],['id','user_id']);
            foreach($user_reals as $vo){
                $user = UserRepo::getInfo($vo['user_id']);
                if(!empty($user)){
                    $arr[] = $vo['user_id'];
                }
            }
        }elseif($is_firm==-2){
            //没提交实名
            $users = UserRepo::getList([],[]);
            foreach($users as $vo){
                $user_reals = UserRealRepo::getList([],['user_id'=>$vo['id']],['id','user_id']);//所有已经提交实名的
                if(empty($user_reals)){
                    $arr[] = $vo['id'];
                }
            }
        }else{
            //实名通过
            $user_reals = UserRealRepo::getList([],['is_firm'=>$is_firm,'review_status'=>1],['id','user_id']);
            foreach($user_reals as $vo){
                $user = UserRepo::getInfoByFields(["id"=>$vo['user_id'],"is_firm"=>$is_firm]);
                if(!empty($user)){
                    $arr[] = $user['id'];
                }
            }
        }
        return $arr;
    }

    //获取用户收藏商品信息
    public static function getCollectGoods($user_id)
    {
        $collect_goods = UserCollectGoodsRepo::getList([],['user_id'=>$user_id]);
        foreach($collect_goods as $k=>$v){
            $goods = GoodsRepo::getList([],['id'=>$v['goods_id']],['goods_name'])[0];
            $collect_goods[$k]['goods_name']=$goods['goods_name'];
        }
        return $collect_goods;
    }

    //会员中心首页
    public static function userMember($userId,$firmId){
        $userRealInfo = UserRealRepo::getInfoByFields(['user_id'=>$userId]);

        //商品推荐
        $shopGoodsInfo = ShopGoodsQuoteRepo::getListBySearch(['pageSize'=>3,'page'=>1],['is_self_run'=>1]);

        //企业和代理用户
        if(empty($userId)){
            $nPayOrderTotalCount = OrderInfoRepo::getTotalCount(['firm_id'=>$firmId,'pay_status'=>0,'order_status'=>3,'is_delete'=>0]);
            $yPayOrderTotalCount = OrderInfoRepo::getTotalCount(['firm_id'=>$firmId,'pay_status'=>1,'order_status|>'=>0,'is_delete'=>0]);
            //订单
            $orderInfo =  OrderInfoRepo::getListBySearch(['pageSize'=>3,'page'=>1,'orderType'=>['add_time'=>'desc']],['firm_id'=>$firmId,'order_status|>'=>'0','is_delete'=>0]);
        }else{
            //个人用户
            //未付款订单数
            $nPayOrderTotalCount = OrderInfoRepo::getTotalCount(['user_id'=>$userId,'firm_id'=>$firmId,'pay_status'=>0,'order_status'=>3,'is_delete'=>0]);

            //已付款
            $yPayOrderTotalCount = OrderInfoRepo::getTotalCount(['user_id'=>$userId,'firm_id'=>$firmId,'pay_status'=>1,'order_status|>'=>0,'is_delete'=>0]);

            //订单
            $orderInfo =  OrderInfoRepo::getListBySearch(['pageSize'=>3,'page'=>1,'orderType'=>['add_time'=>'desc']],['user_id'=>$userId,'firm_id'=>$firmId,'order_status|>'=>'0','is_delete'=>0]);
        }

        return ['orderInfo'=>$orderInfo['list'],'shopGoodsInfo'=>$shopGoodsInfo['list'],'nPayOrderTotalCount'=>$nPayOrderTotalCount?$nPayOrderTotalCount:0,'yPayOrderTotalCount'=>$yPayOrderTotalCount?$yPayOrderTotalCount:0,'userRealInfo'=>$userRealInfo];
    }

    public static function getUserRealbyId($id){
        $userRealInfo = UserRealRepo::getInfoByFields(['user_id'=>$id]);
        if(empty($userRealInfo)){
            return '';
        }else{
            return $userRealInfo['real_name'];
        }
    }

    //是否收藏
    public static function checkUserIsCollect($userId,$goodsId){
        $collectGoodsInfo = UserCollectGoodsRepo::getInfoByFields(['user_id'=>$userId,'goods_id'=>$goodsId]);
        if(!empty($collectGoodsInfo)){
            return 1;
        }
        return 0;
    }

    //是否收藏
    public static function checkUserIsCollectApi($userId,$goodsId){
        $collectGoodsInfo = UserCollectGoodsRepo::getInfoByFields(['user_id'=>$userId,'goods_id'=>$goodsId]);
        if(!empty($collectGoodsInfo)){
            return $collectGoodsInfo['id'];
        }
        return 0;
    }

    //添加企业会员，验证手机号是否存在
    public static function getUserInfoByUserName($mobile){
        return UserRepo::getInfoByFields(['user_name'=>$mobile]);
    }
    //后台首页用户统计
    public static function getUsersCount()
    {
        $users = [];
        $users['is_firm'] = UserRepo::getTotalCount(['id'=>implode('|',self::getUserIds(1))]);
        $users['is_personal'] = UserRepo::getTotalCount(['id'=>implode('|',self::getUserIds(0))]);
        $users['no_verify'] = UserRepo::getTotalCount(['id'=>implode('|',self::getUserIds(-1))]);
        $users['total'] = UserRepo::getTotalCount();
        return $users;
    }

    //admin
    // 添加用户实名信息
    public static function addUserRealForm($id){
        $userInfo = UserRepo::getInfo($id);
        if(empty($userInfo)){
            self::throwBizError('用户信息不存在');
        }

        $userRealInfo = UserRealRepo::getInfoByFields(['user_id'=>$userInfo['id']]);
        if(!empty($userRealInfo)){
            if($userRealInfo['review_status'] == 1){
                self::throwBizError('用户审核已通过');
            }
            if($userRealInfo['review_status'] == 0){
                self::throwBizError('请等待管理员审核');
            }
        }
        return $userInfo;
    }
    //获取第三方登录信息
    public static function getAppUserInfo($condition)
    {
        return AppUsersRepo::getInfoByFields($condition);
    }
    //创建第三方登录信息
    public static function createAppUserInfo($data)
    {
        return AppUsersRepo::create($data);
    }

    //获取用户详细信息（小程序接口）
    public static function getApiUserInfo($id)
    {
        $user = UserService::getInfo($id);
        $user_real = UserRealRepo::getInfoByFields(['user_id' => $id]);
        if (empty($user_real)) {
            $user['user_real'] = "";
            return $user;
        } else {
            $user['user_real'] = $user_real;
            return $user;
        }
    }

    public static function bindThird($user_id,$openid,$nick_name,$avatar)
    {
        #认证成功 绑定qq或微信
        $userInfo = AppUsersRepo::getInfoByFields(['user_id'=>$user_id]);
        if(!empty($userInfo)){
            return true; //如果用户的绑定信息存在就不走下面绑定过程，直接登录
        }
        $app_data = [
            'open_id' => $openid,
            'identity_type' => 'W',//微信登录
            'user_id' => $user_id,
            'create_time'=>date('Y-m-d H:i:s')
        ];
        try{
            self::beginTransaction();
            $app_res = self::createAppUserInfo($app_data);
            if(!$app_res){
                self::throwBizError('绑定失败！');
            }
            //如果是企业用户不能修改昵称
            $userInfo = self::getInfo($user_id);
            if($userInfo['is_firm']==1){
                $user_res = self::modify($user_id,['avatar'=>$avatar]);
                if(!$user_res){
                    self::throwBizError('用户信息更新失败！');
                }
            }
            #更新用户信息
            $user_res = self::modify($user_id,['nick_name'=>$nick_name,'avatar'=>$avatar]);
            if(!$user_res){
                self::throwBizError('用户信息更新失败！');
            }
            self::commit();
            return true;
        }catch (Exception $e){
            self::rollBack();
            self::throwBizError($e);
        }
    }

    public static function createThird($openid,$data)
    {
        try{
            self::beginTransaction();
            $user_id = self::userRegister($data);

            $app_data = [
                'open_id' => $openid,
                'identity_type' => 'W',
                'user_id' => $user_id,
                'create_time'=>date('Y-m-d H:i:s')
            ];
            $app_res = self::createAppUserInfo($app_data);
            if(!$app_res){
                self::throwBizError('绑定失败！');
            }
            self::commit();
            return $user_id;
        }catch (Exception $e){
            self::rollBack();
            self::throwBizError($e);
        }
    }

    //解绑
    public static function deleteThird($openid)
    {
        try{
            $condition = [
                'open_id' => $openid,
            ];
            $flag = AppUsersRepo::getInfoByFields($condition);
            if(empty($flag)){
                self::throwBizError('参数有误');
            }
            return AppUsersRepo::deleteByFields($condition);
        }catch(\Exception $e){
            self::throwBizError($e->getMessage());
        }

    }
}
