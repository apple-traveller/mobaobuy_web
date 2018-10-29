<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-25
 * Time: 20:28
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function promoter(Request $request)
    {
        $shop_id = session()->get('_seller_id')['shop_id'];
        $currentPage = $request->input('currentPage',1);
        $condition = [];
        $condition['shop_id'] = $shop_id;
        $pageSize = 10;
        $list = ActivityService::getListBySearch([['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['add_time' => 'desc']]],$condition);
        return $this->display('seller.Activity.promoter',[
            'list' => $list['list'],
            'total' => $list['total'],
            'pageSize' => $pageSize,
            'currentPage' => $currentPage
        ]);
    }

    /**
     * 添加 编辑 页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addPromoter(Request $request)
    {
        $currentPage = $request->input('currentPage',1);

        $id = $request->input('id','');

        if($id){
            $promote_info = ActivityService::getInfoById($id);
            $promote_info['begin_time'] = explode(' ',$promote_info['begin_time']);
            $promote_info['end_time'] = explode(' ',$promote_info['end_time']);
            $good = GoodsService::getGoodInfo($promote_info['goods_id']);
        } else {
            $promote_info = [];
            $good = [];
        }
        $goodsCat = GoodsCategoryService::getCates();
        $goodsCatTree = GoodsCategoryService::getCatesTree($goodsCat);
        $goods = GoodsService::getGoodsList([],[]);

        return $this->display('seller.activity.edit',[
            'goodsCatTree'=>$goodsCatTree,
            'goods'=>$goods['list'],
            'currentPage' => $currentPage,
            'promote_info' => $promote_info,
            'good' => $good
        ]);
    }

    /**
     * 添加&修改——动作
     * @param Request $request
     * @return ActivityController|\Illuminate\Http\RedirectResponse
     */
    public function savePromoter(Request $request)
    {
        $shop_info = session('_seller')['shop_info'];
        if(empty($shop_info)){
            return $this->error('没有商户信息');
        }
        $id = $request->input('id','');
        $goods_id = $request->input('goods_id','');
        $start_date = $request->input('start_date','');
        $start_time = $request->input('start_time','');
        $end_date = $request->input('end_date','');
        $end_time = $request->input('end_time','');
        $price = $request->input('price','');
        $num = $request->input('num','');
        $min_limit = $request->input('min_limit','');
        $max_limit = $request->input('max_limit','');
        $currentPage = $request->input('currentPage',1);
        $goodsInfo = GoodsService::getGoodInfo($goods_id);

        $data = [
            'begin_time' => $start_date.' '.$start_time,
            'end_time' => $end_date.' '.$end_time,
            'goods_id' => $goods_id,
            'goods_name' => $goodsInfo['goods_name'],
            'price' => $price,
            'num' => $num,
            'min_limit' => $min_limit,
            'max_limit' => $max_limit,
        ];


        if(empty($id)){
            $data['shop_id'] = $shop_info['id'];
            $data['shop_name'] = $shop_info['company_name'];
            $data['click_count'] = 0;
            $data['review_status'] = 1;
            $data['available_quantity'] = $num;
            $re = ActivityService::create($data);
        } else {
            $re = ActivityService::updateById($id,$data);
        }
        if ($re){
            return $this->redirect('/seller/activity/promoter',['currentPage'=>$currentPage]);
        } else {
            return $this->error('操作失败');
        }
    }

    /**
     * delete
     * @param Request $request
     * @return ActivityController|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $shop_id = session('_seller_id')['shop_id'];
        $check = ActivityService::getListBySearch([],['shop_id'=>$shop_id,'id'=>$id]);
        if (!$id){
            return $this->error('信息出错，请刷新');
        }
        if (!$check){
            return $this->error('您的店铺没有该订单，请刷新');
        }
        $re = ActivityService::delete($id);

        if ($re){
            return $this->success('删除成功');
        } else {
            return $this->error('删除失败');
        }

    }
}
