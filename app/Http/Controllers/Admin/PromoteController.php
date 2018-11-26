<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $pageSize = 10;
        $condition = [];
        if(!empty($shop_name)){
            $condition['shop_name'] = "%".$shop_name."%";
        }
        $promotes = ActivityService::getListBySearch(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);
        //dd($seckills);
        return $this->display('admin.promote.list',[
            'promotes'=>$promotes['list'],
            'total'=>$promotes['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'shop_name'=>$shop_name
        ]);
    }

    //添加
    public function addForm(Request $request)
    {
        $shops = ShopService::getShopList([],['is_validated'=>1,'is_freeze'=>0]);
        return $this->display('admin.promote.add',[
            'shops'=>$shops['list'],
        ]);
    }

    //编辑
    public function editForm(Request $request){
        $id = $request->input("id");
        $currpage = $request->input("currpage");
        $promote = ActivityService::getInfoById($id);
        $shops = ShopService::getShopList([],[]);
        $goods_info = GoodsService::getGoodInfo($promote['goods_id']);
        return $this->display('admin.promote.edit',[
            'promote'=>$promote,
            'goods_info'=>$goods_info,
            'currpage'=>$currpage,
            'shops'=>$shops['list']
        ]);

    }

    //保存优惠活动
    public function save(Request $request)
    {
        $data = $request->all();
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
                $flag = ActivityService::create($data);
                if(empty($flag)){
                    return $this->error("添加失败");
                }
                return $this->success("添加成功",url("/admin/promote/list"));
            }else{
                $currpage = $data['currpage'];
                unset($data['currpage']);
                $flag = ActivityService::updateById($data['id'],$data);
                if(empty($flag)){
                    return $this->error("修改失败");
                }
                return $this->success("修改成功",url("/admin/promote/list")."?currpage=".$currpage);
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
        $promote = ActivityService::getInfoById($id);
        return $this->display('admin.promote.detail',[
            'promote'=>$promote,
            'currpage'=>$currpage
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
        try{
            $flag = ActivityService::delete($id);
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
        return $this->result($cates,200,'获取数据成功');
    }

    //ajax获取商品值
    public function getGood(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $goods_name = $request->input('goods_name');
        $condition = [];
        if($cat_id!="" || $cat_id!=0){
            $condition['cat_id'] = $cat_id;
        }
        if($goods_name!=""){
            $condition['goods_name'] = "%".$goods_name."%";
        }
        $goods = GoodsService::getGoods($condition,['id','goods_name','packing_spec','goods_full_name','packing_unit']);
        if(!empty($goods)){
            return $this->result($goods,200,'获取数据成功');
        }else{
            return $this->result([],400,'没有查询到数据');
        }

    }

    //ajax获取商家列表
    public function getShopList()
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
