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
use Illuminate\Http\Request;

class ActivityWholesaleController extends Controller
{
    public function index(Request $request)
    {
        $shop_name = $request->input('shop_name','');
        $currentPage = $request->input('currentPage',1);
        $condition = [];
        if(!empty($shop_name)){
            $condition['shop_name'] = '%'.$shop_name.'%';
        }
        $condition['is_delete'] = 0;
        $pageSize = 10;
        $list = ActivityWholesaleService::getListBySearch([['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['begin_time' => 'desc']]],$condition);

        return $this->display('admin.activity.wholesale',[
            'list' => $list['list'],
            'total' => $list['total'],
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'shop_name'=>$shop_name
        ]);
    }

    /**
     * 添加 编辑 页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $currentPage = $request->input('currentPage',1);

        $id = $request->input('id','');

        if($id){
            $wholesale_info = ActivityWholesaleService::getInfoById($id);
            $wholesale_info['begin_time'] = explode(' ',$wholesale_info['begin_time']);
            $wholesale_info['end_time'] = explode(' ',$wholesale_info['end_time']);
            $good = GoodsService::getGoodInfo($wholesale_info['goods_id']);
        } else {
            $wholesale_info = [];
            $good = [];
        }
         return $this->display('admin.activity.edit_wholesale',[
            'currentPage' => $currentPage,
            'wholesale_info' => $wholesale_info,
            'good' => $good
        ]);
    }

    /**
     * 添加&修改——动作
     * save
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $id = $request->input('id','');
        $goods_id = $request->input('goods_id','');
        $start_date = $request->input('start_date','');
        $start_time = $request->input('start_time','');
        $end_date = $request->input('end_date','');
        $end_time = $request->input('end_time','');
        $price = $request->input('price','');
        $num = $request->input('num','');
        $deposit_ratio = $request->input('deposit_ratio','');//订金比例
        $min_limit = $request->input('min_limit','');
        $max_limit = $request->input('max_limit','');
        $currentPage = $request->input('currentPage',1);
        $shop_id = $request->input('shop_id',0);
        $company_name = $request->input('company_name','');
        $goodsInfo = GoodsService::getGoodInfo($goods_id);

        $data = [
            'begin_time' => $start_date.' '.$start_time,
            'end_time' => $end_date.' '.$end_time,
            'goods_id' => $goods_id,
            'goods_name' => $goodsInfo['goods_full_name'],
            'price' => $price,
            'num' => $num,
            'min_limit' => $min_limit,
            'max_limit' => $max_limit,
            'deposit_ratio' => $deposit_ratio,
            'review_status' => 1
        ];
        if(empty($id)){
            $data['shop_id'] = $shop_id;
            $data['shop_name'] = $company_name;
            $data['click_count'] = 0;
            $data['partake_quantity'] = $num;
            $re = ActivityWholesaleService::create($data);
        } else {
            $re = ActivityWholesaleService::updateById($id,$data);
        }
        if ($re){
            return $this->redirect('/admin/activity/wholesale',['currentPage'=>$currentPage]);
        } else {
            return $this->error('操作失败');
        }
    }

    /**
     * 删除集采拼团
     * delete
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $currentPage = $request->input('currentPage',1);
        if(!$id){
            return $this->error('无法获取参数ID');
        }
        $check = ActivityWholesaleService::getInfoById($id);
        if (!$check){
            return $this->error('您的店铺没有该订单，请刷新');
        }
        $is_exist_order = OrderInfoService::checkActivityExistOrder($id,'wholesale');
        if($is_exist_order){
            return $this->error('该活动存在相应订单，无法删除');
        }

        $re = ActivityWholesaleService::updateById($id,['is_delete'=>1]);

        if ($re){
            return $this->redirect('/admin/activity/wholesale',['currentPage'=>$currentPage]);
        } else {
            return $this->error('删除失败');
        }

    }
}
