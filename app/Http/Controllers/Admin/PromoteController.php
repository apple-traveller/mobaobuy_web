<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderInfoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\ActivityService;
use App\Services\ShopService;
use App\Services\GoodsService;
use App\Services\GoodsCategoryService;
class PromoteController extends Controller
{
    //列表
    public function getList(Request $request)
    {
        $currpage = $request->input('currpage',1);
        $shop_name = $request->input('shop_name');
        $is_expire = $request->input('is_expire',0);
        $condition = [];
        if($is_expire!=0){
            if($is_expire==1){
                $condition['end_time|>'] = Carbon::now();//未过期
            }else{
                $condition['end_time|<'] = Carbon::now();//已过期
            }
        }
        $pageSize = 10;
        if(!empty($shop_name)){
            $condition['shop_name'] = "%".$shop_name."%";
        }
        $condition['is_delete'] = 0;
        $promotes = ActivityService::getListBySearch(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        $goods_unit = "KG";
        if(!empty($promotes['list'])){
            $goods_unit = GoodsService::getGoodInfo($promotes['list'][0]['goods_id'])['unit_name'];
        }
        return $this->display('admin.promote.list',[
            'promotes'=>$promotes['list'],
            'total'=>$promotes['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'shop_name'=>$shop_name,
            'is_expire'=>$is_expire,
            'goods_unit'=>$goods_unit
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        $condition = [
            'is_validated' => 1,
            'is_freeze' => 0,
        ];

        $shops = ShopService::getList([],$condition);

        return $this->display('admin.promote.add',[
            'shops'=>$shops,
        ]);
    }

    //编辑
    public function editForm(Request $request){
        $id = $request->input("id");
        $currpage = $request->input("currpage");
        $is_expire = $request->input('is_expire');
        $promote = ActivityService::getInfoById($id);

        $condition = [
            'is_validated' => 1,
            'is_freeze' => 0,
        ];
        $shops = ShopService::getList([],$condition);
        $goods_info = GoodsService::getGoodInfo($promote['goods_id']);
        return $this->display('admin.promote.edit',[
            'promote'=>$promote,
            'goods_info'=>$goods_info,
            'currpage'=>$currpage,
            'shops'=>$shops,
            'is_expire'=>$is_expire
        ]);

    }

    //保存优惠活动
    public function save(Request $request)
    {
        $request->flash();
        $data = $request->all();
        unset($data['cat_id']);
        unset($data['cat_id_LABELS']);
        $errorMsg=[];
        if(empty($data['shop_id'])){
            $errorMsg[] = "商家不能为空";
        }
        if(empty($data['goods_id'])){
            $errorMsg[] = "商品不能为空";
        }
        if(empty($data['begin_time'])){
            $errorMsg[] = "开始时间不能为空";
        }
        if(empty($data['end_time'])){
            $errorMsg[] = "结束时间不能为空";
        }
        if(strtotime($data['end_time'])<strtotime($data['begin_time'])){
            $errorMsg[] = "结束时间不能小于开始时间";
        }
        if(empty($data['price'])){
            $errorMsg[] = "促销价格不能为空";
        }
        if(empty($data['num'])){
            $errorMsg[] = "促销总数量不能为空";
        }

        if(empty($data['min_limit'])){
            $errorMsg[] = "最小起售数量不能为空";
        }

        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }

        try{
            if(!key_exists('id',$data)){
                $data['add_time'] = Carbon::now();
                $data['available_quantity'] = $data['num'];
                $flag = ActivityService::create($data);
                if(empty($flag)){
                    return $this->error("添加失败");
                }
                return $this->success("添加成功",url("/admin/promote/list"));
            }else{
                $currpage = $data['currpage'];
                $is_expire = $data['is_expire'];
                if($data['available_quantity']>$data['num']){
                    return $this->error('当前可售数量不能大于总数量');
                }
                unset($data['currpage']);
                unset($data['is_expire']);
                $flag = ActivityService::updateById($data['id'],$data);
                if(empty($flag)){
                    return $this->error("修改失败");
                }
                return $this->success("修改成功",url("/admin/promote/list")."?currpage=".$currpage."&is_expire=".$is_expire);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    //查看商品信息
    public function detail(Request $request)
    {
        $id = $request->input("id");
        $currpage = $request->input("currpage");
        $is_expire = $request->input('is_expire');
        $promote = ActivityService::getInfoById($id);
        $goods_info = GoodsService::getGoodInfo($promote['goods_id']);
        return $this->display('admin.promote.detail',[
            'promote'=>$promote,
            'currpage'=>$currpage,
            'goods_info'=>$goods_info,
            'is_expire'=>$is_expire
        ]);
    }

    //审核
    public function verify(Request $request)
    {
        $data = $request->all();
        try{
            ActivityService::updateById($data['id'],$data);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //删除优惠活动申请
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return $this->error('无法获取参数ID');
        }
        try{
            $check = ActivityService::getInfoById($id);
            if(!$check){
                return $this->error('活动信息不存在');
            }
            $is_exist_order = OrderInfoService::checkActivityExistOrder($id,'promote');
            if($is_exist_order){
                return $this->error('该活动存在相应订单，无法删除');
            }
            $flag = ActivityService::updateById($id,['is_delete'=>1]);
            if($flag){
                return $this->success("删除成功",url("/admin/promote/list"));
            }
            return $this->error("删除失败");
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //ajax获取商品分类
    public function getGoodsCat(Request $request)
    {
        $cat_name = $request->input('cat_name');
        $condition = [];
        if($cat_name!=""){
            $condition['cat_name'] = "%".$cat_name."%";
        }
        $cates = GoodsCategoryService::getCatesByCondition($condition);
        return $this->success('success','',$cates);
    }

    //ajax获取商品值
    public function getGood(Request $request)
    {
        $cat_id = trim($request->input('cat_id'));
        $goods_name = $request->input('goods_name');
        $condition['is_delete'] = 0;
        if($cat_id!="" && $cat_id!=0){
            $cates = GoodsCategoryService::getCates();
            $cate_ids = GoodsCategoryService::getChilds($cates,$cat_id);
            $cate_ids[] = $cat_id;
            $condition['cat_id'] = implode('|',$cate_ids);
        }
        if($goods_name!=""){
            $c['opt'] = "OR";
            $c['goods_full_name'] = "%".$goods_name."%";
            $c['goods_sn'] = $goods_name;
            $c['brand_name'] = $goods_name;
            $c['goods_model'] = $goods_name;
            $condition[] = $c;
        }
        $goods = GoodsService::getGoods($condition,['id','goods_name','packing_spec','goods_full_name','packing_unit','unit_name','min_limit']);
        if(!empty($goods)){
            return $this->success('success','',$goods);
        }else{
            return $this->error('error');
        }
    }

    //ajax获取商家列表
    public function getShopList(Request $request)
    {
        $condition = [
            'is_validated' => 1,
            'is_freeze' => 0,
        ];

        $res = ShopService::getList([],$condition);
        if($res){
            return $this->success('成功！','',$res);
        }
        return $this->error();
    }

}
