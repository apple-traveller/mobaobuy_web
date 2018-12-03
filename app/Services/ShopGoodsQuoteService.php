<?php
namespace App\Services;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\ShopGoodsRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\ShopRepo;
use App\Repositories\UserCollectGoodsRepo;
use Illuminate\Support\Facades\DB;
class ShopGoodsQuoteService
{
    use CommonService;

    //获取报价列表
    public static function goodsQuoteList()
    {
        return ShopGoodsQuoteRepo::goodsQuoteList();
    }

    public static function getQuoteByWebSearch($pager, $condition)
    {
        $result = ShopGoodsQuoteRepo::getQuoteInfoBySearch($pager, $condition);

        foreach ($result['list'] as $k => $vo) {
            $result['list'][$k]['brand_name'] = $vo['brand_name'] ? $vo['brand_name'] : "无品牌";
        }
        //获取筛选过滤信息 $t 1自营报价 2品牌直售   is_self_run = 1自营
        $con['b.is_self_run'] = 1;
        $con['b.is_delete'] = 0;
        if (!isset($condition['b.type'])) {
            $con['b.type'] = '1|2';
        }else{
            $con['b.type'] = $condition['b.type'];
        }
        //1、获取分类
        $cates = ShopGoodsQuoteRepo::getQuoteCategory($con);
        if (!empty($cates)) {
            $filter['cates'] = GoodsCategoryService::getCatesByCondition(['id' => implode('|', $cates)]);
        } else {
            $filter['cates'] = [];
        }
        //2、获取品牌
        $brands = ShopGoodsQuoteRepo::getQuoteBrand($con);
        if (!empty($brands)) {
            $brand_list = BrandService::getBrandList([], ['id' => implode('|', $brands)]);
            $filter['brands'] = $brand_list['list'];
        } else {
            $filter['brands'] = [];
        }
        //3、获取发货地
        $con_region['is_self_run'] = $con['b.is_self_run'];
        $con_region['type'] = $con['b.type'];
        $con_region['is_delete'] = $con['b.is_delete'];
        $cities = ShopGoodsQuoteRepo::getQuoteCity($con_region);
        if (!empty($cities)) {
            $city_list = RegionService::getList([], ['region_id' => implode('|', $cities)]);
            $filter['city_list'] = $city_list;
        } else {
            $filter['city_list'] = [];
        }

        $result['filter'] = $filter;
        return $result;
    }

    //分页
    public static function getShopGoodsQuoteList($pager, $condition)
    {
        $result = ShopGoodsQuoteRepo::getQuoteInfoBySearch($pager, $condition);
        foreach ($result['list'] as $k => $vo) {
            $result['list'][$k]['brand_name'] = $vo['brand_name'] ? $vo['brand_name'] : "无品牌";
        }
        return $result;
    }

    //不分页
    public static function getShopGoodsQuoteListByFields($order,$condition)
    {
        return ShopGoodsQuoteRepo::getQuoteInfoByFields($order,$condition);
    }

    //分页
    public static function getShopGoodsQuoteListByAjax($pager,$condition)
    {

        $result = ShopGoodsQuoteRepo::getListBySearch($pager,$condition);
        return $result;
    }

    public static function getShopOrderByQuote($top){
//        $shops = ShopGoodsQuoteRepo::getTopShopWidthUpdate(['is_self_run'=>0], $top);
////        dump($shops);
//        $shop_list = [];
//        foreach ($shops as $item) {
//            $shop_info = ShopRepo::getInfo($item['shop_id']);
//            //获取报价
//            $quotes = self::getShopGoodsQuoteList(['pageSize' => 10, 'page' => 1, 'orderType' => ['b.add_time' => 'desc']], ['shop_id' => $item['shop_id'],'is_self_run'=>0]);
//            $shop_info['quotes'] = $quotes['list'];
//            $shop_list[] = $shop_info;
//        }
//        dd($shop_list);
//        return $shop_list;

        $shopInfo = ShopRepo::getListBySearch(['page'=>1,'pageSize'=>5],['is_self_run'=>0]);
        foreach($shopInfo['list'] as $k=>$v){
             $quotes = ShopGoodsQuoteRepo::getListBySearch(['page'=>1,'pageSize'=>5],['shop_id'=>$v['id'],'is_self_run'=>0]);

                foreach($quotes['list'] as $va=>$value){
                    $goodsInfo = GoodsRepo::getInfo($value['goods_id']);
                    $quotes['list'][$va]['brand_name'] = $goodsInfo['brand_name'];
                    $quotes['list'][$va]['packing_spec'] = $goodsInfo['packing_spec'];
                    $quotes['list'][$va]['goods_full_name'] = $goodsInfo['goods_full_name'];
                    $cateInfo =  GoodsCategoryRepo::getInfo($goodsInfo['cat_id']);
                    $quotes['list'][$va]['cat_name'] = $cateInfo['cat_name'];
                }
                $shopInfo['list'][$k]['quotes'] = $quotes['list'];
        }
        return $shopInfo['list'];
    }

