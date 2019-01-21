<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\SeckillService;
use App\Services\ShopService;
use App\Services\GoodsCategoryService;
use App\Services\GoodsService;
class SeckillController extends Controller
{
    public function getList(Request $request)
    {
        $currpage = $request->input('currpage', 1);
        $shop_name = $request->input('shop_name');
        $pageSize = 10;
        $condition = [];
        if (!empty($shop_name)) {
            $condition['shop_name'] = "%" . $shop_name . "%";
        }
        $seckills = SeckillService::getAdminSeckillList(['pageSize' => $pageSize, 'page' => $currpage, 'orderType' => ['add_time' => 'desc']], $condition);
        //dd($seckills);
        return $this->display('admin.seckill.list', [
            'seckills' => $seckills['list'],
            'total' => $seckills['total'],
            'pageSize' => $pageSize,
            'currpage' => $currpage,
            'shop_name' => $shop_name
        ]);
    }

    public function addForm(Request $request)
    {
        $seckilltimes = SeckillService::getSeckillTimeList([], []);
        $shop = ShopService::getShopList([], []);
        return $this->display('admin.seckill.add', [
            'seckilltimes' => $seckilltimes['list'],
            'shop' => $shop['list']
        ]);
    }

    //ajax获取商品分类
    public function getGoodsCat(Request $request)
    {
        $cat_name = $request->input('cat_name');
        $condition = [];
        $condition['is_delete'] = 0;
        if ($cat_name != "") {
            $condition['cat_name'] = "%" . $cat_name . "%";
        }
        $cates = GoodsCategoryService::getCatesByCondition($condition);
        return $this->result($cates, 200, '获取数据成功');
    }

    //ajax获取商品值
    public function getGood(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $goods_name = $request->input('goods_name');
        $condition = [];
        $condition['is_delete'] = 0;
        if ($cat_id != "") {
            $condition['cat_id'] = $cat_id;
        }
        if ($goods_name != "") {
            $condition['goods_name'] = "%" . $goods_name . "%";
        }
        $goods = GoodsService::getGoods($condition, ['id', 'goods_name', 'packing_spec']);
        return $this->result($goods, 200, '获取数据成功');

    }

    //保存秒杀活动
    public function save(Request $request)
    {
        $data = $request->all();
        $seckill_goods = $data['seckill_goods'];
        unset($data['seckill_goods']);
        $gdata = json_decode($seckill_goods, true);//秒杀商品信息
        $errorMsg = [];
        if (empty($data['shop_id'])) {
            $errorMsg[] = "商家必须选择";
        }

        if (empty($data['begin_time'])) {
            $errorMsg[] = "开始时间不能为空";
        }
        if (empty($data['end_time'])) {
            $errorMsg[] = "结束时间不能为空";
        }
        if (strtotime($data['end_time']) < strtotime($data['begin_time'])) {
            $errorMsg[] = "结束时间不能小于开始时间";
        }
        if (empty($data['tb_id'])) {
            $errorMsg[] = "秒杀时段ID不能为空";
        }
        if (empty($gdata)) {
            $errorMsg[] = "没有选择秒杀商品";
        }
        if (!empty($errorMsg)) {
            return $this->error(implode("|", $errorMsg));
        }
        try {
            $data['add_time'] = Carbon::now();
            $flag = SeckillService::create($data, $gdata);
            if (empty($flag)) {
                return $this->error("添加失败");
            }
            return $this->success("添加成功", url("/admin/seckill/list"));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //修改启用状态
    public function status(Request $request)
    {
        $id = $request->input("id");
        $enabled = $request->input("val", 0);
        try {
            SeckillService::modify(['id' => $id, 'enabled' => $enabled]);
            return $this->success("修改成功");
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //审核
    public function verify(Request $request)
    {
        $data = $request->all();
        try {
            SeckillService::modify($data);
            return $this->success("修改成功", url('/admin/seckill/list'));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
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
        $seckill_goods = SeckillService::getSeckillGoods(['pageSize' => $pageSize, 'page' => $currpage], ['seckill_id' => $id]);
        return $this->display('admin.seckill.detail', [
            "seckill_goods" => $seckill_goods['list'],
            'total' => $seckill_goods['total'],
            'currpage' => $currpage,
            'pageSize' => $pageSize,
            'pcurrpage' => $pcurrpage,
            'review_status' => $review_status,
            'id' => $id,
        ]);
    }

    //删除秒杀申请
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try {
            $flag = SeckillService::deleteSellerSeckill($id);
            if ($flag) {
                return $this->success("删除成功", url("/admin/seckill/list"));
            }
            return $this->error("删除失败");
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //秒杀时段列表
    public function timeList(Request $request)
    {
        $currpage = $request->input("currpage", 1);
        $pageSize = 10;
        $seckill_time = SeckillService::getSeckillTimeList(['pageSize' => $pageSize, 'page' => $currpage], []);
        //dd($seckill_time);
        return $this->display('admin.seckill.timelist', [
            "seckill_time" => $seckill_time['list'],
            'total' => $seckill_time['total'],
            'currpage' => $currpage,
            'pageSize' => $pageSize,
        ]);
    }

    //添加秒杀时段
    public function addTime(Request $request)
    {
        //查询id最大值
        return $this->display('admin.seckill.addtime');
    }

    //编辑秒杀时段
    public function editTime(Request $request)
    {
        //查询id最大值
        $id = $request->input('id');
        $currpage = $request->input('currpage');
        $time = SeckillService::getSeckillTimeInfo($id);
        return $this->display('admin.seckill.edittime', [
            'time' => $time,
            'currpage' => $currpage
        ]);
    }

    //保存
    public function saveTime(Request $request)
    {
        $data = $request->all();
        if (strtotime($data['end_time']) <= strtotime($data['begin_time'])) {
            return $this->error("结束时间必须大于开始时间");
        }
        try {
            if (!key_exists('id', $data)) {
                $time = SeckillService::createSeckillTime($data);
                if (empty($time)) {
                    return $this->error("添加失败");
                }
                return $this->success("添加成功", url("/admin/seckill/time/list"));
            } else {
                $time = SeckillService::modifySeckillTime($data);
                if (empty($time)) {
                    return $this->error("修改失败");
                }
                return $this->success("修改成功", url("/admin/seckill/time/list"));
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    //删除秒杀时间段
    public function deleteTime(Request $request)
    {
        $id = $request->input('id');
        try {
            $flag = SeckillService::deleteTime($id);
            if ($flag) {
                return $this->success("删除成功", url("/admin/seckill/time/list"));
            }
            return $this->error("删除失败");
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
