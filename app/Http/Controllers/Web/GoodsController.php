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
        $userInfo = session('_web_user');
        try{
            $goods_list = GoodsService::toBalance($cartIds,$userInfo['id']);
            //进入订单确认页面前先定义购物车session
            $cartSession = [
                'goods_list'=>$goods_list,
                'address_id'=> $userInfo['address_id'],
                'from'=>'cart'
            ];
            session()->put('cartSession',$cartSession);
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }



    /**
     * 选择订单收货地址
     * editOrderAddress
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function editOrderAddress(Request $request)
    {
        $address_id = $request->input('address_id','');
        if(!$address_id){
            return $this->error('缺少参数地址ID！');
        }
        $address_info = UserAddressService::getAddressInfo($address_id);
        if(!$address_info){
            return $this->error('地址信息不存在！');
        }
        $cartSession = session('cartSession');
        $cartSession['address_id'] = $address_id;

        session()->put('cartSession',$cartSession);
        return $this->success('选择成功');
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

    //购物车input判断
    public function checkListenCartInput(Request $request){
        $id = $request->input('id');
        $goodsNumber = $request->input('goodsNumber');


        try{
            $goods_number = GoodsService::checkListenCartInput($id,$goodsNumber);
            return $this->success('','',$goods_number);
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
            $page_size = $request->input('length', 6);

            $goods_name= $request->input('goods_name', '');

            $condition = [];
            if(!empty($goods_name)){
                $condition['goods_name'] = '%' . $goods_name . '%';
            }
            $url = '/goodsAttribute?page=%d&goods_name='.$goods_name;
            try{
                $goodsInfo = GoodsService::goodsAttribute($condition,$page,$page_size);
                if(!empty($goodsInfo['list'])){
                    $linker = createPage($url, $page,$goodsInfo['totalPage']);
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
       $page_size = $request->input('length',6);
        $url = '/goodsAttributeDetails/'.$id .'?page=%d';
       try{
           $shopGoodsInfo = GoodsService::goodsAttributeDetails($id,$page,$page_size);
           if(!empty($shopGoodsInfo['list'])){
               $linker = createPage($url, $page,$shopGoodsInfo['totalPage']);
           }else{
               $linker = createPage($url, 1, 1);
           }
           return $this->display('web.goods.goodsAttributeDetails',['goodsInfo'=>$shopGoodsInfo['goodsInfo'],'list'=>$shopGoodsInfo['list'],'linker'=>$linker]);
       }catch (\Exception $e){
           return $this->error($e->getMessage());
       }
    }
}
