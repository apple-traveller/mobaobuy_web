<?php

namespace App\Http\Controllers\Web;
use App\Services\InquireService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\WantBuyService;

class WantBuyController extends Controller
{
    /**求购页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wantBuyList(Request $request){
        $currpage = $request->input('currpage',1);
        $pageSize = 1;
        $condition = [];
        $condition['is_delete'] = 0;
        $condition['is_show'] = 1;
        $inquireList = InquireService::inquireList(['pageSize' => $pageSize, 'page' => $currpage,'orderType'=>['add_time'=>'desc']],$condition);
        return $this->display('web.wantbuy.wantBuy',['inquireList'=>$inquireList,'pageSize'=>$pageSize,'currpage'=>$currpage]);
    }

    public function wantBuyListBycondition(Request $request){
        $currpage = $request->input('currpage',1);
        $delivery_area = $request->input('delivery_area','');//发货地
        $cat_name = $request->input('cat_name','');//分类名
        $brand_name = $request->input('brand_name','');//厂商
        $goods_name = $request->input('goods_name','');//商品名称

        $condition = [];
        if(!empty($delivery_area)){
            $condition['delivery_area'] = $delivery_area;
        }
        if(!empty($cat_name)){
            $condition['cat_name'] = $cat_name;
        }
        if(!empty($brand_name)){
            $condition['brand_name'] = $brand_name;
        }
        if(!empty($goods_name)){
            $condition['goods_name'] = $goods_name;
        }
        $pageSize = 1;

        $goodsList = InquireService::inquireList(['pageSize' => $pageSize, 'page' => $currpage], $condition);

        if (empty($goodsList['list'])) {
            return $this->result("", 400, 'error');
        } else {
            return $this->result([
                'list' => $goodsList['list'],
                'currpage' => $currpage,
                'total' => $goodsList['total'],
                'pageSize' => $pageSize,
            ], 200, 'success');
        }
    }




}
