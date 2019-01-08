<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-08
 * Time: 9:21
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use App\Services\OrderInfoService;
use App\Services\RegionService;
use App\Services\ShopGoodsQuoteService;
use App\Services\ShopSalesmanService;
use App\Services\ShopService;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

class ShopGoodsQuoteController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $shop_id = session('_seller_id')['shop_id'];
        $goods_name = $request->input('goods_name','');
        $condition = [];
        if(!empty($shop_id)){
            $condition['b.shop_id']= $shop_id;
        }
        if ($goods_name){
            $condition['b.goods_name'] = "%".$goods_name."%";
        }
        $condition['b.type'] = '1|2';
        $condition['b.is_delete'] = 0;
        $pageSize =5;
        $shopGoodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteList(['pageSize'=>$pageSize,'page'=>$currentPage,'orderType'=>['b.add_time'=>'desc']],$condition);
        return $this->display('seller.goodsquote.list',[
            'total'=>$shopGoodsQuote['total'],
            'shopGoodsQuote'=>$shopGoodsQuote['list'],
            'currentPage'=>$currentPage,
            'goods_name'=>$goods_name,
            'pageSize'=>$pageSize
        ]);
    }

    /**
     * 添加表单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $shop_id = session('_seller_id')['shop_id'];
        $salesman = ShopSalesmanService::getList([],['shop_id'=>$shop_id]);
        return $this->display('seller.goodsquote.add',['salesman' => $salesman]);
    }

    /**
     * 编辑表单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $currentPage = $request->input('currentPage',1);
        $id = $request->input('id');
        $shop_id = session('_seller_id')['shop_id'];
        $salesman = ShopSalesmanService::getList([],['shop_id'=>$shop_id]);
        $goodsQuote = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
        $goods = GoodsService::getGoodsList([],[]);
        $good = GoodsService::getGoodInfo($goodsQuote['goods_id']);
        return $this->display('seller.goodsquote.edit',[
            'goodsQuote'=>$goodsQuote,
            'currentPage'=>$currentPage,
            'goods'=>$goods['list'],
            'salesman' => $salesman,
            'good'=>$good
        ]);
    }
    //更新发布
    public function reRelease(Request $request)
    {
        $id = $request->input('id');
        if(empty($id)){
            return $this->error('无法获取到参数ID');
        }
        $res = ShopGoodsQuoteService::reRelease($id);
        if($res){
            return $this->success('成功');
        }else{
            return $this->error('失败');
        }
    }
    /**
     * 添加和编辑
     * @param Request $request
     * @return ShopGoodsQuoteController|\Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $request->flash();
        $shopInfo = session('_seller');
        $shop_id = $shopInfo['shop_info']['id'];
        $shop_name = $shopInfo['shop_info']['shop_name'];
        $company_name = $shopInfo['shop_info']['company_name'];
        $id = $request->input('id','');
        $store_id = $request->input('store_id',0);
        $store_name = $request->input('store_name','');
        $goods_id = $request->input('goods_id','');
        $delivery_method = $request->input('delivery_method','');
        $delivery_time = $request->input('delivery_time','');
        $delivery_place = $request->input('place_id_LABELS','');
        $place_id = $request->input('place_id','');
        $production_date = $request->input('production_date','');
        $goods_number = $request->input('goods_number','');
        $shop_price = $request->input('shop_price','');
        $salesman_id = $request->input('salesman_id','');
        $type = $request->input('type','');

        if($goods_id==0||!$goods_id){
            return $this->error('商品不能为空');
        }
        if(!$store_name && !$store_id){
            return $this->error('店铺不能为空');
        }
        if($store_id == 0 && $store_name == '自售' && empty($type)){
            $store_name = $shop_name;
            $type = 1;
        }else{
            if(empty($type)){
                $type = 2;
            }else{
                $store_name = $shop_name;
            }
        }
        if(!$delivery_place){
            return $this->error('交货地不能为空');
        }
        if(!$production_date){
            return $this->error('生产日期不能为空');
        }
        if(!$goods_number){
            return $this->error('库存不能为空');
        }
        if(!$delivery_method){
            return $this->error('交货方式不能为空');
        }
        if(!$delivery_time){
            return $this->error('交货时间不能为空');
        }
        if(!$shop_price){
            return $this->error('店铺售价不能为空');
        }
        if(!$salesman_id){
            return $this->error('业务员不能为空');
        } else {
            $salesmanInfo = ShopSalesmanService::getInfoByFields(['id'=>$salesman_id]);
            if (empty($salesmanInfo)){
                return $this->error('业务员信息错误，请维护');
            }
        }

        $goods = GoodsService::getGoodInfo($goods_id);
        $data['goods_sn'] = $goods['goods_sn'];
        $data['goods_name'] = $goods['goods_name'];
        $currentPage = $request->input('currentPage');
        $data = [
            'shop_store_id' => $store_id,
            'store_name' => $store_name,
            'shop_id' => $shop_id,
            'shop_name' => $company_name,
            'goods_id' => $goods_id,
            'delivery_place' => $delivery_place,
            'place_id' => $place_id,
            'production_date' => $production_date,
            'goods_number' => $goods_number,
            'delivery_method' => $delivery_method,
            'delivery_time' => $delivery_time,
            'shop_price' => $shop_price,
            'expiry_time' => date('Y-m-d H:i:s',strtotime(Carbon::now()->toDateString().' '.getConfig('close_quote'))),
            'goods_sn' => $goods['goods_sn'],
            'goods_name' => $goods['goods_full_name'],
            'salesman' => $salesmanInfo['name'],
            'contact_info' => $salesmanInfo['mobile'],
            'QQ' => $salesmanInfo['qq'],
            'type' => $type,
            'consign_status'=>1,
            'is_self_run' => $shopInfo['shop_info']['is_self_run'],
        ];
        try{
            if($id){
                $data['id'] = $id;
                $flag = ShopGoodsQuoteService::modify($data);
                if(!empty($flag)){
                    if($type != 3){
                        return $this->success('修改成功',url('/seller/quote/list')."?currentPage=".$currentPage);
                    }else{
                        return $this->success('修改成功',url('/seller/activity/consign')."?currentPage=".$currentPage);
                    }

                }
            }else{
                $data['add_time'] = Carbon::now();
                $data['total_number'] = $goods_number;
                $data['shop_user_id'] = session('_seller_id')['user_id'];
                $flag = ShopGoodsQuoteService::create($data);
                if(!empty($flag)){
                    if($type != 3){
                        return $this->success('添加成功',url('/seller/quote/list'));
                    }else{
                        return $this->success('添加成功',url('/seller/activity/consign'));
                    }

                }
            }
            return $this->error('添加失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * delete
     * @param Request $request
     * @return ShopGoodsQuoteController|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return $this->error('无法获取参数ID');
        }
        try{
            $check = ShopGoodsQuoteService::getShopGoodsQuoteById($id);
            if(empty($check)){
                return $this->error('报价信息不存在');
            }
            $is_exist_order = OrderInfoService::checkQuoteExistOrder($id);
            if($is_exist_order){
                return $this->error('该活动存在相应订单，无法删除');
            }
            $flag = ShopGoodsQuoteService::modify(['id'=>$id,'is_delete'=>1]);
            if($flag){
                return $this->success('删除成功',url('/seller/quote/list'));
            }
            return  $this->error('删除失败');
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 地址树形列表
     * @return array
     */
    public function getAddressTree()
    {
        return RegionService::getRegionTree();
    }

}
