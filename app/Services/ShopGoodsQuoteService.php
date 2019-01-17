<?php
namespace App\Services;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\ShopGoodsRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\ShopRepo;
use App\Repositories\UserCollectGoodsRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

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

    //商家推荐5条数据
    public static function getShopGoodsQuoteListByShopId($paper,$condition){
        return ShopGoodsQuoteRepo::getListBySearch($paper,$condition);
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

        $shopInfo = ShopRepo::getListBySearch(['page'=>1,'pageSize'=>5],['is_self_run'=>0,'is_freeze'=>0,'is_validated'=>1]);
        foreach($shopInfo['list'] as $k=>$v){
             $quotes = ShopGoodsQuoteRepo::getListBySearch(['page'=>1,'pageSize'=>5,'orderType'=>['add_time'=>'desc']],['shop_id'=>$v['id'],'is_self_run'=>0,'is_delete'=>0,'type'=>'1|2']);

                foreach($quotes['list'] as $va=>$value){
                    $goodsInfo = GoodsRepo::getInfo($value['goods_id']);
                    $quotes['list'][$va]['brand_name'] = $goodsInfo['brand_name'];
                    $quotes['list'][$va]['packing_spec'] = $goodsInfo['packing_spec'];
                    $quotes['list'][$va]['goods_full_name'] = $goodsInfo['goods_full_name'];
                    $quotes['list'][$va]['unit_name'] = $goodsInfo['unit_name'];
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

    public static function reRelease($ids)
    {
        try{
            self::beginTransaction();
                foreach ($ids as $id){
                    $info = ShopGoodsQuoteRepo::getInfo($id);
                    unset($info['id']);
                    $info['add_time'] = date('Y-m-d H:i:s');
                    $rand_number = self::setRandomNumber($info['goods_id']);
                    $info['goods_number'] = $info['total_number'] = $rand_number ? $rand_number : $info['total_number'];
                    $info['expiry_time'] = Carbon::now()->toDateString()." ".getConfig("close_quote").':00';
                    ShopGoodsQuoteRepo::create($info);
                }
            self::commit();
            return true;
        }catch (Exception $e){
            self::rollBack();
            return $e->getMessage();
        }

    }

    public static function setRandomNumber($goods_id)
    {
        $goodsInfo = GoodsRepo::getInfo($goods_id);
        #得到分类id
        if($goodsInfo){
            #获取分类配置的参数
            $config = GoodsCategoryQuoteConfigService::getList([],['cat_id'=>$goodsInfo['cat_id']]);
            if($config){
                #最大值
                $max = $config[0]['max']/$goodsInfo['packing_spec'];
                $min = $config[0]['min']/$goodsInfo['packing_spec'];
                #获取随机数
                $rand_number = mt_rand($min,$max);
                return $rand_number*$goodsInfo['packing_spec'];
            }
        }
        return false;
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
        if(empty($info)){
            return false;
        }
        $goods_detail = GoodsRepo::getInfo($info['goods_id']);
        $info['goods_desc'] = $goods_detail['goods_desc'];//商品详情
        $info['brand_name'] = $goods_detail['brand_name'];//品牌
        $info['goods_sn'] = $goods_detail['goods_sn'];//编号
        $info['unit_name'] = $goods_detail['unit_name']; //单位
        $info['packing_spec'] = $goods_detail['packing_spec'];
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
    public static function delete($ids)
    {
        self::beginTransaction();
        foreach ($ids as $id){
            $check = self::getShopGoodsQuoteById($id);
            if(!$check){
                self::rollBack();
                self::throwBizError('无法获取对应报价信息');
            }
            $res = self::modify(['id'=>$id,'is_delete'=>1]);
            if(!$res){
                self::rollBack();
                self::throwBizError('删除失败!请联系管理员');
            }
        }
        self::commit();
        return true;

    }
    //置顶
    public static function roof($ids,$is_cancel)
    {
        $is_roof = 1;
        if($is_cancel == 1){
            $is_roof = 0;
        }
        self::beginTransaction();
        foreach ($ids as $id){
            $check = self::getShopGoodsQuoteById($id);
            if(!$check){
                self::rollBack();
                self::throwBizError('无法获取对应报价信息');
            }
            $res = self::modify(['id'=>$id,'is_roof'=>$is_roof]);
            if(!$res){
                self::rollBack();
                self::throwBizError('设置失败!请联系管理员');
            }
        }
        self::commit();
        return true;

    }

    //获取当天报价条数
    public static function getQuotesCount()
    {
        $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $today_end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        $condition['add_time|>'] = date("Y-m-d H:i:s", $today_start);
        $condition['add_time|<'] = date("Y-m-d H:i:s", $today_end);
        $condition['is_delete'] = 0;
        $condition['type'] = "!"."3";
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
        $result = DB::select("
            SELECT
                G.`cat_id`
            FROM
                goods AS G
            INNER JOIN shop_goods_quote AS Q ON G.id = Q.goods_id
            WHERE
                G.is_delete = 0
            AND Q.is_delete = 0
            AND G.`cat_id` > 0
            AND Q.expiry_time > now()
            AND Q.`type` IN ('1', '2')
            AND Q.is_self_run = 1
            GROUP BY
                G.`cat_id`
        ");

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

        //自定义属性分割
        if(!empty($goodsInfo['goods_attr'])){
            $goodsAttr = explode(';',$goodsInfo['goods_attr']);
            $arr = [];
            foreach($goodsAttr as $k=>$v){
                $good_attr = explode(':',$v);
                $arr[$k]['attr'] = $good_attr[0];
                $arr[$k]['value'] = $good_attr[1];
            }

        }else{
            $arr = '';
        }

        $goodsInfo['goods_attrs'] = $arr ? $arr : '';

        $goodsInfo['activity_price'] = $ActivityInfo['shop_price'];
        $goodsInfo['activity_num'] = $ActivityInfo['goods_number'];
        $goodsInfo['delivery_place'] = $ActivityInfo['delivery_place'];
        $goodsInfo['activity_id'] = $ActivityInfo['id'];
        $goodsInfo['goods_sn'] = $ActivityInfo['goods_sn'];
        $goodsInfo['goods_name'] = $ActivityInfo['goods_name'];
        $goodsInfo['production_date'] = $ActivityInfo['production_date'];

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
        if($activityInfo['goods_number'] <= 0){
            self::throwBizError('可售数量为0,无法下单');
        }

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
        $activityInfo['unit_name'] = $goodsInfo['unit_name'];
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

    //闭市
    public static function closeQuote($condition,$data)
    {
        #先获取符合条件的报价信息
        $quote_info = ShopGoodsQuoteRepo::getList([], $condition, ['id']);
        try {
            self::beginTransaction();
            foreach ($quote_info as $k => $v) {
                #改报价截止时间
                ShopGoodsQuoteRepo::modify($v['id'], $data);

                #清除对应购物车信息
                CartService::deleteByFields(['shop_goods_quote_id' => $v['id']]);
            }
            self::commit();
            return 'success';
        } catch (Exception $e) {
            self::rollBack();
            return $e->getMessage();
        }
    }
    //获取清仓特卖未审核数量
    public static function getConsignCount($condition)
    {
        $count = ShopGoodsQuoteRepo::getTotalCount($condition);
        return $count;
    }
}

