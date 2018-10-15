<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-11
 * Time: 17:03
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\SeckillService;
use Illuminate\Http\Request;

class SeckillController extends Controller
{
    /**
     * 商户秒杀申请列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seckill(Request $request)
    {
        $shop_id = session()->get('_seller_id')['shop_id'];
        $currentPage = $request->input('currentPage',1);
        $condition = [];
        $condition['shop_id'] = $shop_id;
        $pageSize = 10;
        $list = SeckillService::getSellerSeckillList([['pageSize' => $pageSize, 'page' => $currentPage, 'orderType' => ['add_time' => 'desc']]],$condition);
        return $this->display('seller.seckill.list',[
            'list' => $list['list'],
            'total' => $list['total'],
            'pageSize' => $pageSize,
            'currentPage' => $currentPage
        ]);
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addForm()
    {
        $seckill_time = SeckillService::getSeckillTime();
        return $this->display('seller.seckill.add',[
            'seckill_time' => $seckill_time
        ]);
    }

    public function save(Request $request)
    {
        $shop_info = session('_seller')['shop_info'];
        $sec_data = $request->input('sec_data','');
        if (!empty($sec_data)){
            $re = SeckillService::sellerSeckillSave($shop_info,$sec_data);
            if ($re){
                return $this->success('申请成功');
            } else {
                return $this->error('申请失败，请联系客服');
            }
        }
    }

    /**
     *
     * @param Request $request
     * @return SeckillController|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $currentPage = $request->input('currentPage');
        $seckill_id = $request->input('seckill_id','');
        $re = SeckillService::deleteSellerSeckll($seckill_id);
        if ($re){
            return $this->success('删除成功','/seller/seckill/list'."?currentPage=".$currentPage);
        } else {
            return $this->error('删除失败，请联系客服');
        }
    }
}
