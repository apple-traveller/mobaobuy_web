<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SeckillService;
class SeckillController extends Controller
{
    public function list(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_name = $request->input('shop_name');
        $pageSize = 10;
        $condition = [];
        if(!empty($shop_name)){
            $condition['shop_name'] = "%".$shop_name."%";
        }
        $seckills = SeckillService::getAdminSeckillList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        //dd($seckills);
        return $this->display('admin.seckill.list',[
            'seckills'=>$seckills['list'],
            'total'=>$seckills['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'shop_name'=>$shop_name
        ]);
    }

    //修改启用状态
    public function status(Request $request)
    {
        $id = $request->input("id");
        $enabled = $request->input("val", 0);
        try{
            SeckillService::modify(['id'=>$id,'enabled' => $enabled]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //审核
    public function verify(Request $request)
    {
        $data = $request->all();
        try{
            SeckillService::modify($data);
            return $this->success("修改成功",url('/admin/seckill/list'));
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //查看商品信息
    public function detail(Request $request)
    {
        $id = $request->input("id");
        $review_status = SeckillService::getSeckillInfo($id)['review_status'];
        $pcurrpage = $request->input("pcurrpage");
        $currpage = $request->input("currpage");
        $pageSize = 10;
        $seckill_goods = SeckillService::getSeckillGoods(['pageSize'=>$pageSize,'page'=>$currpage],['seckill_id'=>$id]);
        return $this->display('admin.seckill.detail',[
            "seckill_goods"=>$seckill_goods['list'],
            'total'=>$seckill_goods['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
            'pcurrpage'=>$pcurrpage,
            'review_status'=>$review_status,
            'id'=>$id,
        ]);
    }

    //删除秒杀申请
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = SeckillService::deleteSellerSeckll($id);
            if($flag){
                return $this->success("删除成功",url("/admin/seckill/list"));
            }
            return $this->error("删除失败");
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //秒杀时段列表
    public function timeList(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $pageSize = 10;
        $seckill_time = SeckillService::getSeckillTimeList(['pageSize'=>$pageSize,'page'=>$currpage],[]);
        //dd($seckill_time);
        return $this->display('admin.seckill.timelist',[
            "seckill_time"=>$seckill_time['list'],
            'total'=>$seckill_time['total'],
            'currpage'=>$currpage,
            'pageSize'=>$pageSize,
        ]);
    }

    //添加秒杀时段
    //public function

}
