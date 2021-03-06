<?php
namespace App\Services;
use App\Repositories\ActivityPromoteRepo;
use App\Repositories\ActivityWholesaleRepo;
use App\Repositories\BrandRepo;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\OrderInfoRepo;
use App\Repositories\OrderGoodsRepo;
use App\Repositories\RegionRepo;
use App\Repositories\ShopGoodsQuotePriceRepo;
use App\Repositories\ShopGoodsQuoteRepo;
use App\Repositories\UnitRepo;
use App\Repositories\AttributeRepo;
use App\Repositories\AttributeValueRepo;
use App\Repositories\CartRepo;
use App\Repositories\UserAddressRepo;
use App\Repositories\UserInvoicesRepo;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Repositories\HotSearchRepo;
use Illuminate\Support\Facades\DB;

class GoodsService
{
    use CommonService;
    //商品列表（分页）
    public static function getGoodsList($pager,$condition)
    {
        $rs = GoodsRepo::getListBySearch($pager,$condition);
        foreach ($rs['list'] as &$item){
            $item['goods_img_url'] = getFileUrl($item['goods_img']);
        }
        return $rs;
    }

    //无分页
    public static function getGoods($condition,$columns)
    {
        return GoodsRepo::getList([],$condition,$columns);
    }

    //验证唯一性
    public static function uniqueValidate($goods_name)
    {
        $info = GoodsRepo::getInfoByFields(['goods_name'=>$goods_name]);
        //dd($info);
        if(!empty($info)){
            self::throwBizError('该商品已经存在！');
        }
        return $info;
    }

    //添加
    public static function create($data)
    {
        return GoodsRepo::create($data);
    }

    //修改
    public static function modify($data)
    {
        return GoodsRepo::modify($data['id'],$data);
    }

    //获取一条商品
    public static function getGoodInfo($id)
    {
        $goods_info = GoodsRepo::getInfo($id);
        $cat_info = GoodsCategoryRepo::getInfo($goods_info['cat_id']);
        $goods_info['cat_name'] = $cat_info['cat_name'];
        return $goods_info;
    }

    //获取一条商品
    public static function getGoodInfoBySn($goods_sn)
    {
        $goods_info = GoodsRepo::getInfoByFields(['goods_sn'=>$goods_sn]);
        $goods_info['goods_img_url'] = getFileUrl($goods_info['goods_img']);
        return $goods_info;
    }


    /**
     * 检测商品是否存在对应的信息
     * checkGoodsExistOtherInfo
     * @param $id
     * @return bool
     */
    public static function checkGoodsExistOtherInfo($id)
    {
        //检测报价列表
        $quote_res = ShopGoodsQuoteRepo::getTotalCount(['goods_id'=>$id,'is_delete'=>0]);
        //检测限时抢购活动
        $promote_res = ActivityPromoteRepo::getTotalCount(['goods_id'=>$id,'is_delete'=>0]);
        //检测集采火拼活动
        $wholesale_res = ActivityWholesaleRepo::getTotalCount(['goods_id'=>$id,'is_delete'=>0]);
        if($quote_res > 0 || $promote_res > 0 || $wholesale_res > 0){
            return false;
        }
        return true;

    }

    //保存关键词
    public static function saveHotKeyWords($search_key)
    {
        //根据$search_key查询数据库中有没有这个关键字，如果有就是修改search_num，没有就保存
        $hot_search = HotSearchRepo::getInfoByFields(['search_key'=>$search_key]);
        try{
            if(empty($hot_search)){
                return HotSearchRepo::create(['search_key'=>$search_key]);
            }else{
                return HotSearchRepo::modify($hot_search['id'],['search_num'=>$hot_search['search_num']+1]);
            }
        }catch(\Exception $e){
            self::throwBizError($e->getMessage());
        }

    }

    //获取所有的单位列表
    public  static function getUnitList($pager,$condition)
    {
        return UnitRepo::getListBySearch($pager,$condition);
    }

    //判断属性名是否存在并返回一条
    public static  function getAttr($condition)
    {
        return AttributeRepo::getInfoByFields($condition);
    }

    //查询所有属性名
    public static  function getAttrs($condition)
    {
        return AttributeRepo::getList([],$condition);
    }

    //保存属性名
    public static function saveAttrName($data)
    {
        return AttributeRepo::create($data);
    }

