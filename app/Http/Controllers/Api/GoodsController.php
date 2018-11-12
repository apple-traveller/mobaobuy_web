<?php

namespace App\Http\Controllers\Api;

use App\Services\ShopGoodsQuoteService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class GoodsController extends Controller
{
    //账号信息
    public function list(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $highest = $request->input("highest");
        $lowest = $request->input("lowest");
        $orderType = $request->input("orderType","b.id:asc");
        $brand_id = $request->input("brand_id","");
        $cate_id = $request->input('cate_id',"");
        $cat_name = $request->input('cat_name',"");
        $place_id = $request->input('place_id',"");
        $keyword = $request->input('keyword',"");//搜索关键字

        $condition = [];

        if(!empty($orderType)){
            $order = explode(":",$orderType);
        }

        if(empty($lowest)&&empty($highest)){
            $condition = [];
        }
        if($lowest=="" && $highest!=""){
            $condition['shop_price|<='] = $highest;
        }
        if($highest=="" && $lowest!=""){
            $condition['shop_price|>='] = $lowest;
        }
        if($lowest!="" && $highest!=""&&$lowest<$highest){
            $condition['shop_price|<='] = $highest;
            $condition['shop_price|>='] = $lowest;
        }
        if($lowest>$highest){
            $condition['shop_price|>='] = $lowest;
        }

        if(!empty($brand_id)){
//            $goods_id = BrandService::getGoodsIds($brand_name);
//            $condition['goods_id'] = implode('|',$goods_id);
            $condition['g.brand_id'] = $brand_id;
        }
        if(!empty($cate_id)){
//            $goods_id = GoodsCategoryService::getGoodsIds($cate_id);
//            $condition['goods_id'] = implode('|',$goods_id);
            $c['opt'] = 'OR';
            $c['g.cat_id'] = $cate_id;
            $c['cat.parent_id'] = $cate_id;
            $condition[] = $c;
        }

        if(!empty($place_id)){
            $condition['place_id'] = $place_id;
        }

        if(!empty($keyword)){
            $con['opt'] = 'OR';
            $con['b.goods_name'] = '%'.$keyword.'%';
            $con['cat.cat_name'] = '%'.$keyword.'%';
            $condition[] = $con;
        }

        $pageSize = 10;

        //产品报价列表
        $goodsList= ShopGoodsQuoteService::getQuoteByWebSearch(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>[$order[0]=>$order[1]]],$condition);

        return $this->display("web.quote.list",[
            'search_data'=>$goodsList,
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'orderType'=>$orderType,
            'lowest'=>$lowest,
            'highest'=>$highest,
            'brand_id'=>$brand_id,
            'cate_id'=>$cate_id,
            'cat_name'=>$cat_name,
            'place_id'=>$place_id,
            'keyword'=>$keyword,
        ]);
    }

    //获取所有的分类数据
    public function getCates(Request $request)
    {

    }
}