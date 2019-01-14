<?php
namespace App\Services;
use App\Repositories\ActivityPromoteRepo;
use App\Repositories\ActivityWholesaleRepo;
use App\Repositories\GoodsCategoryRepo;
use App\Repositories\GoodsRepo;
use App\Repositories\OrderInfoRepo;
use App\Repositories\OrderGoodsRepo;
use App\Repositories\RegionRepo;
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
        return GoodsRepo::getListBySearch($pager,$condition);
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

    /**
     * 检测商品是否存在对应的信息
     * checkGoodsExistOtherInfo
     * @param $id
     * @return bool
     */
    public static function checkGoodsExistOtherInfo($id)
    {
        //检测报价列表
        $quote_res = ShopGoodsQuoteRepo::getTotalCount(['goods_id'=>$id]);
        //检测限时抢购活动
        $promote_res = ActivityPromoteRepo::getTotalCount(['goods_id'=>$id]);
        //检测集采火拼活动
        $wholesale_res = ActivityWholesaleRepo::getTotalCount(['goods_id'=>$id]);
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
                self::throwBizError('购物车商品不存在');
            }
            $quoteInfo[$k]['goods_number'] = $shopGoodsQuoteInfo['goods_number'];
            $quoteInfo[$k]['delivery_place'] = $shopGoodsQuoteInfo['delivery_place'];
            $quoteInfo[$k]['account'] =number_format($v['goods_number'] * $v['goods_price'],2,".","");
            //取goods表的规格
            $goodsData = GoodsRepo::getInfo($shopGoodsQuoteInfo['goods_id']);
            $goodsInfo[] = $goodsData;

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
            self::throwBizError('报价信息不存在！');
        }
        if($shopGoodsQuoteInfo['goods_number'] <= 0){
            self::throwBizError('商品数量为零,无法加入购物车');
        }
        if(!empty($shopGoodsQuoteInfo['expiry_time']) &&  $shopGoodsQuoteInfo['expiry_time'] < Carbon::now()){
            self::throwBizError('报价已过期');
        }
        if($shopGoodsQuoteInfo['expiry_time'] != 0 &&  $shopGoodsQuoteInfo['expiry_time'] < Carbon::now()){
            self::throwBizError('报价已过期');
        }
        $goodsInfo = GoodsRepo::getInfo($shopGoodsQuoteInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('商品信息不存在！');
        }

        if($number > $shopGoodsQuoteInfo['goods_number']){
            self::throwBizError('不能大于库存数量');
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
                self::throwBizError('购物车数量不能大于库存数量');
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
                'goods_price'=>$shopGoodsQuoteInfo['shop_price'],
                'goods_number'=>$goodsNumber,'add_time'=>$addTime];
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
                self::throwBizError('购物车商品不存在！');
            }
            $shopGoodsInfo = ShopGoodsQuoteRepo::getInfo($cartInfo['shop_goods_quote_id']);
            if($cartInfo['goods_number'] > $shopGoodsInfo['goods_number']){
                self::throwBizError('购买数量不能大于库存数量！');
            }
            $cartSession[] = $cartInfo;
        }
        return $cartSession;
    }





    //删除购物车某条商品
    public static function delCart($id){
        $cartInfo = CartRepo::getInfo($id);
        if(empty($cartInfo)){
            self::throwBizError('购物车商品不存在');
        }
        return CartRepo::delete($id);
    }

    //递增购物车数量
    public static function addCartGoodsNum($id){
        try{
            $cartInfo = CartRepo::getInfo($id);
            if(empty($cartInfo)){
                self::throwBizError('购物车信息不存在');
            }
            $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
            if(empty($goodsInfo)){
                self::throwBizError('商品信息不存在');
            }
            $account =  number_format($cartInfo['goods_number'] * $cartInfo['goods_price'] + $goodsInfo['packing_spec'] * $cartInfo['goods_price'],2,".","");
            CartRepo::modify($id,['goods_number'=>$cartInfo['goods_number']+$goodsInfo['packing_spec']]);
            return ['account'=>$account,'goods_number'=>$cartInfo['goods_number']+$goodsInfo['packing_spec']];
        }catch (\Exception $e){
            self::throwBizError($e->getMessage());
        }
    }

    //递减购物车数量
    public static function reduceCartGoodsNum($id){
        try{
            $cartInfo = CartRepo::getInfo($id);
            if(empty($cartInfo)){
                self::throwBizError('商品信息不存在');
            }
            $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
            if(empty($goodsInfo)){
                self::throwBizError('商品信息不存在');
            }
            if($cartInfo['goods_number']<=$goodsInfo['packing_spec']){
                self::throwBizError('该商品不能减少了');
            }
            $account =  number_format($cartInfo['goods_number'] * $cartInfo['goods_price'] - $cartInfo['goods_price'] * $goodsInfo['packing_spec'],2,".","");
            CartRepo::modify($id,['goods_number'=>$cartInfo['goods_number']-$goodsInfo['packing_spec']]);
            return ['account'=>$account,'goods_number'=>$cartInfo['goods_number']-$goodsInfo['packing_spec']];;
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
        return  GoodsRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['id'=>'desc']],$condition);

    }

    //物性表详情
    public static function goodsAttributeDetails($id,$page,$pageSize){
        if(!is_numeric($id)){
            $id = decrypt($id);
        }

        if($id<0){
            self::throwBizError('商品信息有误');
        }
        $goodsInfo = GoodsRepo::getInfo($id);
        if(empty($goodsInfo)){
            self::throwBizError('商品信息不存在');
        }
        $shopGoodsInfo = ShopGoodsQuoteRepo::getListBySearch(['pageSize'=>$pageSize,'page'=>$page],['goods_id'=>$id]);
        $shopGoodsInfo['goodsInfo'] = $goodsInfo;
        return $shopGoodsInfo;
    }

    //购物车blur数量判断
    public static function checkListenCartInput($id,$goodsNumber){
        $cartInfo = CartRepo::getInfo($id);
        if(empty($cartInfo)){
            self::throwBizError('购物车数据有误');
        }
        $shopGoodsQuoteInfo = ShopGoodsQuoteRepo::getInfo($cartInfo['shop_goods_quote_id']);
        if(empty($shopGoodsQuoteInfo)){
            self::throwBizError('报价数据有误');
        }
        $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('商品数据有误');
        }
        if(!is_numeric($goodsNumber) || $goodsNumber < 0){
            self::throwBizError('数量只能输入正整数');
        }

        if($goodsNumber > $shopGoodsQuoteInfo['goods_number']){
            self::throwBizError('数量超过库存数');
        }
        if($goodsNumber < $goodsInfo['packing_spec']){
            self::throwBizError('数量不能小于商品规格');
        }

        //规格判断处理
        if($goodsNumber % $goodsInfo['packing_spec'] == 0){
            $goods_number = $goodsNumber;
        }else{
            self::throwBizError('数量有误，请重新输入');
        }
        $cartResult = CartRepo::modify($id,['goods_number'=>$goods_number]);
        if($cartResult){
            $cartResult['account'] = $cartResult['goods_number'] * $cartResult['goods_price'];
            return $cartResult;
        }
        self::throwBizError('修改数量失败');

    }

    public static function productTrend($goodsId,$type=1,$condition){
        $goodsInfo = GoodsRepo::getInfo($goodsId);
        if(empty($goodsInfo)){
            self::throwBizError('商品信息有误');
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
            self::throwBizError('商品信息有误');
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

}


