<?php
namespace App\Services;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\ShopGoodsRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\ShopRepo;

class ShopGoodsQuoteService
{
    use CommonService;
    //获取报价列表
    public static function goodsQuoteList(){
        return ShopGoodsQuoteRepo::goodsQuoteList();
    }

    public static function getQuoteByWebSearch($pager,$condition){
        $result = ShopGoodsQuoteRepo::getQuoteInfoBySearch($pager,$condition);
        foreach($result['list'] as $k=>$vo){
            $result['list'][$k]['brand_name'] = $vo['brand_name']?$vo['brand_name']:"无品牌";
        }

        //获取筛选过滤信息
        //1、获取分类
        $cates = ShopGoodsQuoteRepo::getQuoteCategory([]);
        if(!empty($cates)){
            $filter['cates'] = GoodsCategoryService::getCatesByCondition(['id'=>implode('|', $cates)]);
        }else{
            $filter['cates'] = [];
        }
        //2、获取品牌
        $brands = ShopGoodsQuoteRepo::getQuoteBrand([]);
        if(!empty($brands)){
            $brand_list = BrandService::getBrandList([], ['id'=>implode('|', $brands)]);
            $filter['brands'] = $brand_list['list'];
        }else{
            $filter['brands'] = [];
        }
        //3、获取发货地
        $cities = ShopGoodsQuoteRepo::getQuoteCity([]);
        if(!empty($cities)){
            $city_list = RegionService::getList([], ['region_id'=>implode('|', $cities)]);
            $filter['city_list'] = $city_list;
        }else{
            $filter['city_list'] = [];
        }

        $result['filter'] = $filter;
        return $result;
    }

    //分页
    public static function getShopGoodsQuoteList($pager,$condition)
    {

        $result = ShopGoodsQuoteRepo::getQuoteInfoBySearch($pager,$condition);
        foreach($result['list'] as $k=>$vo){
            $result['list'][$k]['brand_name'] = $vo['brand_name']?$vo['brand_name']:"无品牌";
        }
        return $result;

//        $result = ShopGoodsQuoteRepo::getQuoteInfoBySearch($pager,$condition);
//        foreach($result['list'] as $k=>$vo){
//            $good = GoodsRepo::getInfo($vo['goods_id']);
//            $result['list'][$k]['brand_name'] = $good['brand_name']?$good['brand_name']:"无品牌";
//            $category = GoodsCategoryRepo::getInfo($good['cat_id']);
//            $result['list'][$k]['cat_name'] = $category['cat_name'];
//            //$result['list'][$k]['cat_id'] = $category['id'];
//            $result['list'][$k]['packing_spec'] = $good['packing_spec'];
//        }
//        return $result;
    }

    public static function getShopOrderByQuote($top){
        $shops = ShopGoodsQuoteRepo::getTopShopWidthUpdate(['is_self_run'=>0], $top);
        $shop_list = [];
        foreach ($shops as $item){
            $shop_info = ShopRepo::getInfo($item['shop_id']);
            //获取报价
            $quotes = self::getShopGoodsQuoteList(['pageSize'=>10,'page'=>1,'orderType'=>['b.add_time'=>'desc']], ['shop_id'=>$item['shop_id']]);
            $shop_info['quotes'] = $quotes['list'];
            $shop_list[] = $shop_info;
        }

        return $shop_list;
    }

    //保存
    public static function create($data)
    {
        $shop_info = ShopService::getShopById($data['shop_id']);
        $data['is_self_run'] = $shop_info['is_self_run'];
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