    //保存
    public static function create($data)
    {
        $shop_info = ShopService::getShopById($data['shop_id']);
        $data['is_self_run'] = $shop_info['is_self_run'];//是否自营
        $goods_info = GoodsRepo::getInfo($data['goods_id']);
        $data['goods_name'] = $goods_info['goods_full_name'];
        //dd($data);
        return ShopGoodsQuoteRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return ShopGoodsQuoteRepo::modify($data['id'], $data);
    }

    //获取一条数据
    public static function getShopGoodsQuoteById($id)
    {
        $info = ShopGoodsQuoteRepo::getInfo($id);
        $goods_detail = GoodsRepo::getInfo($info['goods_id']);
        $info['goods_desc'] = $goods_detail['goods_desc'];//商品详情
        $info['brand_name'] = $goods_detail['brand_name'];//品牌
        $info['goods_sn'] = $goods_detail['goods_sn'];//编号
        $info['unit_name'] = $goods_detail['unit_name']; //单位
        $info['packing_spec'] = $goods_detail['packing_spec'];//包装规格
        $info['packing_unit'] = $goods_detail['packing_unit'];//包装单位
        $arr = explode(";", $goods_detail['goods_attr']);
        $info['goods_attr'] = $arr;
        $info['goods_full_name'] = $goods_detail['goods_full_name'];
        $info['goods_content'] = $goods_detail['goods_content'];
        $cat_detail = GoodsCategoryRepo::getInfo($goods_detail['cat_id']);
        $info['cat_id'] = $goods_detail['cat_id'];//商品类型id
        $info['cat_name'] = $cat_detail['cat_name'];//商品类型
        return $info;
    }

    public static function ShopGoodsQuoteById($id)
    {
        return ShopGoodsQuoteRepo::getInfo($id);

    }

    //删除
    public static function delete($id)
    {
        return ShopGoodsQuoteRepo::delete($id);
    }