    //判断属性值是否存在并返回一条
    public  static function getAttrValue($condition)
    {
        return AttributeValueRepo::getInfoByFields($condition);
    }

    //查询所有属性值
    public static  function getAttrValues($condition)
    {
        return AttributeValueRepo::getList([],$condition);
    }

    //保存属性值
    public static function saveAttrValue($data)
    {
        return AttributeValueRepo::create($data);
    }

    //web
    //商品列表
    public static function goodsList(){
        return GoodsRepo::goodsList();
    }

    //购车车列表
    public static function cart($userId){
        //当前用户购物车信息
        $cartInfo =  CartRepo::getList(['add_time'=>'desc'],['user_id'=>$userId]);
        $quoteInfo =  [];
        $goodsInfo = [];
        foreach($cartInfo as $k=>$v){
            $shopGoodsQuoteInfo = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
            if(empty($shopGoodsQuoteInfo)){
                self::throwBizError(trans('error.cart_goods_not_exist'));
            }
            $quoteInfo[$k]['goods_number'] = $shopGoodsQuoteInfo['goods_number'];
            $quoteInfo[$k]['delivery_place'] = $shopGoodsQuoteInfo['delivery_place'];
            $quoteInfo[$k]['account'] =number_format($v['goods_number'] * $v['goods_price'],2,".","");
            $quoteInfo[$k]['shop_price'] = $shopGoodsQuoteInfo['shop_price'];//基础价格
            $quoteInfo[$k]['min_limit'] = $shopGoodsQuoteInfo['min_limit'];//起售量
            $quoteInfo[$k]['prices'] = ShopGoodsQuotePriceRepo::getList(['min_num'=>'asc'],['quote_id'=>$v['shop_goods_quote_id']]);;//所有阶梯价格
            //取goods表的规格
            $goodsData = GoodsRepo::getInfo($shopGoodsQuoteInfo['goods_id']);

            $goodsInfo[] = $goodsData;
            $cartInfo[$k]['goods_name_en'] = $goodsData['goods_full_name_en'];
            $cartInfo[$k]['brand_name'] = $goodsData['brand_name'] ? $goodsData['brand_name'] : '';
        }
        return ['cartInfo'=>$cartInfo,'quoteInfo'=>$quoteInfo,'goodsInfo'=>$goodsInfo];
    }

    //报价表添加到购物车
    public static function searchGoodsQuote($userId,$shopGoodsQuoteId,$number){
        $addTime = Carbon::now();
        //$id = decrypt($id);
        $shopGoodsQuoteInfo =  ShopGoodsQuoteRepo::getInfo($shopGoodsQuoteId);

        if(empty($shopGoodsQuoteInfo)){
            self::throwBizError(trans('error.quote_info_not_exist'));
        }
        if($shopGoodsQuoteInfo['goods_number'] <= 0){
            self::throwBizError(trans('error.cannot_add_cart_tips'));
        }
        if(!empty($shopGoodsQuoteInfo['expiry_time']) &&  $shopGoodsQuoteInfo['expiry_time'] < Carbon::now()){
            self::throwBizError(trans('error.quote_expired'));
        }
        if($shopGoodsQuoteInfo['expiry_time'] != 0 &&  $shopGoodsQuoteInfo['expiry_time'] < Carbon::now()){
            self::throwBizError(trans('error.quote_expired'));
        }
        $goodsInfo = GoodsRepo::getInfo($shopGoodsQuoteInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError(trans('error.goods_info_not_exist'));
        }

        if($number > $shopGoodsQuoteInfo['goods_number']){
            self::throwBizError(trans('error.not_greater_inventory'));
        }
        //规格判断处理
        if($number % $goodsInfo['packing_spec'] == 0){
            $goodsNumber = $number;
        }else{
            if($number > $goodsInfo['packing_spec']){
                $yuNumber = $number % $goodsInfo['packing_spec'];
                $dNumber = $goodsInfo['packing_spec'] - $yuNumber;
                $goodsNumber = $number + $dNumber;
            }else{
                $goodsNumber = $goodsInfo['packing_spec'];
            }
        }
        $cartResult = CartRepo::getInfoByFields(['user_id'=>$userId,'shop_goods_quote_id'=>$shopGoodsQuoteId]);

        if($cartResult){
            if($shopGoodsQuoteInfo['goods_number'] < $cartResult['goods_number'] + $number){
                self::throwBizError(trans('error.not_greater_inventory'));
            }
            return CartRepo::modify($cartResult['id'],['goods_number'=>$cartResult['goods_number']+$number]);
        }else{
            $cartInfo = [
                'user_id'=>$userId,
                'shop_id'=>$shopGoodsQuoteInfo['shop_id'],
                'shop_name'=>$shopGoodsQuoteInfo['shop_name'],
                'shop_goods_quote_id'=>$shopGoodsQuoteInfo['id'],
                'goods_id'=>$shopGoodsQuoteInfo['goods_id'],
                'goods_sn'=>$shopGoodsQuoteInfo['goods_sn'],
                'goods_name'=>$shopGoodsQuoteInfo['goods_name'],
                'goods_price'=> ShopGoodsQuotePriceService::getPriceByNum($shopGoodsQuoteId,$goodsNumber),
                'goods_number'=>$goodsNumber,
                'add_time'=>$addTime
            ];
            return CartRepo::create($cartInfo);
        }

    }

