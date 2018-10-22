<?php
namespace App\Services;
use App\Repositories\ShopGoodsRepo;
class ShopGoodsService
{
    use CommonService;

    //分页
    public static function getShopGoodsList($pager,$condition)
    {
        return ShopGoodsRepo::getListBySearch($pager,$condition);
    }

    // 下拉列表
    public static function getGoodsList($condition)
    {
        return ShopGoodsRepo::getList([],$condition);
    }

    //保存
    public static function create($data)
    {
        return ShopGoodsRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return ShopGoodsRepo::modify($data['id'],$data);
    }

    //获取一条数据
    public static function getShopGoodsById($id)
    {
        return ShopGoodsRepo::getInfo($id);
    }

    //删除
    public static function delete($id)
    {
        return ShopGoodsRepo::delete($id);
    }

    //验证唯一性
    public static function uniqueValidate($condition)
    {
        $info = ShopGoodsRepo::getInfoByFields(['shop_id'=>$condition['shop_id'],'goods_id'=>$condition['goods_id']]);
        if(!empty($info)){
            self::throwBizError('该商品已经存在！');
        }
        return $info;
    }

}
