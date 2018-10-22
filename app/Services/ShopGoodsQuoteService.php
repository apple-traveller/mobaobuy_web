<?php
namespace App\Services;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\ShopGoodsRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\GoodsCategoryRepo;
class ShopGoodsQuoteService
{
    use CommonService;
    //获取报价列表
    public static function goodsQuoteList(){
        return ShopGoodsQuoteRepo::goodsQuoteList();
    }

    //分页
    public static function getShopGoodsQuoteList($pager,$condition)
    {
        $result = ShopGoodsQuoteRepo::getListBySearch($pager,$condition);
        foreach($result['list'] as $k=>$vo){
            $good = GoodsRepo::getInfo($vo['goods_id']);
            $result['list'][$k]['brand_name'] = $good['brand_name']?$good['brand_name']:"无品牌";
            $category = GoodsCategoryRepo::getInfo($good['cat_id']);
             if(!empty($category)){
                 $result['list'][$k]['cat_name'] = $category['cat_name'];
             }else{
                 $result['list'][$k]['cat_name'] = "无分类";
             }

        }
        return $result;
    }

    //保存
    public static function create($data)
    {
        return ShopGoodsQuoteRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return ShopGoodsQuoteRepo::modify($data['id'],$data);
    }

    //获取一条数据
    public static function getShopGoodsQuoteById($id)
    {
        $info = ShopGoodsQuoteRepo::getInfo($id);
        //dd($info);
        $goods_detail = GoodsRepo::getInfo($info['goods_id']);
        $info['goods_desc'] = $goods_detail['goods_desc'];//商品详情
        $info['brand_name'] = $goods_detail['brand_name'];//品牌
        $info['goods_sn'] = $goods_detail['goods_sn'];//编号
        $info['unit_name'] = $goods_detail['unit_name']; //单位
        $info['packing_spec'] = $goods_detail['packing_spec'];//包装规格
        $info['packing_unit'] = $goods_detail['packing_unit'];//包装单位
        $arr = explode(";",$goods_detail['goods_attr']);
        $info['goods_attr'] = $arr;
        return $info;
    }

    //删除
    public static function delete($id)
    {
        return ShopGoodsQuoteRepo::delete($id);
    }

    /**
     * 商户报价的商品
     * @param $shop_id
     * @return mixed
     */
    public static function getQuoteGoods($shop_id)
    {
        return ShopGoodsQuoteRepo::getQuoteGoods($shop_id);
    }
}