    //查询购物车的数量
    public static function getCartCount($userId)
    {
        return CartRepo::getTotalCount(['user_id'=>$userId]);
    }

    //清空购物车
    public static function clearCart($userId){
        $cartInfo = CartRepo::getList([],['user_id'=>$userId]);
        try{
            self::beginTransaction();
            foreach($cartInfo as $v){
                CartRepo::delete($v['id']);
            }
            self::commit();
        }catch (\Exception $e){
            self::rollBack();
            throw $e;
        }

    }

    //去结算操作
    public static function toBalance($cartIds,$userId){
        $cartSession = [];
        foreach($cartIds as $v){
            $cartInfo = CartRepo::getInfo($v);
            $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
            $cartInfo['unit_name'] = $goodsInfo['unit_name'];
            if(empty($cartInfo)){
                self::throwBizError(trans('error.cart_goods_not_exist'));
            }
            $shopGoodsInfo = ShopGoodsQuoteRepo::getInfo($cartInfo['shop_goods_quote_id']);
//            if($cartInfo['goods_number'] > $shopGoodsInfo['goods_number']){
//                self::throwBizError('购买数量不能大于库存数量！');
//            }
            $cartSession[] = $cartInfo;
        }
        return $cartSession;
    }





    //删除购物车某条商品
    public static function delCart($id){
        $cartInfo = CartRepo::getInfo($id);
        if(empty($cartInfo)){
            self::throwBizError(trans('error.cart_goods_not_exist'));
        }
        return CartRepo::delete($id);
    }

    //递增购物车数量
    public static function addCartGoodsNum($id){
        try{
            $cartInfo = CartRepo::getInfo($id);
            if(empty($cartInfo)){
                self::throwBizError(trans('error.cart_goods_not_exist'));
            }
            $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
            if(empty($goodsInfo)){
                self::throwBizError(trans('error.goods_info_not_exist'));
            }
            //判断数量对应的价格
            $goods_number = $cartInfo['goods_number']+$goodsInfo['packing_spec'];
            $price = ShopGoodsQuotePriceService::getPriceByNum($cartInfo['shop_goods_quote_id'],$goods_number);

            $account =  number_format($goods_number*$price,2,".","");
            CartRepo::modify($id,['goods_number'=>$goods_number,'goods_price'=>$price]);
            return ['account'=>$account,'goods_number'=>$goods_number,'goods_price'=>$price];
        }catch (\Exception $e){
            self::throwBizError($e->getMessage());
        }
    }

    //递减购物车数量
    public static function reduceCartGoodsNum($id){
        try{
            $cartInfo = CartRepo::getInfo($id);
            if(empty($cartInfo)){
                self::throwBizError(trans('error.goods_info_not_exist'));
            }
            $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
            if(empty($goodsInfo)){
                self::throwBizError(trans('error.goods_info_not_exist'));
            }
            if($cartInfo['goods_number']<=$goodsInfo['packing_spec']){
                self::throwBizError(trans('error.goods_cannot_reduced'));
            }
            //判断数量对应的价格
            $goods_number = $cartInfo['goods_number']-$goodsInfo['packing_spec'];
            $price = ShopGoodsQuotePriceService::getPriceByNum($cartInfo['shop_goods_quote_id'],$goods_number);

            $account =  number_format($goods_number*$price,2,".","");
            CartRepo::modify($id,['goods_number'=>$goods_number,'goods_price'=>$price]);
            return ['account'=>$account,'goods_number'=>$goods_number,'goods_price'=>$price];
        }catch (\Exception $e){
            self::throwBizError($e->getMessage());
        }
    }

