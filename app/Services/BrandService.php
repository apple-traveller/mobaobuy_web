<?php
namespace App\Services;
use App\Repositories\BrandRepo;
use App\Repositories\GoodsRepo;
class BrandService
{
    use CommonService;

    //分页
    public static function getBrandList($pager,$condition)
    {
        return BrandRepo::getListBySearch($pager,$condition);
    }

    //修改
    public static function modify($data)
    {
        return BrandRepo::modify($data['id'],$data);
    }

    //获取一条数据
    public static function getBrandInfo($id)
    {
        $info = BrandRepo::getInfo($id);
        $info['brand_logo_url'] = getFileUrl($info['brand_logo']);
        return $info;
    }

    //唯一性验证
    public static function uniqueValidate($brand_name)
    {
        $condition['brand_name'] = $brand_name;
        $condition['is_delete|<>'] = 1;
        $flag = BrandRepo::getListBySearch([],$condition);
        if($flag['list']){
            self::throwBizError('该品牌名称已经存在');
        }
    }

    //保存
    public static function create($data)
    {
        return BrandRepo::create($data);
    }

    //删除
    public static function delete($id)
    {
        //先验证是否存在商品
        $res = GoodsRepo::getInfoByFields(['brand_id'=>$id]);
        if(!empty($res)){
            self::throwBizError('该品牌存在商品，无法删除');
            return false;
        }

        $flag = BrandService::modify(['id'=>$id,'is_delete'=>1]);
        return $flag;
    }

    //商品列表页品牌列表
    public static function getBrandsByGoodsList($goodsList)
    {
        $brands = [];
        foreach($goodsList as $vo){
            $brands[] = GoodsRepo::getList([],['id'=>$vo['goods_id'],'is_delete'=>0],['brand_id','brand_name'])[0];
        }
        $brands_ids = [];
        $unique_brands_ids = [];
        foreach($brands as $vo){
            $brands_ids[] = $vo['brand_id'];
        }
        $unique_brands_ids = array_unique($brands_ids);
        $unique_brands = [];
        foreach ($unique_brands_ids as $item) {
            $unique_brands[] = BrandRepo::getList([],['id'=>$item,'is_delete'=>0],['id','brand_name'])[0];
        }
        return $unique_brands;
    }

    //根据brand_name获取goods数据
    public static function getGoodsIds($brand_name)
    {
        $goods_id = GoodsRepo::getList([],['brand_name'=>$brand_name,'is_delete'=>0],['id']);
        $res = [];
        foreach ($goods_id as $item){
            $res[] = $item['id'];
        }
        return $res;
    }
}