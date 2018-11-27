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

        return $this->display("web.goods.goodsDetail",
        [
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
            $goods_attr = [];
            if(!empty($shopGoodsInfo['goodsInfo'])){
                $attr = explode(';', $shopGoodsInfo['goodsInfo']['goods_attr']);
                foreach ($attr as $k=>$v){
                    $goods_attr[$k] = explode(':',$v);
                }
            }
            if(!empty($shopGoodsInfo['list'])){
                $linker = createPage($url, $page,$shopGoodsInfo['totalPage']);
            }else{
                $linker = createPage($url, 1, 1);
            }
            return $this->display('web.goods.goodsAttributeDetails',[
                'goodsInfo'=>$shopGoodsInfo['goodsInfo'],
                'list'=>$shopGoodsInfo['list'],
                'linker'=>$linker,
                'goods_attr'=>$goods_attr,
            ]);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //商品走势图
    public function productTrend(Request $request){
        $goodsId = $request->input('id');
        try{
            $goodsList = GoodsService::productTrend($goodsId);
            return $this->success('','',$goodsList);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
