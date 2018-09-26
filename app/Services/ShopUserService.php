<?php
namespace App\Services;
use App\Repositories\ShopUserRepo;
class ShopUserService
{
    use CommonService;

    //分页
    public static function getShopUserList($pager,$condition)
    {
        return ShopUserRepo::getListBySearch($pager,$condition);
    }

    //删除
    public static function delete($id)
    {
        return ShopUserRepo::delete($id);
    }

    //查找一条数据
    public static function getShopUserById($id)
    {
        return ShopUserRepo::getInfo($id);
    }

    //验证唯一性
    public static function uniqueValidate($condition)
    {
        $info = ShopUserRepo::getInfoByFields(['shop_id'=>$condition['shop_id'],'user_name'=>$condition['user_name']]);
        if(!empty($info)){
            self::throwBizError('该用户名已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return ShopUserRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return ShopUserRepo::modify($data['id'],$data);
    }


}