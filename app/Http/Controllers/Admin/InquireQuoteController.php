<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\InquireService;
use App\Services\GoodsService;
use App\Services\GoodsCategoryService;
use App\Services\InquireQuoteService;
class InquireQuoteController extends Controller
{
    //列表
    public function index(Request $request)
    {
        $currpage = $request->input("currpage",1);
        $quote_currpage = $request->input("quote_currpage",1);
        $pageSize = $request->input('pageSize ',10);
        $goods_name = $request->input('goods_name','');
        $inquire_id = $request->input('inquire_id');
        $condition['is_delete'] = 0;
        $condition['inquire_id'] = $inquire_id;
        if(!empty($goods_name)){
            $condition['goods_name'] = "%".$goods_name."%";
        }
        $inquire_quotes = InquireQuoteService::getInquireQuoteList(['pageSize'=>$pageSize,'page'=>$currpage,'orderType'=>['add_time'=>'desc']],$condition);

        return $this->display('admin.inquire.quote_list',[
            'inquire_quotes'=>$inquire_quotes['list'],
            'total'=>$inquire_quotes['total'],
            'pageSize'=>$pageSize,
            'currpage'=>$currpage,
            'goods_name'=>$goods_name,
            'quote_currpage'=>$quote_currpage
        ]);
    }

    //修改状态
    public function modifyShowStatus(Request $request)
    {
        $id = $request->input("id");
        $is_show = $request->input("val", 0);
        try{
            InquireService::modify(['id'=>$id,'is_show' => $is_show]);
            return $this->success("修改成功");
        }catch(\Exception $e){
            return  $this->error($e->getMessage());
        }
    }

    //添加
    public function add(Request $request)
    {
        return $this->display('admin.inquire.add');
    }

    //编辑
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $currpage = $request->input('currpage',1);
        $inquire = InquireService::getInquireInfo($id);
        $goods = GoodsService::getGoodInfo($inquire['goods_id']);
        return $this->display('admin.inquire.edit',[
            'inquire'=>$inquire,
            'currpage'=>$currpage,
            'goods'=>$goods
        ]);
    }

    //保存
    public function save(Request $request)
    {
        $data = $request->all();
        unset($data['cat_id']);
        unset($data['cat_id_LABELS']);
        $errorMsg = [];
        if(empty($data['goods_id'])){
            $errorMsg[] = '商品不能为空';
        }
        if(empty($data['num'])){
            $errorMsg[] = '数量不能为空';
        }
        if(empty($data['price'])){
            $errorMsg[] = '价格不能为空';
        }
        if(empty($data['delivery_area'])){
            $errorMsg[] = '交货地不能为空';
        }
        if(empty($data['contacts'])){
            $errorMsg[] = '联系人不能为空';
        }
        if(empty($data['contacts_mobile'])){
            $errorMsg[] = '联系人手机号不能为空';
        }
        if(!empty($errorMsg)){
            return $this->error(implode("|",$errorMsg));
        }
        try{
            if(!key_exists('id',$data)){
                $goods = GoodsService::getGoodInfo($data['goods_id']);
                $goods_cate = GoodsCategoryService::getInfo($goods['cat_id']);
                $data['add_time'] = Carbon::now();
                $data['goods_name'] = $goods['goods_full_name'];
                $data['unit_name'] = $goods['unit_name'];
                $data['brand_name'] = $goods['brand_name'];
                $data['cat_name'] = $goods_cate['cat_name'];
                $flag = InquireService::create($data);
                if(!empty($flag)){
                    return $this->success('添加成功',url('/admin/inquire/index'));
                }
                return $this->error('添加失败');
            }else{
                $goods = GoodsService::getGoodInfo($data['goods_id']);
                $goods_cate = GoodsCategoryService::getInfo($goods['cat_id']);
                $data['goods_name'] = $goods['goods_full_name'];
                $data['unit_name'] = $goods['unit_name'];
                $data['brand_name'] = $goods['brand_name'];
                $data['cat_name'] = $goods_cate['cat_name'];
                $currpage = $data['currpage'];
                unset($data['currpage']);
                $flag = InquireService::modify($data);
                if(!empty($flag)){
                    return $this->success('修改成功',url('/admin/inquire/index')."?currpage=".$currpage);
                }
                return $this->error('修改失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    //删除
    public function delete(Request $request)
    {
        $id = $request->input('id');
        try{
            $flag = InquireService::modify(['id'=>$id,'is_delete'=>1]);
            if($flag){
                return $this->success('删除成功',url('/admin/inquire/index'));
            }else{
                return $this->error('删除失败');
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
