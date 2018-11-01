<?php

namespace App\Http\Controllers\Web;
use App\Repositories\CartRepo;
use App\Services\CartService;
use App\Services\GoodsService;
use App\Services\UserAddressService;
use App\Services\UserInvoicesService;
use App\Services\UserRealService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Support\Facades\Session;
use App\Services\GoodsCategoryService;
use App\Services\BrandService;
use App\Services\RegionService;
use function App\Helpers\createPage;
class GoodsController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function  index(){

    }

    //产品列表
    public function goodsList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
        $price_bg1 = $request->input("price_bg1",1);
        $orderType = $request->input("orderType","id:asc");
        $condition = [];
        //$userId = session('_web_user_id');//判断用户是否登录
        if(!empty($orderType)){
            $order = explode(":",$orderType);
        }

        if(empty($lowest)&&empty($highest)){
            $condition = [];
        }
        if($lowest=="" && $highest!=""){
            $condition['shop_price|<'] = $highest;
        }
        if($highest=="" && $lowest!=""){
            $condition['shop_price|<'] = $lowest;
        }
        if($lowest!="" && $highest!=""&&$lowest<$highest){
            $condition['shop_price|<'] = $highest;
            $condition['shop_price|>'] = $lowest;
        }
        if($lowest>$highest){
            $condition['shop_price|<'] = $lowest;
        }
        $pageSize = 10;
        $userId = session('_web_user_id');
        $cart_count = GoodsService::getCartCount($userId);
        //产品报价列表
        $goodsList= ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>[$order[0]=>$order[1]]],$condition);
        //产品分类
        $cate = GoodsCategoryService::getCatesByGoodsList($goodsList['list']);
        //产品品牌
        $brand = BrandService::getBrandsByGoodsList($goodsList['list']);
        //发货地
        $delivery_place = RegionService::getRegionsByGoodsList($goodsList['list']);
        //dd($delivery_place);
        return $this->display("web.goods.goodsList",[
            'goodsList'=>$goodsList['list'],
            'total'=>$goodsList['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'orderType'=>$orderType,
            'cart_count'=>$cart_count,
            'lowest'=>$lowest,
            'highest'=>$highest,
            'price_bg1'=>$price_bg1,
            'cate'=>$cate,
            'brand'=>$brand,
            'delivery_place'=>$delivery_place
        ]);
    }

    //根据条件范围收索产品(ajax)
    public function goodsListByCondition(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $brand_name = $request->input("brand_name","");
        $cate_id = $request->input('cate_id',"");
        $place_id = $request->input('place_id',"");
        $condition = [];
        if(!empty($brand_name)){
            $goods_id = BrandService::getGoodsIds($brand_name);
            $condition['goods_id'] = implode('|',$goods_id);
        }
        if(!empty($cate_id)){
            $goods_id = GoodsCategoryService::getGoodsIds($cate_id);
            $condition['goods_id'] = implode('|',$goods_id);
        }
        if(!empty($place_id)){
            $condition['place_id'] = $place_id;
        }
        $pageSize = 2;
        $goodsList= ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currpage],$condition);
        if(empty($goodsList['list'])){
            return $this->result("",400,'error');
        }else{
            return $this->result(['list'=>$goodsList['list'],'currpage'=>$currpage,'total'=>$goodsList['total'],'pageSize'=>$pageSize],200,'success');
        }
    }

    //产品详情
    public function goodsDetail(Request $request)
    {
        $id = $request->input("id");
        $shop_id = $request->input("shop_id");
        $good_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $currpage = $request->input("currpage", 1);
        $goods_id = $good_info['goods_id'];
        $condition = [
            'shop_id' => $shop_id,
            'goods_id' => $goods_id
        ];
        $pageSize = 10;
        $currpage = $request->input("currpage");
        $userId = session('_web_user_id');
        $cart_count = GoodsService::getCartCount($userId);
        $goodList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize' => $pageSize, 'page' => $currpage, 'orderType' => ['add_time' => 'desc']], $condition);
        //dd($goodList);
        return $this->display("web.goods.goodsDetail", [
            'good_info' => $good_info,
            'goodsList' => $goodList['list'],
            'total' => $goodList['total'],
            'currpage' => $currpage,
            'pageSize' => $pageSize,
            'id' => $id,
            'shop_id' => $shop_id,
            'cart_count'=>$cart_count
        ]);
    }

    //购物车
    public function cart(Request $request){
        $userId = session('_web_user_id');
        if(session('_curr_deputy_user')['is_firm']){
            $userId = session('_curr_deputy_user')['firm_id'];
        }

        $invoiceInfo = UserRealService::getInfoByUserId($userId);
        if (empty($invoiceInfo)){
            return $this->error('您还没有实名认证，不能下单');
        }
        if ($invoiceInfo['review_status'] != 1 ){
            return $this->error('您的实名认证还未通过，不能下单');
        }

        if($request->isMethod('get')){
            try{
                $cartInfo = GoodsService::cart($userId);
                return $this->display('web.goods.cart',compact('cartInfo'));
            }catch(\Exception $e){
                return $this->error($e->getMessage());
            }
        }else{
            //报价表添加到购物车.
            $id = $request->input('id');
            $number = $request->input('number');
            try{
                GoodsService::searchGoodsQuote($userId,$id,$number);
                $count = GoodsService::getCartCount($userId);
                return $this->success('加入购物车成功',"",$count);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
    }

    //删除购物车商品
    public function delCart(Request $request){
        $id = $request->input('id');
        try{
            GoodsService::delCart($id);
            return $this->success();
        }catch(\Exection $e){
            return $this->error($e->getMessage());
        }
    }

    //递加产品数量
    public function addCartGoodsNum(Request $request){
        $id = $request->input('id');
        try{
             $account = GoodsService::addCartGoodsNum($id);
             return $this->success('','',$account);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //递减产品数量
    public function reduceCartGoodsNum(Request $request){
        $id = $request->input('id');
        try{
            $account = GoodsService::reduceCartGoodsNum($id);
            return $this->success('','',$account);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //清空购物车
    public function clearCart(){
        $userId = session('_web_user_id');
        try{
            GoodsService::clearCart($userId);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //购物车 去结算
    public function toBalance(Request $request){
        $cartIds = $request->input('cartId');
        $userId = session('_web_user_id');
        try{
            $cartSession = GoodsService::toBalance($cartIds,$userId);
            session()->put('cartSession',$cartSession);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    /**
     * 订单维护页面
     * @return GoodsController|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmOrder(){
        $info = session('_curr_deputy_user');
        $userInfo = session('_web_user');
        try{

            // 判断开票信息 地址可用
            $invoiceInfo = UserRealService::getInfoByUserId($userInfo['id']);
            if (empty($invoiceInfo)){
                return $this->error('您还没有实名认证，不能下单');
            }
            if ($invoiceInfo['review_status'] != 1 ){
                return $this->error('您的实名认证还未通过，不能下单');
            }

            // 收货地址列表
            $addressList = UserAddressService::getInfoByUserId($userInfo['id']);
            if (!empty($addressList)){
                foreach ($addressList as $k=>$v){
                    $addressList[$k] = UserAddressService::getAddressInfo($v['id']);
                    if ($v['id'] == $userInfo['address_id']){
                        $addressList[$k]['is_default'] =1;
                        $first_one[$k] = $addressList[$k];
                    } else {
                        $addressList[$k]['is_default'] ='';
                    };
                }
                if(!empty($first_one)){
                    foreach ($first_one as $k1=>$v1){
                        unset($addressList[$k1]);
                        array_unshift($addressList,$first_one[$k1]);
                    }
                }
            }
            $goodsList = session('cartSession');
            foreach ($goodsList as $k3=>$v3){
                $goodsList[$k3]['delivery_place'] = ShopGoodsQuoteService::getShopGoodsQuoteById($v3['shop_goods_quote_id'])['delivery_place'];
            }
            return $this->display('web.goods.confirmOrder',compact('invoiceInfo','addressList','goodsList'));
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //确认提交订单
    public function createOrder(Request $request){

        $info = session('_curr_deputy_user');
        $userIds = [];
        // 判断是否为企业用户
        if($info['is_firm']){
            $userInfo = session('_web_user');;
            $userIds['user_id'] = session('_web_user_id');
            $userIds['firm_id'] = $info['firm_id'];
        }else{
            $userInfo = session('_web_user');
            $userIds['user_id'] = session('_web_user_id');
            $userIds['firm_id'] = '';
        }
        $words = $request->input('words',' ');

        // 判断是否有开票信息 地址可用
        $invoiceInfo = UserRealService::getInfoByUserId($userInfo['id']);
        if (empty($invoiceInfo)){
            return $this->error('您还没有实名认证，不能下单');
        }
        if ($invoiceInfo['review_status'] != 1 ){
            return $this->error('您的实名认证还未通过，不能下单');
        }
        $addressList = UserAddressService::getInfoByUserId($userInfo['id']);
        if (empty($addressList)){
            return $this->error('无地址信息请前去维护');
        }

        $carList = session('cartSession');
        $shop_data = [];

        foreach ($carList as $k=>$v){
            if (!isset($shop_data[$v['shop_id']])){
                $shop_data[$v['shop_id']] = $v['shop_id'];
            }
        }
        foreach ($shop_data as $k2=>$v2){
            $shop_data[$v2] = [];
            foreach ($carList as $k3=>$v3){
                if ($k2 == $v3['shop_id']){
                    $shop_data[$v2][]=$v3;
                }
            }
        }
        // 没有默认地址的情况下
        if (empty($userInfo['address_id'])){
            $userInfo['address_id'] = UserAddressService::getInfoByUserId($userInfo['id'])[0]['id'];
        }
        try{
            $re=[];
            foreach ($shop_data as $k4=>$v4){
                $re[] =  GoodsService::createOrder($v4,$userIds,$userInfo['address_id'],$words);
            }
           if (!empty($re)){
               Session::forget('cartSession');
               return $this->success('订单提交成功','',$re);
           } else {
                return $this->error('订单提交失败');
           }
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderSubmission(Request $request)
    {
        $re = $request->input('re','');
        if (!empty($re)){
            $re = json_decode($re);
        } else {
            return $this->error('参数错误');
        }
        return $this->display('web.goods.orderSubmission',['re'=>$re]);
    }


    //购物车多选
    public function checkListen(Request $request){
        $userId = session('_web_user_id');
        $cartIds = $request->input('cartId');
        try{
            GoodsService::checkListen($cartIds);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //修改购物车数量
    public function editCartNum(Request $request){
        $cartNum = $request->input('cartNum');
        $id = $request->input('id');
        if(!is_numeric($cartNum)){
            return $this->error();
        }
        try{

            GoodsService::editCartNum($id,$cartNum);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //我的订单
    public function orderList(){
        $userId = session('_web_user_id');
        $orderList = GoodsService::orderList($userId);
//        dump($orderList);
        return $this->display('web.order.order',compact('orderList'));
    }

    //支付界面
    public function pay(){
//        $payInfo = GoodsService::pay();
        return $this->display('web.order.pay');
    }


    //等待审核界面
    public function waitConfirm(){
        return $this->display('web.order.waitConfirm');
    }

    //物性表
    public function goodsAttribute(Request $request){

        if($request->isMethod('get')){
            $page = $request->input('page', 0);
            $page_size = $request->input('length', 1);

            $goods_name= $request->input('goods_name', '');
//            dump($goods_name);
            $condition = [];
            if(!empty($goods_name)){
                $condition['goods_name'] = '%' . $goods_name . '%';
            }


            $url = '/goodsAttribute?page=%d';
            try{
                $goodsInfo = GoodsService::goodsAttribute($condition,$page,$page_size);
                if(!empty($goodsInfo['list'])){
                    $linker = createPage($url, $page,$goodsInfo['total']);
                }else{
                    $linker = createPage($url, 1, 1);
                }
                return $this->display('web.goods.goodsAttribute',['list'=>$goodsInfo['list'],'linker'=>$linker]);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }else{

        }


    }

    //物性表详情
    public function goodsAttributeDetails(Request $request,$id){
       $page = $request->input('page',0);
       $page_size = $request->input('length',1);
        $url = '/goodsAttributeDetails/'.$id .'?page=%d';
       try{
           $shopGoodsInfo = GoodsService::goodsAttributeDetails($id,$page,$page_size);
           if(!empty($shopGoodsInfo['list'])){
               $linker = createPage($url, $page,$shopGoodsInfo['total']);
           }else{
               $linker = createPage($url, 1, 1);
           }
           return $this->display('web.goods.goodsAttributeDetails',['goodsInfo'=>$shopGoodsInfo['goodsInfo'],'list'=>$shopGoodsInfo['list'],'linker'=>$linker]);
       }catch (\Exception $e){
           return $this->error($e->getMessage());
       }
    }
}
