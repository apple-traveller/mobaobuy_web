<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-11
 * Time: 17:03
 */
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\GoodsService;
use App\Services\SeckillService;
use function Couchbase\defaultDecoder;
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
     * 列表详情
     * @param Request $request
     * @return array
     */
    public function list_detail(Request $request)
    {
        $seckill_id = $request->input('seckill_id','');
        $list = [];
        if (!empty($seckill_id)){
            $list = SeckillService::listInfo($seckill_id);
            return $this->display('seller.seckill.list_detail',['list'=>$list]);
        }
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

    public function goods_list(Request $request)
    {
        $goods_name = $request->input('goods_name','');
        if(!empty($goods_name)){
            $c['opt'] = "OR";
            $c['goods_name'] = "%".$goods_name."%";
            $c['goods_sn'] = $goods_name;
            $c['brand_name'] = $goods_name;
            $c['goods_model'] = $goods_name;
            $condition[] = $c;
        }else{
            $condition = [];
    }
        $goods = GoodsService::getGoodsList([],$condition);
        return $this->display('seller.seckill.goods_list',[
            'code'=>0,
            'msg'=>'',
            'count'=>$goods['total'],
            'data'=>$goods['list']
        ]);

    }
}
