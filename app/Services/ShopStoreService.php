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
        $store_list = ShopStoreRepo::getListBySearch($pager,$condition);
        foreach ($store_list['list'] as $k=>$v){
            $shop_info = ShopService::getShopById($v['shop_id']);
            $store_list['list'][$k]['company_name'] = $shop_info['company_name'];
        }
        return $store_list;
    }

    //删除
    public static function delete($id)
    {
        return ShopStoreRepo::delete($id);
    }

    //查找一条数据
    public static function getShopStoreById($id)
    {
        $store_info = ShopStoreRepo::getInfo($id);
        if(!$store_info){
            return [];
        }
        $shop_info = ShopService::getShopById($store_info['shop_id']);
        $store_info['company_name'] = $shop_info['company_name'];
        return $store_info;
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
