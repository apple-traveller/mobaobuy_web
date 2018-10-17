<?php
namespace App\Services;
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

class GoodsService
{
    use CommonService;
    //产品列表（分页）
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
            self::throwBizError('该产品已经存在！');
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

    //获取一条产品
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
    //产品列表
    public static function goodsList(){
        return GoodsRepo::goodsList();
    }

    //购车车列表
    public static function cart($userId){
        return CartRepo::cartList($userId);
    }

    //报价表添加到购物车
    public static function searchGoodsQuote($userId,$id){
        $addTime = Carbon::now();
        $id = decrypt($id);
        $shopGoodsQuoteInfo =  ShopGoodsQuoteRepo::getInfo($id);
        if(empty($shopGoodsQuoteInfo)){
            self::throwBizError('报价信息不存在！');
        }
        $cartInfo = ['user_id'=>$userId,'shop_id'=>$shopGoodsQuoteInfo['shop_id'],'shop_name'=>$shopGoodsQuoteInfo['shop_name'],'shop_goods_quote_id'=>$shopGoodsQuoteInfo['id'],'goods_id'=>$shopGoodsQuoteInfo['goods_id'],'goods_sn'=>$shopGoodsQuoteInfo['goods_sn'],'goods_name'=>$shopGoodsQuoteInfo['goods_name'],'goods_price'=>$shopGoodsQuoteInfo['shop_price'],'goods_number'=>$shopGoodsQuoteInfo['goods_number'],'add_time'=>$addTime];
        return CartRepo::create($cartInfo);
    }

    //清空购物车
    public static function clearCart($userId){
        $cartInfo = CartRepo::getList([],['user_id'=>$userId]);
        try{
            self::beginTransaction();
            foreach($cartInfo as $v){
                CartRepo::modify($v['id'],['is_invalid'=>1]);
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
//        try{
            foreach($cartIds as $v){
                $id = decrypt($v);
                $cartInfo = CartRepo::getInfo($id);
                if(empty($cartInfo)){
                    self::throwBizError('购物车产品不存在！');
                }
                $cartSession[] = $cartInfo;
            }
            return $cartSession;

//        }catch (\Exception $e){
//            throw $e;
//        }
    }

    //提交订单
    public static function createOrder($cartInfo_session,$userId,$userAddressId,$invoicesId){
        $addTime =  Carbon::now();
        //生成的随机数
        $order_no = date('Ymd') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $userAddressId = decrypt($userAddressId);
        $invoicesId = decrypt($invoicesId);
        $userAddressMes = UserAddressRepo::getInfo($userAddressId);
//        $province = RegionRepo::getInfoByFields(['region_id'=>$userAddressMes['province']]);
//        $city = RegionRepo::getInfo($userAddressMes['city']);
//        $district = RegionRepo::getInfo($userAddressMes['district']);

        try{
            self::beginTransaction();
            //订单表
            $orderInfo = ['order_sn'=>$order_no,'user_id'=>$userId,'order_status'=>1,'add_time'=>$addTime,'address'=>$userAddressMes['address'],'shop_id'=>$cartInfo_session[0]['shop_id'],'zipcode'=>$userAddressMes['zipcode'],'mobile_phone'=>$userAddressMes['mobile_phone'],'province'=>$userAddressMes['province'],'city'=>$userAddressMes['city'],'district'=>$userAddressMes['district'],'consignee'=>$userAddressMes['consignee'],'invoice_id'=>$invoicesId];
            $orderInfoResult = OrderInfoRepo::create($orderInfo);
//            'shop_name'=>$cartInfo['shop_name'],

            //订单总金额
            $goods_amount = 0;
            foreach($cartInfo_session as $v){
                $id = $v['id'];
//                decrypt($v['id']);
                $cartInfo = CartRepo::getInfo($id);
                if(empty($cartInfo)){
                    self::throwBizError('购物车产品不存在！');
                }

                $orderGoods = ['order_id'=>$orderInfoResult['id'],'shop_goods_id'=>$cartInfo['shop_goods_id'],'shop_goods_quote_id'=>$cartInfo['shop_goods_quote_id'],                   'goods_id'=>$cartInfo['goods_id'],'goods_name'=>$cartInfo['goods_name'],'goods_sn'=>$cartInfo['goods_sn'],'goods_number'=>$cartInfo['goods_number'],'goods_price'=>$cartInfo['goods_price']];
                OrderGoodsRepo::create($orderGoods);
                $goods_amount += $cartInfo['goods_number'] * $cartInfo['goods_price'];

                //删除购物车的此纪录
                CartRepo::modify($id,['is_invalid'=>1]);
            }
            //更新订单总金额
            OrderInfoRepo::modify($orderInfoResult['id'],['goods_amount'=>$goods_amount,'order_amount'=>$goods_amount,'shop_name'=>$cartInfo['shop_name']]);

            self::commit();
            return $order_no;
        }catch (\Exception $e){
            self::rollBack();
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

    //审核通过操作
    public static function egis($id){
        $id = decrypt($id);
        return OrderInfoRepo::modify($id,['order_status'=>2]);
    }

    //作废
    public static function cancel($id){
        $id = decrypt($id);
        return OrderInfoRepo::modify($id,['order_status'=>0]);
    }

    //订单详情
    public static function orderDetails($id){
        $id = decrypt($id);
        return OrderGoodsRepo::getList([],['order_id'=>$id]);
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
}


