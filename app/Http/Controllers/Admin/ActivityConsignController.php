<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:28
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityWholesaleService;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use App\Services\OrderInfoService;
use App\Services\ShopGoodsQuoteService;
use App\Services\ShopService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityConsignController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $goods_name = $request->input('goods_name','');
        $condition = [];
        if ($goods_name){
            $condition['b.goods_name'] = "%".$goods_name."%";
        }
        $condition['type'] = '3';
        $pageSize =5;
        $consign_info = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currentPage,'orderType'=>['b.add_time'=>'desc']],$condition);
        return $this->display('admin.activityconsign.consign',[
            'total'=>$consign_info['total'],
            'consign_list'=>$consign_info['list'],
            'currentPage'=>$currentPage,
            'goods_name'=>$goods_name,
            'pageSize'=>$pageSize
        ]);
    }

    public function add(Request $request)
    {
        return $this->display('admin.activityconsign.add_consign');
    }

    public function edit(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = $request->input('id');
        $consign_info = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        dd($consign_info);
        $goods = GoodsService::getGoodsList([],[]);
        $good = GoodsService::getGoodInfo($consign_info['goods_id']);
        return $this->display('admin.activityconsign.edit_consign',[
            'consign_info'=>$consign_info,
            'currentPage'=>$currentPage,
            'goods'=>$goods['list'],
            'good'=>$good
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        $errorMsg = [];
        if($data['goods_id']==0||empty($data['goods_id'])){
            $errorMsg[] = '商品不能为空';
        }
        if($data['delivery_place']==""){
            $errorMsg[] = '发货地不能为空';
        }
//        if($data['shop_id']==0||empty($data['shop_id'])){
//            $errorMsg[] = '店铺不能为空';
//        }
        if(empty($data['delivery_place'])){
            $errorMsg[] = '交货地不能为空';
        }
        if(empty($data['goods_number'])){
            $errorMsg[] = '库存不能为空';
        }
        if(empty($data['shop_price'])){
            $errorMsg[] = '店铺售价不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode('|',$errorMsg));
        }

        $delivery_places = explode('/',$data['delivery_place']);//先转化为数组
        $data['delivery_place'] = array_pop($delivery_places);//取最后的一个地区

        $place_ids = explode('|',$data['place_id']);//先转化为数组
        $data['place_id'] = array_pop($place_ids);//取最后的一个地区

//        $data['shop_name'] = ShopService::getShopById($data['shop_id'])['shop_name'];
        $goods = GoodsService::getGoodInfo($data['goods_id']);
        $data['goods_sn'] = $goods['goods_sn'];
        $data['goods_name'] = $goods['goods_name'];
        $data['store_name'] = $data['shop_name'];
        try{
            if(key_exists('id',$data)){
                $goodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteById($data['id']);
                if(empty($goodsQuote)){
                    return $this->error('活动信息不存在');
                }
                $flag = ShopGoodsQuoteService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/activity/consign'));
                }
            }else{
                $data['add_time'] = Carbon::now();
                $data['outer_user_id'] = session('_admin_user_id');
                $data['outer_id'] = 0;
                $flag = ShopGoodsQuoteService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/activity/consign'));
                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }

    }
}
