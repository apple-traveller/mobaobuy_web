<?php
namespace App\Services;
use App\Repositories\ShopRepo;
use App\Repositories\ShopStoreRepo;
use App\Repositories\UserRepo;
use App\Repositories\ShopUserRepo;
use App\Repositories\ShopLogRepo;
use Illuminate\Support\Facades\Hash;

class ShopService
{
    use CommonService;

    //查询分页
    public static function getShopList($pager,$condition)
    {
        return ShopRepo::getListBySearch($pager,$condition);
    }

    //查询日志
    public static function getShopLogList($pager,$condition)
    {
        return ShopLogRepo::getListBySearch($pager,$condition);
    }

    public static function getList($order=[],$condition=[])
    {
        return ShopRepo::getList($order,$condition);
    }

    //新增
    public static function create($data)
    {
        $udata['user_name']=$data['user_name'];
        $udata['password']=Hash::make($data['password']);
        $udata['add_time']=$data['reg_time'];
        unset($data['user_name']);
        unset($data['password']);
        try{
            self::beginTransaction();
            $shop = ShopRepo::create($data);
            $udata['shop_id'] = $shop['id'];
            $shopuser = ShopUserRepo::create($udata);
            self::commit();
            return $shopuser;
        }catch(\Exception $e){
            self::rollBack();
            Self::throwBizError($e->getMessage());
        }

    }

    //获取一条数据
    public static function getShopById($id)
    {
        return ShopRepo::getInfo($id);
    }

    //修改
    public static function modify($data)
    {
        return ShopRepo::modify($data['id'],$data);
    }

    //查询用户
    public static function getUserList($condition)
    {
        return UserRepo::getListBySearch([],$condition);
    }

    //验证唯一性
    public static function uniqueValidate($company_name,$user_name)
    {
        $info = ShopRepo::getInfoByFields(['company_name'=>$company_name]);
        $shop_user = ShopUserRepo::getInfoByFields(['user_name'=>$user_name]);
        if(!empty($info)){
            self::throwBizError('该企业已经存在！');
        }
        if(!empty($shop_user)){
            self::throwBizError('该管理员名称已经存在,请重新选择！');
        }
        return $info;
    }

    //后台首页统计店铺总数量
    public static function getShopsCount()
    {
        return ShopRepo::getTotalCount(['is_freeze'=>0,'is_validated'=>1]);
    }


}