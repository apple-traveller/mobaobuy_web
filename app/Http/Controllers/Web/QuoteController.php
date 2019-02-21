<?php

namespace App\Http\Controllers\Web;
use App\Repositories\CartRepo;
use App\Repositories\UserCollectGoodsRepo;
use App\Services\CartService;
use App\Services\GoodsService;
use App\Services\HotSearchService;
use App\Services\UserAddressService;
use App\Services\UserInvoicesService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ShopGoodsQuoteService;
use Illuminate\Support\Facades\Session;
use App\Services\GoodsCategoryService;
use App\Services\BrandService;
use App\Services\RegionService;
class QuoteController extends Controller
{
    /**
     * 报价列表
     * goodsList
     * @param Request $request
     * @param $t
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodsList(Request $request,$t='')
    {
        $currpage = $request->input("currpage", 1);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
//        $orderType = $request->input("orderType", "b.add_time:desc");
        $brand_id = $request->input("brand_id", "");
        $cate_id = $request->input('cate_id', "");
        $cat_name = $request->input('cat_name', "");
        $place_id = $request->input('place_id', "");
        $keyword = $request->input('keyword', "");//搜索关键字
//        $t = $request->input('t', "");//搜索关键字
        $condition = [];
        if (!empty($orderType)) {
            $order = explode(":", $orderType);
        }

        if (empty($lowest) && empty($highest)) {
            $condition = [];
        }
        if ($lowest == "" && $highest != "") {
            $condition['shop_price|<='] = $highest;
        }
        if ($highest == "" && $lowest != "") {
            $condition['shop_price|>='] = $lowest;
        }
        if ($lowest != "" && $highest != "" && $lowest < $highest) {
            $condition['shop_price|<='] = $highest;
            $condition['shop_price|>='] = $lowest;
        }
        if ($lowest > $highest) {
            $condition['shop_price|>='] = $lowest;
        }

        if (!empty($brand_id)) {
            $condition['g.brand_id'] = $brand_id;
        }
        if (!empty($cate_id)) {
            $c['opt'] = 'OR';
            $c['g.cat_id'] = $cate_id;
            $c['cat.parent_id'] = $cate_id;
            $condition[] = $c;
        }
        if (!empty($place_id)) {
            $condition['place_id'] = $place_id;
        }
        if (!empty($keyword)) {

            $con['opt'] = 'OR';
            $con['b.goods_name'] = '%' . $keyword . '%';
            $con['cat.cat_name'] = '%' . $keyword . '%';
            $condition[] = $con;
        }
//        $orderBy = [];
//        if (!empty($orderType)) {
//            $type = explode(":", $orderType);
//            $orderBy[$type[0]] = $type[1];
//        }
        $pageSize = 20;
        if(!empty($t)){
            if($t == 3){
                $condition['b.is_self_run'] = 0;
            }else{
                $condition['b.type'] = $t;
                $condition['b.is_self_run'] = 1;
            }
        }else{
            //            $condition['b.type'] = '1|2';
        }
        $condition['b.is_delete'] = 0;
        //商品报价列表
        $goodsList = ShopGoodsQuoteService::getQuoteByWebSearch(['pageSize' => $pageSize, 'page' => $currpage], $condition,$t);
        if(!empty($goodsList)){
            foreach ($goodsList['list'] as $k=>$v){
                if($v['shop_store_id'] == 0){
                    $goodsList['list'][$k]['store_name_en'] = !empty($v['shop_name_en']) ? $v['shop_name_en'] : $v['company_name_en'];
                }
            }
        }
        #热门推荐
        if (!empty($keyword)) {
            $hot_search = HotSearchService::getInfoByFields(['search_key' => $keyword]);

            if ($hot_search) {
                HotSearchService::modify([
                    'id' => $hot_search['id'],
                    'search_num' => $hot_search['search_num'] + 1,
                    'update_time' => date('Y-m-d H:i:s', time())
                ]);
            } else {
                $search = [
                    'search_key' => $keyword,
                    'search_num' => 1,
                    'is_show' => 0,
                    'update_time' => date('Y-m-d H:i:s', time())
                ];
                HotSearchService::create($search);
            }
        }

        return $this->display("web.quote.list", [
            'search_data' => $goodsList,
            'currpage' => $currpage,
            'pageSize' => $pageSize,
//            'orderType' => $orderType,
            'lowest' => $lowest,
            'highest' => $highest,
            'brand_id' => $brand_id,
            'cate_id' => $cate_id,
            'cat_name' => $cat_name,
            'place_id' => $place_id,
            'keyword' => $keyword,
            't' => $t,
        ]);
    }

    /**
     * 根据条件范围收索报价(ajax)
     * goodsListByCondition
     * @param Request $request
     * @return $this
     */
    public function goodsListByCondition(Request $request)
    {

        $currpage = $request->input("currpage", 1);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
        $sort_goods_number = $request->input("sort_goods_number", '');
        $sort_add_time = $request->input("sort_add_time", '');
        $sort_shop_price = $request->input("sort_shop_price", '');
//        $orderType = $request->input("orderType", "b.add_time:desc");
        $brand_id = $request->input("brand_id", "");
        $cate_id = $request->input('cate_id', "");
        $place_id = $request->input('place_id', "");
        $keyword = $request->input('keyword', "");
        $t = $request->input('t', "1|2");
        $condition = [];

        $orderBy = [];
        if (!empty($sort_goods_number)) {
            $orderBy['b.goods_number'] = $sort_goods_number;
        }
        if (!empty($sort_add_time)) {
            $orderBy['b.add_time'] = $sort_add_time;
        }
        if (!empty($sort_shop_price)) {
            $orderBy['b.shop_price'] = $sort_shop_price;
        }
//        if (empty($sort_goods_number) && empty($sort_add_time) && empty($sort_shop_price) && !empty($orderType)) {
//            $type = explode(":", $orderType);
//            $orderBy[$type[0]] = $type[1];
//        }
        if (empty($lowest) && empty($highest)) {
            $condition = [];
        }
        if ($lowest == "" && $highest != "") {
            $condition['shop_price|<='] = $highest;
        }
        if ($highest == "" && $lowest != "") {
            $condition['shop_price|>='] = $lowest;
        }
        if ($lowest != "" && $highest != "" && $lowest < $highest) {
            $condition['shop_price|<='] = $highest;
            $condition['shop_price|>='] = $lowest;
        }
        if ($lowest > $highest) {
            $condition['shop_price|>='] = $lowest;
        }

        if (!empty($brand_id)) {
            $condition['g.brand_id'] = $brand_id;
        }
        if (!empty($t)) {
//            $condition['b.type'] = $t;
            if($t == 3){
                $condition['b.is_self_run'] = 0;
            }else{
                $condition['b.type'] = $t;
                $condition['b.is_self_run'] = 1;
            }
        }
        if (!empty($cate_id)) {
            $c['opt'] = 'OR';
            $c['g.cat_id'] = $cate_id;
            $c['cat.parent_id'] = $cate_id;
            $condition[] = $c;
        }
        if (!empty($place_id)) {
            $condition['place_id'] = $place_id;
        }
        if (!empty($keyword)) {
            $con['opt'] = 'OR';
            $con['b.goods_name'] = '%' . $keyword . '%';
            $con['cat.cat_name'] = '%' . $keyword . '%';
            $condition[] = $con;
        }
        $pageSize = 20;
        $condition['b.is_delete'] = 0;
        $goodsList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize' => $pageSize, 'page' => $currpage, 'orderType' => $orderBy], $condition);
        if (empty($goodsList['list'])) {
            return $this->result("", 400, 'error');
        } else {
            foreach ($goodsList['list'] as $k=>$v){
                if($v['shop_store_id'] == 0){
                    $goodsList['list'][$k]['store_name_en'] = !empty($v['shop_name_en']) ? $v['shop_name_en'] : $v['company_name_en'];
                }
            }
            return $this->result([
                'list' => $goodsList['list'],
                'currpage' => $currpage,
                'total' => $goodsList['total'],
                'pageSize' => $pageSize,
                't' => $t
            ], 200, 'success');
        }
    }