    //订单列表
    public static function orderList($userId){
        $orderInfo = OrderInfoRepo::orderList($userId);
        $arr = [];
        foreach($orderInfo as $k=>$v){
            $orderGoodsInfo = OrderGoodsRepo::getList([],['order_id'=>$v->id]);
            $arr[] = $orderGoodsInfo;

        }
        return ['orderInfo'=>$orderInfo,'orderGoodsInfo'=>$arr];
    }

    //显示收获地址
    public static function showAddress($userId){
        return UserAddressRepo::getList([],['user_id'=>$userId]);
    }

    //获取发票信息
    public static function getInvoices($id){
        return UserInvoicesRepo::getList([],['user_id'=>$id]);
    }

    //修改购物车数量
    public static function editCartNum($id,$cartNum){
        return CartRepo::modify($id,['goods_number'=>$cartNum]);
    }

    //物性表
    public static function goodsAttribute($condition,$page = 1,$pageSize = 1){
        $res = GoodsRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['id'=>'desc']],$condition);

        if(!empty($res)){
            foreach ($res['list'] as $k=>$v){
                $brand_info = BrandRepo::getInfo($v['brand_id']);
                if(!empty($brand_info)){
                    $res['list'][$k]['brand_name_en'] = $brand_info['brand_name_en'];
                }
            }
        }
        return $res;
    }

    //物性表详情
    public static function goodsAttributeDetails($id,$page,$pageSize){
        if(!is_numeric($id)){
            $id = decrypt($id);
        }

        if($id<0){
            self::throwBizError(trans('error.goods_info_tips'));
        }
        $goodsInfo = GoodsRepo::getInfo($id);
        if(!empty($goodsInfo)){
            $brand_info = BrandRepo::getInfo($goodsInfo['brand_id']);
            if(!empty($brand_info)){
                $goodsInfo['brand_name_en'] = $brand_info['brand_name_en'];
            }
        }
        if(empty($goodsInfo)){
            self::throwBizError(trans('error.goods_not_exist'));
        }
        $shopGoodsInfo = ShopGoodsQuoteRepo::getListBySearch(['pageSize'=>$pageSize,'page'=>$page],['goods_id'=>$id,'is_delete'=>0]);
        if(!empty($shopGoodsInfo)){
            foreach ($shopGoodsInfo['list'] as $k=>$v){
                $shopInfo = ShopService::getShopById($v['shop_id']);
                $shopGoodsInfo['list'][$k]['shop_name_en'] = $shopInfo['shop_name_en'];
            }
        }
        $shopGoodsInfo['goodsInfo'] = $goodsInfo;
        return $shopGoodsInfo;
    }

    //购物车blur数量判断
    public static function checkListenCartInput($id,$goodsNumber){
        $cartInfo = CartRepo::getInfo($id);
        if(empty($cartInfo)){
            self::throwBizError(trans('error.cart_goods_not_exist'));
        }
        $shopGoodsQuoteInfo = ShopGoodsQuoteRepo::getInfo($cartInfo['shop_goods_quote_id']);
        if(empty($shopGoodsQuoteInfo)){
            self::throwBizError(trans('error.quote_info_not_exist'));
        }
        $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError(trans('error.quote_info_not_exist'));
        }
        if(!is_numeric($goodsNumber) || $goodsNumber < 0){
            self::throwBizError(trans('error.num_is_positive_int'));
        }

        if($goodsNumber > $shopGoodsQuoteInfo['goods_number']){
            self::throwBizError(trans('error.not_greater_inventory'));
        }
        if($goodsNumber < $goodsInfo['packing_spec']){
            self::throwBizError(trans('error.num_not_less_spec'));
        }

        //规格判断处理
        if($goodsNumber % $goodsInfo['packing_spec'] == 0){
            $goods_number = $goodsNumber;
        }else{
            self::throwBizError(trans('error.num_wrong_tips'));
        }

        //此时 数量已经经过判断 正确 判断该数量对应的价格
        $price = ShopGoodsQuotePriceService::getPriceByNum($cartInfo['shop_goods_quote_id'],$goods_number);

        $cartResult = CartRepo::modify($id,['goods_number'=>$goods_number,'goods_price'=>$price]);

        if($cartResult){
            $cartResult['account'] = $cartResult['goods_number'] * $cartResult['goods_price'];

            return $cartResult;
        }
        self::throwBizError(trans('error.fail'));
    }

    public static function productTrend($goodsId,$type=1,$condition){
        $goodsInfo = GoodsRepo::getInfo($goodsId);
        if(empty($goodsInfo)){
            self::throwBizError(trans('error.goods_info_tips'));
        }

        $goodsList = ShopGoodsQuoteRepo::getList(['add_time'=>'asc'],['goods_id'=>$goodsId]);
        if(empty($goodsList)){
            return [];
        }

//        $sql = DB::statement("select *,left(add_time,10) as t,max(shop_price) as max_p,min(shop_price) as min_p from shop_goods_quote GROUP BY t");


        $timeArr = [];
        $priceArr = [];
        $newData = ShopGoodsQuoteRepo::productTrend([],$condition,$type);
        if(!empty($newData)){
            foreach($newData as $v){
                $timeArr[] = $v['t'];
                $priceArr[] = [$v['min_price'],$v['max_price'],$v['min_price'],$v['max_price']];
            }
        }
        $data['time'] = $timeArr;
        $data['price'] = $priceArr;
        return $data;
    }


    public static function productTrendApi($goodsId){
        $goodsInfo = GoodsRepo::getInfo($goodsId);
        if(empty($goodsInfo)){
            self::throwBizError(trans('error.goods_info_not_exist'));
        }
        //$goodsList = ShopGoodsQuoteRepo::getList([],['goods_id'=>$goodsId]);
        $goodsList = ShopGoodsQuoteRepo::getListBySearch(['pageSize'=>7, 'page'=>1, 'orderType'=>['id'=>'desc']],['goods_id'=>$goodsId]);
        if(empty($goodsList)){
            return [];
        }
        $time = [];
        $price = [];
        foreach($goodsList['list'] as $k=>$v){
            $time[] = substr(substr($v['add_time'],0,10),-5);//取时间的月份和天数
            $price[] = $v['shop_price'];
        }
        $data['time'] = $time;
        $data['price'] = $price;
        return $data;
    }
    //获取特殊规格的商品
    public static function getSpecialGoods()
    {
        $res = GoodsRepo::getListBySearch([],['is_delete'=>0,'is_special'=>1]);
        return $res;
    }

    /**
     * 如果品牌名称改变同步修改品牌下所有商品的信息
     * syncGoodsByBrand
     * @param $brand_id
     * @param string $brand_name
     * @param string $brand_name_en
     * @return bool
     */
    public static function syncGoodsByBrand($brand_id,$brand_name='',$brand_name_en='')
    {
        $goodsList = GoodsRepo::getList([],['brand_id'=>$brand_id,'is_delete'=>0]);
        if(!empty($goodsList)){
            foreach ($goodsList as $k=>$v){
                $update_data = [];
                $update_data['id'] = $v['id'];
                if(!empty($brand_name)){
                    $update_data['brand_name'] = $brand_name;
                    $update_data['goods_full_name'] = $brand_name.' '.$v['goods_content'].' '.$v['goods_name'];
                }
                if(!empty($brand_name_en)){
                    $update_data['goods_full_name_en'] = $brand_name_en." ".$v['goods_content_en']." ".$v['goods_name_en'];
                }
                self::modify($update_data);
            }
        }
        return true;
    }

    public static function syncGoodsByUnit($unit_id,$unit_name)
    {
        $goodsList = GoodsRepo::getList([],['unit_id'=>$unit_id,'is_delete'=>0]);

        if(!empty($goodsList)){
            foreach ($goodsList as $k=>$v){
                $update_data = [];
                $update_data['id'] = $v['id'];
                $update_data['unit_name'] = $unit_name;
                self::modify($update_data);
            }
        }
        return true;
    }
}


