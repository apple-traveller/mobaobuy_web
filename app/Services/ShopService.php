<?php
namespace App\Services;
use App\Repositories\ShopRepo;
use App\Repositories\UserRepo;
class ShopService
{
    use CommonService;

    //查询分页
    public static function getShopList($pager,$condition)
    {
        return ShopRepo::getListBySearch($pager,$condition);
    }

    //新增
    public static function create($data)
    {
        return ShopRepo::create($data);
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
    public static function uniqueValidate($shop_name)
    {
        $info = ShopRepo::getInfoByFields(['shop_name'=>$shop_name]);
        if(!empty($info)){
            self::throwBizError('该店铺名已经存在！');
        }
        return $info;
    }


}