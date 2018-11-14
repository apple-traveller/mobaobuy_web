<?php
namespace App\Services;
use App\Repositories\ShopStoreRepo;
use function Psy\sh;

class ShopStoreService
{
    use CommonService;

    //分页
    public static function getShopStoreList($pager,$condition)
    {
        return ShopStoreRepo::getListBySearch($pager,$condition);
    }

    //删除
    public static function delete($id)
    {
        return ShopStoreRepo::delete($id);
    }

    //查找一条数据
    public static function getShopUserById($id)
    {
        return ShopStoreRepo::getInfo($id);
    }

    //验证唯一性
    public static function uniqueValidate($condition)
    {
        $info = ShopStoreRepo::getInfoByFields(['shop_id'=>$condition['shop_id'],'store_name'=>$condition['store_name']]);
        if(!empty($info)){
            self::throwBizError('该店铺已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return ShopStoreRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return ShopStoreRepo::modify($data['id'],$data);
    }

}