    /**
     * 报价详情
     * goodsDetail
     * @param Request $request
     * @param $id
     * @param $shop_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodsDetail(Request $request,$id,$shop_id)
    {
        $good_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $currpage = $request->input("currpage", 1);
        $goods_id = $good_info['goods_id'];
        $condition = [
            'b.shop_id' => $shop_id,
            'b.goods_id' => $goods_id,
            'b.type'=>'1|2',
            'b.is_delete'=>0
        ];
        $pageSize = 15;
        $userId = session('_web_user_id');
        $cart_count = GoodsService::getCartCount($userId);
        $goodList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize' => $pageSize, 'page' => $currpage, 'orderType' => ['add_time' => 'desc']], $condition);

        //商家推荐
        $condi = [];
        $condi['b.shop_id'] = $shop_id;
        $condi['b.consign_status'] = 1;
        $condi['b.is_delete'] = 0;
        $condi['b.id'] = '!'.$id;

        $quoteList = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize' => $pageSize, 'page' => $currpage], $condi);

        //是否收藏
        $collectGoods = UserService::checkUserIsCollect($userId, $good_info['goods_id']);

        return $this->display("web.goods.goodsDetail", [
            'good_info' => $good_info,
            'goodsList' => $goodList['list'],
            'total' => $goodList['total'],
            'currpage' => $currpage,
            'pageSize' => $pageSize,
            'id' => $id,
            'shop_id' => $shop_id,
            'cart_count' => $cart_count,
            'collectGoods' => $collectGoods,
            'quoteList' => $quoteList['list']
        ]);
    }
}
