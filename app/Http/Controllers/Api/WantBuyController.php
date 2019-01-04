<?php

namespace App\Http\Controllers\Api;
use App\Services\InquireQuoteService;
use App\Services\InquireService;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;


class WantBuyController extends ApiController
{
    /**
     * 求购列表
     */
    public function wantBuyList(Request $request){
        $currpage = $request->input('currpage',1);
        $pageSize = $request->input('pagesize',10);
        $condition = [];
        $condition['is_delete'] = 0;
        $condition['is_show'] = 1;
        $inquireList = InquireService::inquireList(['pageSize' => $pageSize, 'page' => $currpage,'orderType'=>['add_time'=>'desc']],$condition);
        foreach($inquireList['list'] as &$item){
            $item['add_time'] = \Carbon\Carbon::parse($item['add_time'])->diffForHumans();
        }
        //\Carbon\Carbon::parse($v['add_time'])->diffForHumans()
        return $this->success(['inquireList'=>$inquireList,'pageSize'=>$pageSize,'currpage'=>$currpage],'success');
    }

    public function wantBuyListBycondition(Request $request){
        $currpage = $request->input('currpage',1);
        $pageSize = $request->input('pagesize',10);

        $delivery_area = $request->input('delivery_area','');//发货地
        $goods_name = $request->input('goods_name','');//商品名称

        $condition = [];
        $condition['is_delete'] = 0;
        $condition['is_show'] = 1;
        if(!empty($delivery_area)){
            $condition['delivery_area'] = '%' . $delivery_area . '%';
        }

        if(!empty($goods_name)){
            $condition['goods_name'] = '%' . $goods_name . '%';
        }

        $goodsList = InquireService::inquireList(['pageSize' => $pageSize, 'page' => $currpage], $condition);
        if (empty($goodsList['list'])) {
            return $this->success("","");
        } else {
            return $this->success([
                'list' => $goodsList['list'],
                'currpage' => $currpage,
                'total' => $goodsList['total'],
                'pageSize' => $pageSize,
            ], 'success');
        }
    }

    //ajax 我要供货
    public function asingle(Request $request){
        $id = $request->input('buy_id');
        $data = InquireService::asingle($id);
        return $this->success($data,'success');
    }

    public function savebuy(Request $request){
        $buyQuote = [];
        $buyQuote['user_id'] = $this->getUserID($request);
        $buyQuote['inquire_id'] = $request->input('buy_id');
        $buyQuote['num'] = $request->input('num');
        $buyQuote['price'] = $request->input('price');
        $buyQuote['delivery_area'] = $request->input('delivery_area');
        $buyQuote['remark'] = $request->input('remark','');
        try{
            $res = InquireQuoteService::savebuy($buyQuote);
            return $this->success($res,'success');
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }


}