    //获取当天报价条数
    public static function getQuotesCount()
    {
        //截止时间大于当天时间即可
        $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $today_end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        $condition['expiry_time|>'] = date("Y-m-d H:i:s", $today_end);
        return $quotes = ShopGoodsQuoteRepo::getTotalCount($condition);
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


    /**
     * 确认订单时改变库存
     * @param $order_id
     * @return bool
     * @throws \Exception
     */
    public static function updateStock($order_id)
    {
        $goodsList = OrderInfoService::getOrderGoodsByOrderId($order_id);
        $check = [];
        self::beginTransaction();
        foreach ($goodsList as $k => $v) {
            $goodInfo = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
            $new_num = $goodInfo['goods_number'] - $v['goods_number'];
            if ($new_num < 0) {
                return false;
            }
            $data = [
                'goods_number' => $new_num
            ];
            $check[] = ShopGoodsQuoteRepo::modify($goodInfo['id'], $data);
        }
        if (count($goodsList) == count($check)) {
            self::commit();
            return true;
        }
        self::rollBack();
    }

    //查询所有的报价商品所属的分类信息(微信小程序接口)
    public static function getShopGoodsQuoteCates()
    {
        $result = DB::select('select `cat_id` from goods as G left join shop_goods_quote as Q  on G.id=Q.goods_id group by `cat_id`');
        //将sql查询出来的对象转数组
        $cates_id = [];
        foreach ($result as $vo) {
            $cates_id[] = $vo->cat_id;
        }
        $cates = GoodsCategoryService::getCatesByCondition(['id' => implode('|', $cates_id)]);
        return $cates;
    }

    public static function detail($id,$userId)
    {
        $id = decrypt($id);
        $ActivityInfo =  ShopGoodsQuoteRepo::getInfo($id);
        if(empty($ActivityInfo)){
            self::throwBizError('清仓商品不存在');
        }
        $goodsInfo = GoodsRepo::getInfo($ActivityInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('商品不存在');
        }

        $goodsInfo['activity_price'] = $ActivityInfo['shop_price'];
        $goodsInfo['activity_num'] = $ActivityInfo['goods_number'];
        $goodsInfo['delivery_place'] = $ActivityInfo['delivery_place'];
        $goodsInfo['activity_id'] = $ActivityInfo['id'];
        $goodsInfo['goods_sn'] = $ActivityInfo['goods_sn'];
        $goodsInfo['goods_name'] = $ActivityInfo['goods_name'];
        //商品市场价
        $goodsList = GoodsRepo::getList([],['id'=>$ActivityInfo['goods_id']]);
        $goodsInfo['goodsList'] = $goodsList;

        //商品是否已收藏
        $collectGoods= UserCollectGoodsRepo::getInfoByFields(['user_id'=>$userId,'goods_id'=>$ActivityInfo['goods_id']]);
        if(empty($collectGoods)){
            $goodsInfo['collectGoods'] = 0;
        }else{
            $goodsInfo['collectGoods'] = 1;
        }
        return $goodsInfo;
    }

    public static function detailApi($id,$userId)
    {
        $ActivityInfo =  ShopGoodsQuoteRepo::getInfo($id);
        if(empty($ActivityInfo)){
            self::throwBizError('清仓商品不存在');
        }
        $goodsInfo = GoodsRepo::getInfo($ActivityInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('商品不存在');
        }

        $goodsInfo['activity_price'] = $ActivityInfo['shop_price'];
        $goodsInfo['activity_num'] = $ActivityInfo['goods_number'];
        $goodsInfo['delivery_place'] = $ActivityInfo['delivery_place'];
        $goodsInfo['activity_id'] = $ActivityInfo['id'];
        $goodsInfo['goods_sn'] = $ActivityInfo['goods_sn'];
        $goodsInfo['goods_name'] = $ActivityInfo['goods_name'];
        //商品市场价
        $goodsList = GoodsRepo::getList([],['id'=>$ActivityInfo['goods_id']]);
        $goodsInfo['goodsList'] = $goodsList;

        //商品是否已收藏
        $collectGoods= UserCollectGoodsRepo::getInfoByFields(['user_id'=>$userId,'goods_id'=>$ActivityInfo['goods_id']]);
        if(empty($collectGoods)){
            $goodsInfo['collectGoods'] = 0;
        }else{
            $goodsInfo['collectGoods'] = 1;
        }
        return $goodsInfo;
    }

    //清仓特卖 立即下单
    public static function toBalance($goodsId,$activityId,$goodsNum,$userId){
        $goodsInfo = GoodsRepo::getInfo($goodsId);
        $activityInfo = ShopGoodsQuoteRepo::getInfo($activityId);

        if($goodsNum % $goodsInfo['packing_spec'] == 0){
            $goodsNumber = $goodsNum;
        }else{
            if($goodsNum > $goodsInfo['packing_spec']){
                $yuNumber = $goodsNum % $goodsInfo['packing_spec'];
                $dNumber = $goodsInfo['packing_spec'] - $yuNumber;
                $goodsNumber = $goodsNum + $dNumber;
            }else{
                $goodsNumber = $goodsInfo['packing_spec'];
            }
        }

        //商品信息
        $activityInfo['goods_number'] = $goodsNumber;
        $activityInfo['goods_price'] = $activityInfo['shop_price'];
        $activityInfo['amount'] = $goodsNumber * $activityInfo['shop_price'];
        $activityArr = [];
        $activityArr[] = $activityInfo;
        return $activityArr;
    }

    //
    public static function checkStoreExistQuote($store_id)
    {
        $res = ShopGoodsQuoteRepo::getTotalCount(['shop_store_id'=>$store_id]);
        if($res>0){
            return true;
        }
        return false;
    }
}

