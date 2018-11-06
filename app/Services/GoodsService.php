<?php
namespace App\Services;
use App\Repositories\ActivityPromoteRepo;
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
use App\Repositories\ShopGoodsRepo;

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
        return GoodsRepo::getInfo($id);
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
        $cartInfo =  CartRepo::cartList($userId);
        $quoteInfo =  [];
        $goodsInfo = [];
        foreach($cartInfo as $k=>$v){
            $shopGoodsQuoteInfo = ShopGoodsQuoteRepo::getInfo($v['shop_goods_quote_id']);
            if(empty($shopGoodsQuoteInfo)){
                self::throwBizError('购物车产品不存在');
            }
            $quoteInfo[$k]['goods_number'] = $shopGoodsQuoteInfo['goods_number'];
            $quoteInfo[$k]['delivery_place'] = $shopGoodsQuoteInfo['delivery_place'];
            $quoteInfo[$k]['account'] = number_format($v['goods_number'] * $v['goods_price'],2);

            //取goods表的规格
            $goodsInfo[] = GoodsRepo::getInfo($shopGoodsQuoteInfo['goods_id']);
        }
        return ['cartInfo'=>$cartInfo,'quoteInfo'=>$quoteInfo,'goodsInfo'=>$goodsInfo];
    }

    //报价表添加到购物车
    public static function searchGoodsQuote($userId,$shopGoodsQuoteId,$number){
        $addTime = Carbon::now();
//        $id = decrypt($id);
        $shopGoodsQuoteInfo =  ShopGoodsQuoteRepo::getInfo($shopGoodsQuoteId);
        if(empty($shopGoodsQuoteInfo)){
            self::throwBizError('报价信息不存在！');
        }
        if($shopGoodsQuoteInfo['goods_number'] <= 0){
            self::throwBizError('商品数量为零,无法加入购物车');
        }
        $goodsInfo = GoodsRepo::getInfo($shopGoodsQuoteInfo['goods_id']);
        if(empty($goodsInfo)){
            self::throwBizError('产品信息不存在！');
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

    //提交订单

    public static function createOrder($cartInfo_session,$userId,$userAddressId,$words,$type){
        $addTime =  Carbon::now();
        //生成的随机数
        $order_no = date('Ymd') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $userAddressMes = UserAddressRepo::getInfo($userAddressId);
        try{
            self::beginTransaction();
            //订单表
            if(!$userId['firm_id']){
                $order_status = 2;
            }else{
                $order_status = 1;
            }
            $orderInfo = [
                'order_sn'=>$order_no,
                'user_id'=>$userId['user_id'],
                'firm_id'=>$userId['firm_id'],
                'order_status'=>$order_status,
                'add_time'=>$addTime,
                'address'=>$userAddressMes['address'],
                'shop_id'=>$cartInfo_session[0]['shop_id'],
                'shop_name'=>$cartInfo_session[0]['shop_name'],
                'country'=>1,
                'zipcode'=>$userAddressMes['zipcode'],
                'mobile_phone'=>$userAddressMes['mobile_phone'],
                'province'=>$userAddressMes['province'],
                'city'=>$userAddressMes['city'],
                'district'=>$userAddressMes['district'],
                'consignee'=>$userAddressMes['consignee'],
                'postscript'=>$words?$words:''
            ];
            $orderInfoResult = OrderInfoRepo::create($orderInfo);

            //订单总金额
            $goods_amount = 0;
            foreach($cartInfo_session as $v){
                $id = $v['id'];
                //购物车生成订单
                if(!$type){
                    $cartInfo = CartRepo::getInfo($id);
                    if(empty($cartInfo)){
                        self::throwBizError('购物车商品不存在！');
                    }

                    $orderGoods = [
                        'order_id'=>$orderInfoResult['id'],
                        'shop_goods_id'=>$cartInfo['shop_goods_id'],
                        'shop_goods_quote_id'=>$cartInfo['shop_goods_quote_id'],
                        'goods_id'=>$cartInfo['goods_id'],
                        'goods_name'=>$cartInfo['goods_name'],
                        'goods_sn'=>$cartInfo['goods_sn'],
                        'goods_number'=>$cartInfo['goods_number'],
                        'goods_price'=>$cartInfo['goods_price'],
                        'add_time' => Carbon::now()
                    ];
                    OrderGoodsRepo::create($orderGoods);
                    $goods_amount += $cartInfo['goods_number'] * $cartInfo['goods_price'];

                    //删除购物车的此纪录
                    CartRepo::delete($id);
                }else{
                    //限时抢购生产订单
                    $activityPromoteInfo = ActivityPromoteRepo::getInfo($id);
                    if(empty($activityPromoteInfo)){
                        self::throwBizError('商品不存在！');
                    }
                    $orderGoods = [
                        'order_id'=>$orderInfoResult['id'],
                        'goods_id'=>$v['goods_id'],
                        'goods_name'=>$v['goods_name'],
//                        'goods_sn'=>$cartInfo['goods_sn'],
                        'goods_number'=>$v['goods_number'],
                        'goods_price'=>$v['goods_price'],
                        'add_time' => Carbon::now()
                    ];
                    OrderGoodsRepo::create($orderGoods);
                    $goods_amount += $v['goods_number'] * $v['goods_price'];
                    ActivityPromoteRepo::modify($id,['available_quantity'=>$activityPromoteInfo['$activityPromoteInfo'] - $v['goods_number']]);
                }
            }
            //更新订单总金额
            OrderInfoRepo::modify(
                $orderInfoResult['id'],
                ['goods_amount'=>$goods_amount,
                    'order_amount'=>$goods_amount,
//                    'shop_name'=>$cartInfo['shop_name']
                ]
            );
            self::commit();
            return $order_no;
        }catch (\Exception $e){
            self::rollBack();
            throw $e;
        }
    }

    //删除购物车某条商品
    public static function delCart($id){
        return CartRepo::delete($id);
    }

    //递增购物车数量
    public static function addCartGoodsNum($id){
        try{
            $cartInfo = CartRepo::getInfo($id);
            $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
            $account =  round($cartInfo['goods_number'] * $cartInfo['goods_price'] + $goodsInfo['packing_spec'] * $cartInfo['goods_price'],2);
            CartRepo::modify($id,['goods_number'=>$cartInfo['goods_number']+$goodsInfo['packing_spec']]);
            return $account;
        }catch (\Exception $e){
            throw $e;
        }
    }

    //递减购物车数量
    public static function reduceCartGoodsNum($id){
        try{
            $cartInfo = CartRepo::getInfo($id);
            $goodsInfo = GoodsRepo::getInfo($cartInfo['goods_id']);
            $account =  round($cartInfo['goods_number'] * $cartInfo['goods_price'] - $cartInfo['goods_price'] * $goodsInfo['packing_spec'],2);
            CartRepo::modify($id,['goods_number'=>$cartInfo['goods_number']-$goodsInfo['packing_spec']]);
            return $account;
        }catch (\Exception $e){
            throw $e;
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
        $id = decrypt($id);
        return CartRepo::modify($id,['goods_number'=>$cartNum]);
    }

    //物性表
    public static function goodsAttribute($condition,$page = 1,$pageSize = 1){
        return  GoodsRepo::getListBySearch(['pageSize'=>$pageSize, 'page'=>$page, 'orderType'=>['id'=>'desc']],$condition);

    }

    //物性表详情
    public static function goodsAttributeDetails($id,$page,$pageSize){
        $id = decrypt($id);
        if($id<0){
            self::throwBizError('产品信息有误');
        }
        $goodsInfo = GoodsRepo::getInfo($id);
        if(empty($goodsInfo)){
            self::throwBizError('产品信息不存在');
        }
        $shopGoodsInfo = ShopGoodsRepo::getListBySearch(['pageSize'=>$pageSize,'page'=>$page],['goods_id'=>$id]);
        $shopGoodsInfo['goodsInfo'] = $goodsInfo;
        return $shopGoodsInfo;
    }

    //通过id查抢购表数据
    public static function getActivityPromoteById($id){
        $id = decrypt($id);
        $activityPromoteInfo = ActivityPromoteRepo::getInfo($id);
        if(empty($activityPromoteInfo)){
            self::throwBizError('不存在的商品信息');
        }
    }

    //购物车数量判断
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
        if(!is_numeric($goodsNumber)){
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
            return $goods_number;
        }
        self::throwBizError('修改数量失败');

    }



}


